<?php

namespace App\Services\News;

use Illuminate\Support\Facades\Http;
use Exception;

class GuardianService extends NewsSourceService
{
    protected $baseUrl;
    protected $apiKey;

    public function __construct()
    {

        $this->baseUrl = config('news_sources.guardian.url');
        $this->apiKey = config('news_sources.guardian.api_key');
    }

    public function fetchArticles(): array
    {  
        try {
            $url = "{$this->baseUrl}?api-key={$this->apiKey}";
            $response = Http::get($url);

            if ($response->successful()) {
                $articles = $response->json()['response'] ?? [];
                $articles = $articles ? $articles['results'] :  [];

                return array_map(function ($article) {

                    $data = [
                        'title' => $article['webTitle'],
                        'description' => '', //no description preperty for this api
                        'author' => '', //no author preperty for this api
                        'published_at' => $article['webPublicationDate'] ?? now(),
                        'category_name' => $article['sectionName'],
                        'url' => $article['webUrl'],
                        'image_url' => '', //no image preperty for this api,
                        'source' => 'Guardian',
                    ];

                    return $this->normalizeArticle($data);
                }, $articles);
            }

            return [];

        } catch (Exception $e) {
            logger()->error('An error occurred while fetching articles from Guardian API: ' . $e->getMessage());

            return [];
        }
    }
}
