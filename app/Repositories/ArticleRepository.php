<?php

namespace App\Repositories;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ArticleRepository
{
    public function getArticles(Request $request)
    {
        $perPage = $request->perPage ?? 10;
        $query = Article::query()->with(['category:id,name']);

        return app(Pipeline::class)
            ->send($query)
            ->through([
                \App\Filters\SearchFilter::class,
                \App\Filters\SourceFilter::class,
                \App\Filters\CategoryFilter::class,
                \App\Filters\DateFilter::class,
                \App\Filters\AuthorFilter::class,
                \App\Filters\PreferredCategoryFilter::class,  // User's preferred categories
                \App\Filters\PreferredSourceFilter::class,    // User's preferred sources
                \App\Filters\PreferredAuthorFilter::class,  
            ])
            ->thenReturn()
            ->latest('created_at')
            ->paginate($perPage);
    }

    public function save($article)
    {
        $category = Category::firstOrCreate(['name' => $article['category_name']]);
        $publish_at = Carbon::parse($article['published_at'])->format('Y-m-d H:i:s');

        //check if title and description is not empty because some api return empty title
        if ($article['title']) {
            Article::updateOrCreate(
                ['article_url' => $article['article_url']],
                [
                    'title' => $article['title'],
                    'description' => $article['description'] ?? '',
                    'author' => $article['author'],
                    'published_at' => $publish_at,
                    'category_id' =>  $category->id,
                    'article_url' => $article['article_url'],
                    'image_url' => $article['image_url'],
                    'source_name' => $article['source_name'],
                    'slug' => $article['slug'],
                ]
            );
        }
    }

    public function show($id)
    {
        $article = Article::where('id', $id)->with(['category:id,name'])->first();

        return $article;
    }

    public function update($id, $data)
    {

        $article = Article::find($id);

        if ($article) {
            return $article->update($data);
        }

        return false;
    }

    public function destroy($id)
    {
        $article = Article::find($id);

        if ($article) {
            return $article->delete();
        }

        return false;
    }
}
