<?php

namespace App\Filters;

use Closure;

class PreferredSourceFilter
{
    public function handle($query, Closure $next)
    {
        if (request()->has('preferred_sources')) {
            $sources = request('preferred_sources');
            $sources = explode(',',  $sources); // Split the string by comma
            $query->whereIn('source_name', $sources);
        }

        return $next($query);
    }
}
