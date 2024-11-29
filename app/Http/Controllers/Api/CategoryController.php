<?php

namespace App\Http\Controllers\Api;

use App\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Repositories\CategoryRepository;
use Illuminate\Http\JsonResponse;


class CategoryController extends Controller
{
    use ApiResponse;

    protected $repository;

    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Fetch all the articles.
     */
    public function index(): JsonResponse
    {
        try {
            $categories = $this->repository->index();

            return $this->successResponse($categories, 'Categories fetched successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to fetch categories', 500, $e->getMessage());
        }
    }
}
