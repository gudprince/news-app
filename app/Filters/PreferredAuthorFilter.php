<?php

namespace App\Filters;

use Closure;

class PreferredAuthorFilter
{
    public function handle($query, Closure $next)
    {
        if (request()->has('preferred_authors')) {
                $query->where(function ($subQuery) {
                    $authors = explode(',', request('preferred_authors')); // Split the string by comma
                    foreach ($authors as $author) {
                        $authors = explode(',', request('preferred_authors'));
                        $subQuery->Orwhere('author', 'like', '%' . trim($author) . '%');
                    }
                });
        }

        return $next($query);
    }
}
