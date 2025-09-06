<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default search index
    |--------------------------------------------------------------------------
    |
    | This option controls the search index that gets queried when performing
    | search functions without explicitly selecting another index.
    |
    */

    'default' => env('STATAMIC_DEFAULT_SEARCH_INDEX', 'default'),

    /*
    |--------------------------------------------------------------------------
    | Search Indexes
    |--------------------------------------------------------------------------
    |
    | Here you can define all of the available search indexes.
    |
    */

    'indexes' => [

        'default' => [
            'driver' => 'local',
            'searchables' => ['collection:pages', 'collection:articles', 'collection:products'],
            'fields' => ['title', 'content', 'excerpt', 'tags', 'description', 'date', 'type', 'topic', 'role'],
            'filter' => \App\SearchFilters\PublishedFilter::class,
            'transformers' => [
                'content' => \App\SearchFilters\Transform::class,
            ],
        ],

        'articles' => [
            'driver' => 'local',
            'searchables' => 'collection:articles',
            'fields' => ['title', 'content', 'excerpt', 'tags', 'date', 'type', 'topic', 'role'],
            'filter' => \App\SearchFilters\PublishedFilter::class,
        ],

        'products' => [
            'driver' => 'local',
            'searchables' => 'collection:products',
            'fields' => ['title', 'content', 'excerpt', 'tags', 'date', 'type', 'topic', 'role'],
            'filter' => \App\SearchFilters\PublishedFilter::class,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Driver Defaults
    |--------------------------------------------------------------------------
    |
    | Here you can specify default configuration to be applied to all indexes
    | that use the corresponding driver. For instance, if you have two
    | indexes that use the "local" driver, both of them can have the
    | same base configuration. You may override for each index.
    |
    */

    'drivers' => [

        'local' => [
            'path' => storage_path('statamic/search'),
        ],

        'algolia' => [
            'credentials' => [
                'id' => env('ALGOLIA_APP_ID', ''),
                'secret' => env('ALGOLIA_SECRET', ''),
            ],
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Search Defaults
    |--------------------------------------------------------------------------
    |
    | Here you can specify default configuration to be applied to all indexes
    | regardless of the driver. You can override these per driver or per index.
    |
    */

    'defaults' => [
        'fields' => ['title'],
    ],

];
