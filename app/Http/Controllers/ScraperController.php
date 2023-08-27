<?php

namespace App\Http\Controllers;

use Goutte\Client;
use App\Models\Book;
use GuzzleHttp\Promise;
use App\Jobs\ScrapingJob;
use Illuminate\Http\Request;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\Http;

class ScraperController extends Controller
{
    public function index() {
        $books = Book::paginate(15);
        $booksCount = Book::get()->count();

        return view('index', compact('books', 'booksCount'));
    }

    public function loadMore () {
        ScrapingJob::dispatch();

        return redirect()
            ->route('home');
    }
}
