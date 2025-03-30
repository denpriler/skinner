<?php

namespace App\Exceptions\Item;

use App\Enums\AppSlug;
use App\Enums\Provider;
use Exception;

class ItemScanException extends Exception
{
    public function __construct(protected readonly Provider $provider, protected readonly AppSlug $slug, protected readonly string $name, protected readonly string $reason)
    {
        parent::__construct(
            sprintf(
                'Error while searching %s for %s via %s',
                $this->name,
                $this->slug->value,
                $this->provider->value
            )
        );
    }

    public function getReason(): string
    {
        return $this->reason;
    }
}
