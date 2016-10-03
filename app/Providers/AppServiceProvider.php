<?php

namespace App\Providers;

use App\Importers\CsvImporter;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\ServiceProvider;
use App\Contracts\Importer\ImporterInterface;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\ConsoleOutputInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @param  \Illuminate\Routing\UrlGenerator
     * @return void
     */
    public function boot(UrlGenerator $url)
    {
        if ($this->app->environment('production')) {
            $url->forceSchema('https');
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            ImporterInterface::class,
            CsvImporter::class
        );

        $this->app->bind(
            OutputInterface::class,
            ConsoleOutput::class
        );
    }

    /**
     * @return array
     */
    public function provides()
    {
        return [
            ImporterInterface::class,
            ConsoleOutputInterface::class,
        ];
    }
}
