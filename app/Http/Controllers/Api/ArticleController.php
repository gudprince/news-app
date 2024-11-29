<?php

namespace App\Http\Controllers\Api;

use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Repositories\ArticleRepository;
use App\Http\Requests\UpdateArticleRequest;

class ArticleController extends Controller
{
    use ApiResponse;

    protected $repository;

    public function __construct(ArticleRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Fetch all the articles.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $articles = $this->repository->getArticles($request);
            $message = $articles->isEmpty() ? 'No articles found.' : 'Articles fetched successfully';

            return $this->successResponse($articles, $message);
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to fetch articles', 500, $e->getMessage());
        }
    }

    /**
     * Find the specified article.
     */
    public function show($id): JsonResponse
    {
        try {
            $articles = $this->repository->show($id);

            if (!$articles) {
                return $this->notFoundResponse('Article not found');
            }

            return $this->successResponse($articles, 'Article fetched successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to fetch article', 500, $e->getMessage());
        }
    }

    /**
     * Update the specified article.
     */
    public function update($id, UpdateArticleRequest  $request): JsonResponse
    {
        try {
            $articles = $this->repository->update($id,  $request->validated());

            if (!$articles) {
                return $this->notFoundResponse('Article not found');
            }

            return $this->successResponse(null, 'Article updated successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to update article', 500, $e->getMessage());
        }
    }

    /**
     * Delte the specified article.
     */
    public function destroy($id): JsonResponse
    {
        try {
            $articles = $this->repository->destroy($id);

            if (!$articles) {
                return $this->notFoundResponse('Article not found');
            }

            return $this->successResponse(null, 'Article deleted successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to delte article', 500, $e->getMessage());
        }
    }
}
