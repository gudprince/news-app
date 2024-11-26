<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class NewsApiService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.newsapi.key');
    }

    public function fetchArticles()
    {
        $response = Http::get("https://newsapi.org/v2/top-headlines", [
            'apiKey' => $this->apiKey,
            'country' => 'us',
        ]);

        if ($response->successful()) {
            return $response->json()['articles'];
        }

        return [];
    }
}
