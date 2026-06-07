<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Tests\Unit\Playground\Http;

use Playground\ServiceProvider;

/**
 * \Tests\Unit\Playground\Http\PackageProviders
 */
trait PackageProviders
{
    protected function getPackageProviders($app)
    {
        return [
            ServiceProvider::class,
            \Playground\Http\ServiceProvider::class,
        ];
    }
}
