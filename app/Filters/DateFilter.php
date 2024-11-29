<?php

namespace App\Filters;

use Closure;

class DateFilter
{
    public function handle($query, Closure $next)
    {
        $startDate = request('start_date');
        $endDate = request('end_date');
    
        if ($startDate && $endDate) {
            $query->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate);
        } elseif ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        } elseif ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }
    
        return $next($query);
    }
}
