<?php

namespace App\Filters;

use Closure;

class SearchFilter
{
    public function handle($query, Closure $next)
    {
        if (request()->has('search')) {
            $query->where(function ($subQuery) {
                $searchTerm = request('search');
                $subQuery->where('title', 'like', '%' . $searchTerm . '%')
                         ->orWhere('description', 'like', '%' . $searchTerm . '%');
            });
        }

        return $next($query);
    }
}
