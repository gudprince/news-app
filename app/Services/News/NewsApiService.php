<?php

namespace App\Services\News;

use Illuminate\Support\Facades\Http;
use Exception;

class NewsApiService extends NewsSourceService
{
    protected $baseUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('news_sources.news_api.url');
        $this->apiKey = config('news_sources.news_api.api_key');
    }

    public function fetchArticles(): array
    {   
        try {
            $url = "{$this->baseUrl}/top-headlines?language=en&apiKey={$this->apiKey}";
            $response = Http::get($url);

            if ($response->successful()) {
                $articles = $response->json()['articles'] ?? [];

                return array_map(function ($article) {
                    $data = [
                        'title' => $article['title'],
                        'description' => $article['content'],
                        'author' => $article['author'],
                        'published_at' => $article['publishedAt'] ?? now(),
                        'category_name' => 'General',
                        'url' => $article['url'],
                        'image_url' => $article['urlToImage'],
                        'source' => 'News API',
                    ];

                    return $this->normalizeArticle($data);
                }, $articles);
            }

            return [];

        } catch (Exception $e) {
            logger()->error('An error occurred while fetching articles from News Api: ' . $e->getMessage());

            return [];
        }
    }
}
