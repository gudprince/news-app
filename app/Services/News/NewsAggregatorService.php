<?php

namespace App\Services\News;

use Illuminate\Pipeline\Pipeline;
use App\Services\News\BBCNewsService;
use App\Services\News\NewsApiService;
use App\Services\News\GuardianService;
use App\Services\News\OpenNewsService;
use App\Services\News\NewYorkTimesService;
use Exception;

class NewsAggregatorService
{
    protected $services;

    public function __construct(
        NewsAPIService $newsAPIService,
        NewYorkTimesService $newYorkTimesService,
        GuardianService $guardianService
    ) {
        $this->services = [
            $newsAPIService,
            $newYorkTimesService,
            $guardianService
        ];
    }

    public function fetchAllArticles(): array
    {   
        try {
            $articles = [];

            // Fetch articles from each service and merge them
            foreach ($this->services as $service) {
                $fetchedArticles = $service->fetchArticles();
                if (is_array($fetchedArticles)) {
                    $articles = array_merge($articles, $fetchedArticles);
                }
            }

            return $articles;

        } catch (Exception $e) {
            logger()->error('An error occurred while merging news data from API: ' . $e->getMessage());

            return [];
        }

        
    }
}
