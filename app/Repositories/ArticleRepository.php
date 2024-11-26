<?php

namespace App\Repositories;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Pipeline\Pipeline;

class ArticleRepository
{
    public function getArticles()
    {
        $query = Article::query()->with('category');

        return app(Pipeline::class)
            ->send($query)
            ->through([
                \App\Filters\SourceFilter::class,
                \App\Filters\CategoryFilter::class,
                \App\Filters\DateFilter::class,
            ])
            ->thenReturn()
            ->latest('published_at')
            ->paginate(10);
    }

    public function saveArticles(array $articles)
    {
        foreach ($articles as $article) {
            // Determine category (example: based on source name)
            $categoryName = $article['source']['name'];
            $category = Category::firstOrCreate(['name' => $categoryName]);

            Article::updateOrCreate(
                ['url' => $article['url']],
                [
                    'title' => $article['title'],
                    'description' => $article['description'],
                    'author' => $article['author'] ?? 'Unknown',
                    'source_name' => $categoryName,
                    'published_at' => $article['publishedAt'],
                    'category_id' => $category->id,
                ]
            );
        }
    }
}
