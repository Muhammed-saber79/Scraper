<?php

namespace App\Http\Controllers;

use Goutte\Client;
use Illuminate\Http\Request;

class ScraperController extends Controller
{
    public function index () {
        $client = new Client();

        $website = $client->request('GET', 'https://www.kotobati.com/section/%D8%B1%D9%88%D8%A7%D9%8A%D8%A7%D8%AA');
        return $website->html();
    }
}
