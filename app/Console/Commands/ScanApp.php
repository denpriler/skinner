<?php

namespace App\Console\Commands;

use App\Enums\AppSlug;
use App\Enums\Provider;
use App\Exceptions\App\AppScanException;
use App\Services\AppService;
use App\Services\Scanner\AppScannerBuilder;
use Illuminate\Console\Command;
use Throwable;

class ScanApp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:scan {provider} {app}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scan app to database';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $provider = Provider::tryFrom($this->argument('provider'));
        if (! $provider) {
            $this->error('Provider not found');
            $this->info(
                sprintf(
                    'Use one of available providers: %s',
                    collect(Provider::toStringArray())->join(',')
                )
            );

            return 1;
        }

        $appSlug = AppSlug::tryFrom($this->argument('app'));
        if (! $appSlug) {
            $this->error('App not found');
            $this->info(
                sprintf(
                    'Use one of available apps: %s',
                    collect(AppSlug::toStringArray())->join(',')
                )
            );

            return 1;
        }

        try {
            app(AppService::class, [
                'appScanner' => app()->make(AppScannerBuilder::class, compact('provider'))->build(),
            ])->scan($appSlug);
        } catch (AppScanException|Throwable $exception) {
            $this->error($exception->getMessage());
            if ($exception instanceof AppScanException) {
                $this->error($exception->getReason());
            }

            return 1;
        }

        return 0;
    }
}
