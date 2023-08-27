<?php
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Cache;
use GuzzleHttp\Client;
use App\Models\Book;
use Symfony\Component\DomCrawler\Crawler;

class ScrapingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $client = new Client([
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/93.0.4577.63 Safari/537.36',
            ],
        ]);

        $baseUri = 'https://www.kotobati.com/section/%D8%B1%D9%88%D8%A7%D9%8A%D8%A7%D8%AA';
        $currentPagePath = '?page=' . $this->getPageCounter(); // Append the page number

        $response = $client->get($baseUri . $currentPagePath);
        $body = $response->getBody();

        $crawler = new Crawler($body, $baseUri);

        $batchSize = 100; // Batch size for batch insertion
        $batch = [];

        $crawler->filter(".section-page .row .info .views-infinite-scroll-content-wrapper .views-row")->each(
            function ($book) use(&$batch, $batchSize, $client) {
                $title = $book->filter('.book-teaser h3 a')->text();
                $author = $book->filter('.book-teaser p a')->text();
                $link = $book->filter('.book-teaser a');

                $internalUri = 'https://www.kotobati.com';
                $response = $client->get($internalUri . $link->attr('href'));
                $body = $response->getBody();

                $book_crawler = new Crawler($body, $internalUri . $link->attr('href'));
                $book_details = $book_crawler->filter('article .article-body .container-site .info .media .media-body ul');
                $liElements = $book_details->filter('li');
                
                $pages_count = $liElements->eq(0)->filter('p')->eq(1)->text();
                $language = $liElements->eq(1)->filter('p')->eq(1)->text();
                $size = ($liElements->count() > 2 && $liElements->eq(2)->filter('p')->count() > 1) ? $liElements->eq(2)->filter('p')->eq(1)->text() : '';
                
                $file_link = $book_crawler->filter('article .article-body .container-site .info .row')->eq(2)
                    ->filter('.col-md-12');

                dd($file_link->count());

                $batch[] = [
                    'title' => $title,
                    'author' => $author,
                    'file_path' => "test_path",
                    'pages_count' => $pages_count,
                    'language' => $language,
                    'size' => $size,
                ];

                // Check if the batch size is reached and perform batch insertion
                if (count($batch) >= $batchSize) {
                    Book::insert($batch);
                    $batch = [];
                }
            }
        );

        // Insert any remaining records
        if (!empty($batch)) {
            Book::insert($batch);
        }

        // Increment the page counter stored in cache
        $this->incrementPageCounter();
    }

     /**
     * Get the current page counter from cache
     *
     * @return int
     */
    protected function getPageCounter(): int
    {
        return Cache::get('page_counter', 0);
    }

    /**
     * Increment the page counter in cache
     */
    protected function incrementPageCounter(): void
    {
        Cache::increment('page_counter', 1);
    }
}

