<?php

namespace App\Console\Commands;

use Elastic\Elasticsearch\Client as ElasticsearchClient;
use Illuminate\Console\Command;

class CreateElasticsearchIndexes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'elastic:create-indexes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create required Elasticsearch indexes';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        /** @var ElasticsearchClient $client */
        $client = app(ElasticsearchClient::class);

        $properties = config('elasticsearch.properties.item');
        $exists = $client->indices()->exists(['index' => 'items'])->asBool();
        $client->indices()->{$exists ? 'putMapping' : 'create'}([
            'index' => 'items',
            'body' => $exists ? [
                'properties' => $properties,
            ] : [
                'mappings' => [
                    '_source' => [
                        'enabled' => true,
                    ],
                    'properties' => $properties,
                ],
            ],
        ]);

        return 0;
    }
}
