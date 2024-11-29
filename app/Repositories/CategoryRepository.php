<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository
{
    public function index()
    {   
        $category = Category::select('id', 'name')->orderBy('name', 'asc')->get();

        return $category->toArray();
        
    }
}
