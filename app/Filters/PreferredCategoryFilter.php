<?php

namespace App\Filters;

use Closure;

class PreferredCategoryFilter
{
    public function handle($query, Closure $next)
    {
        if (request()->has('preferred_categories')) {
            $query->whereHas('category', function ($q) {
                $categories = explode(',', request('preferred_categories')); // Split the string by comma
                $q->whereIn('name', $categories);
            });
        }

        return $next($query);
    }
}
