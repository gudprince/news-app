<?php

namespace App\Filters;

use Closure;

class SourceFilter
{
    public function handle($query, Closure $next)
    {
        if (request()->has('source')) {
            $query->where('source_name', request('source'));
        }

        return $next($query);
    }
}
