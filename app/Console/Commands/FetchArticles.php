<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Console\Command;
use App\Repositories\ArticleRepository;
use App\Services\News\NewsAggregatorService;

class FetchArticles extends Command
{
    protected $signature = 'articles:fetch';
    protected $description = 'Fetch articles from multiple news sources';

    protected $newsAggregatorService;
    protected $articlesrticleRepository;

    public function __construct(NewsAggregatorService $newsAggregatorService, ArticleRepository $articlesrticleRepository)
    {
        parent::__construct();
        $this->newsAggregatorService = $newsAggregatorService;
        $this->articlesrticleRepository = $articlesrticleRepository;
    }

    public function handle()
    {
        $articles = $this->newsAggregatorService->fetchAllArticles();

        foreach ($articles as $article) {
            $this->articlesrticleRepository->save($article);
        }

        $this->info('Articles fetched and stored successfully.');

        return 0;
    }
}

