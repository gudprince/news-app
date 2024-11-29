<?php

namespace App\Services\News;

use Illuminate\Support\Facades\Http;
use Exception;

class NewYorkTimesService extends NewsSourceService
{
    protected $baseUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('news_sources.new_york_times.url');
        $this->apiKey = config('news_sources.new_york_times.api_key');
    }

    public function fetchArticles(): array
    {   
        try {
            $url = "{$this->baseUrl}?api-key={$this->apiKey}";
            $response = Http::get($url);

            if ($response->successful()) {
                $articles = $response->json()['results'] ?? [];

                return array_map(function ($article) {
                    $image = count($article['multimedia']) > 0 ? $article['multimedia'][0] : '';
                    $data = [
                        'title' => $article['title'],
                        'description' => $article['abstract'],
                        'author' => $article['byline'],
                        'published_at' => $article['published_date'] ?? now(),
                        'category_name' => $article['section'],
                        'url' => $article['url'],
                        'image_url' => is_array($image) ? $image['url'] : '',
                        'source' => 'New York Times',
                    ];

                    return $this->normalizeArticle($data);
                }, $articles);
            }

            return [];
        } catch (Exception $e) {
            logger()->error('An error occurred while fetching articles from New York Times API: ' . $e->getMessage());

            return [];
        }
    }
}
