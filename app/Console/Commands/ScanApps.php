<?php

namespace App\Console\Commands;

use App\Enums\AppSlug;
use App\Enums\Provider;
use App\Exceptions\App\AppScanException;
use App\Services\AppService;
use App\Services\Scanner\AppScannerBuilder;
use Illuminate\Console\Command;

class ScanApps extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:scan-apps {provider}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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

        $appService = null;
        try {
            /** @var AppService $appService */
            $appService = app(AppService::class, [
                'appScanner' => app()->make(AppScannerBuilder::class, compact('provider'))->build(),
            ]);
        } catch (\Throwable $exception) {
            $this->error('Error building app scanner for provider');
            $this->error($exception->getMessage());
        }

        foreach (AppSlug::cases() as $appSlug) {
            try {
                $appService->scan($appSlug);
            } catch (AppScanException $exception) {
                $this->error($exception->getMessage());
                $this->error($exception->getReason());

                return 1;
            }
        }

        return 0;
    }
}
