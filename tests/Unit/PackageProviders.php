<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Tests\Unit\Playground\Http;

/**
 * \Tests\Unit\Playground\Http\PackageProviders
 */
trait PackageProviders
{
    protected function getPackageProviders($app)
    {
        return [
            \Playground\ServiceProvider::class,
            \Playground\Http\ServiceProvider::class,
        ];
    }
}
