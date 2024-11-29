<?php

return [

    'news_api' => [
        'name' => 'NewsAPI',
        'url' => 'https://newsapi.org/v2',
        'api_key' => env('NEWS_API_KEY', '2820e2b6cb3f4d5eb3d9d619231e96cc')
    ],
    'bbc' => [
        'name' => 'BBC News',
        'url' => 'https://example-bbc-api.com/v1/news',
        'api_key' => env('BBC_API_KEY')
    ],
    'open_news' => [
        'name' => 'OpenNews',
        'url' => 'https://api.opennews.org/v1/articles',
        'api_key' => env('OPEN_NEWS_KEY')
    ],
    'new_york_times' => [
        'name' => 'New York Times',
        'url' => 'https://api.nytimes.com/svc/news/v3/content/all/all.json',
        'api_key' => env('NEW_YORK_TIMES_API_KEY', 'vRNVmbBCrEi5FHgYN2QQSIytcRMls4Ul')
    ],
    'guardian' => [
        'name' => 'guardian',
        'url' => 'https://content.guardianapis.com/search',
        'api_key' => env('GUARDIAN_API_KEY', 'c8975408-468e-4a2c-b89d-778879d7568e')
    ],
    
];
