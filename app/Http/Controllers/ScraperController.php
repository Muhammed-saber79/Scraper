<?php

namespace App\Http\Controllers;

use Goutte\Client;
use Illuminate\Http\Request;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Promise;

class ScraperController extends Controller
{
    public function index() {
        $client = new \GuzzleHttp\Client();
        $data = [];
        $concurrentRequests = 10; // Number of requests to be made concurrently
        $baseUri = 'https://www.kotobati.com'; // Base URL of the website
        $initialPagePath = '/section/%D8%B1%D9%88%D8%A7%D9%8A%D8%A7%D8%AA';
        $currentPagePath = $initialPagePath;
        
        do {
            $promises = [];
    
            // Create promises for multiple pages
            for ($i = 0; $i < $concurrentRequests; $i++) {
                $promises[] = $client->getAsync($baseUri . $currentPagePath);
            }
    
            // Wait for all promises to resolve
            $responses = Promise\Utils::unwrap($promises);
    
            foreach ($responses as $response) {
                $body = $response->getBody();
    
                // Create a crawler from the response body
                $crawler = new \Symfony\Component\DomCrawler\Crawler($body, $baseUri);
    
                // Process the crawler and extract data
                $booksDiv = $crawler
                    ->filter(".section-page .row .info .views-infinite-scroll-content-wrapper .views-row ")
                    ->each(function ($book) use (&$data, $baseUri) {
                        $link = $baseUri . $book->filter('.book-teaser a')->attr('href');
                        $title = $book->filter('.book-teaser h3 a')->text();
                        $author = $book->filter('.book-teaser p a')->text();
        
                        $bookObject = [
                            'link' => $link,
                            'title' => $title,
                            'author' => $author,
                        ];
        
                        $data[] = $bookObject;
                    });
    
                // Update $currentPagePath based on pagination logic
                $moreBtn = $crawler->filter('.js-pager__items .pager__item a');

                if ($moreBtn) {
                    $currentPagePath .= $moreBtn->attr('href');
                    // dd($currentPagePath);
                } else {
                    $currentPagePath = null;
                }
            }
        } while ($currentPagePath);
    
        return count($data);
    }
}
