<?php

return [
    'host' => env('ELASTIC_HOST', 'http://elasticsearch:9200'),
    'api_key' => env('ELASTIC_API_KEY', ''),

    'properties' => [
        'item' => [
            'app_slug' => [
                'type' => 'keyword',
            ],
            'name' => [
                'type' => 'keyword',
                'fields' => [
                    'text' => ['type' => 'text'],  // For full-text search
                ],
            ],
            'last_updated_price' => [
                'type' => 'float',
            ],
            'last_updated_amount' => [
                'type' => 'integer',
            ],
            'icon_url' => [
                'type' => 'text',
            ],
            'page_url' => [
                'type' => 'text',
            ],
            'last_update' => [
                'type' => 'date',
            ],
        ],
    ],
];
