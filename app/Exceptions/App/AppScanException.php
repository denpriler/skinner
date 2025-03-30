<?php

namespace App\Exceptions\App;

use App\Enums\AppSlug;
use App\Enums\Provider;
use Exception;

class AppScanException extends Exception
{
    public function __construct(protected readonly Provider $provider, protected readonly AppSlug $slug, protected readonly string $reason = '')
    {
        parent::__construct(
            sprintf(
                'Error while parsing %s via %s',
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
