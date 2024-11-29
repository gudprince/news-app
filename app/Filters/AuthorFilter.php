<?php

namespace App\Filters;

use Closure;

class AuthorFilter
{
    public function handle($query, Closure $next)
    {
        if (request()->has('author')) {
            $author = request('author');
            $query->where('author', 'like', '%' . $author . '%');
        }

        return $next($query);
    }
}
