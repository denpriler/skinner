<?php

namespace App\Providers;

use Elastic\Elasticsearch\Client as ElasticsearchClient;
use Elastic\Elasticsearch\ClientBuilder;
use Illuminate\Support\ServiceProvider;

class ElasticsearchServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(ElasticsearchClient::class, function () {
            return ClientBuilder::create()
                ->setHosts([config('elasticsearch.host')])
                ->setApiKey(config('elasticsearch.api_key'))
                ->build();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
