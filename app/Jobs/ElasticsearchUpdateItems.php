<?php

namespace App\Jobs;

use App\Data\Elasticsearch\ElasticItemData;
use Carbon\FactoryImmutable;
use Elastic\Elasticsearch\Client as ElasticsearchClient;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use JetBrains\PhpStorm\NoReturn;

class ElasticsearchUpdateItems implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(private readonly array $items)
    {
        $this->onQueue('elasticsearch-items');
    }

    /**
     * Execute the job.
     */
    #[NoReturn]
    public function handle(ElasticsearchClient $elasticsearch, FactoryImmutable $factoryImmutable): void
    {
        if (! count($this->items)) {
            return;
        }

        $params = ['body' => []];

        /** @var array $item */
        foreach ($this->items as $item) {
            $data = ElasticItemData::from($item);

            $params['body'][] = [
                'update' => [
                    '_index' => 'items',
                    '_id' => $data->getId(),
                ],
            ];

            $params['body'][] = [
                'doc' => [
                    ...$data->toArray(),
                    'last_update' => $factoryImmutable->now()->timestamp,
                ],
                'doc_as_upsert' => true,
            ];
        }

        $elasticsearch->bulk($params);
    }
}
