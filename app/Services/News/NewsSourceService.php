<?php

namespace App\Services\News;

use Illuminate\Support\Str;

abstract class NewsSourceService
{
    abstract public function fetchArticles(): array;

    protected function normalizeArticle(array $article): array
    {
        return [
            'title' => $article['title'],
            'description' => $article['description'],
            'author' => $article['author'],
            'published_at' => $article['published_at'] ?? now(),
            'category_name' => $article['category_name'] ?? '',
            'article_url' => $article['url'] ?? '',
            'image_url' => $article['image_url'] ?? '',
            'source_name' => $article['source'] ?? '',
            'slug' => Str::slug($article['title']),
        ];
    }
}
