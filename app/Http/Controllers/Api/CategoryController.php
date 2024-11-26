<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Traits\ApiResponse;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    use ApiResponse;

    public function index()
    {
        try {
            $categories = Category::all();
            return $this->successResponse($categories, 'Categories fetched successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to fetch categories', 500, $e->getMessage());
        }
    }
}
