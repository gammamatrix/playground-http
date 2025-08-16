<?php

declare(strict_types=1);
/**
 * Playground
 */

namespace Playground\Http;

use Illuminate\Foundation\Console\AboutCommand;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider;

/**
 * \Playground\Http\ServiceProvider
 */
class ServiceProvider extends AuthServiceProvider
{
    public const string VERSION = '74.0.0';

    protected string $package = 'playground-http';

    /**
     * Bootstrap any package services.
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * @var array<string, mixed> $config
         */
        $config = config($this->package);

        if (! empty($config['load']) && is_array($config['load'])) {

            if (! empty($config['load']['translations'])) {
                $this->loadTranslationsFrom(
                    dirname(__DIR__).'/lang',
                    'playground-http'
                );
            }

            if ($this->app->runningInConsole()) {
                // Publish configuration
                $this->publishes([
                    sprintf('%1$s/config/%2$s.php', dirname(__DIR__), $this->package) => config_path(sprintf('%1$s.php', $this->package)),
                ], 'playground-config');
            }
        }

        $this->about();
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            sprintf('%1$s/config/%2$s.php', dirname(__DIR__), $this->package),
            $this->package
        );
    }

    public function about(): void
    {
        $config = config($this->package);
        $config = is_array($config) ? $config : [];

        $load = ! empty($config['load']) && is_array($config['load']) ? $config['load'] : [];
        $purifier = ! empty($config['purifier']) && is_array($config['purifier']) ? $config['purifier'] : [];

        AboutCommand::add('Playground: Http', fn () => [
            '<fg=yellow;options=bold>Load</> Translations' => ! empty($load['translations']) ? '<fg=green;options=bold>ENABLED</>' : '<fg=yellow;options=bold>DISABLED</>',

            'Package' => $this->package,
            'Version' => ServiceProvider::VERSION,
        ]);
    }
}
