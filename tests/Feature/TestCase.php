<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Tests\Feature\Playground\Http;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\Unit\Playground\Http\TestCase as BaseTestCase;

/**
 * \Tests\Feature\Playground\Http\TestCase
 */
class TestCase extends BaseTestCase
{
    use DatabaseTransactions;

    protected bool $load_migrations_laravel = false;

    protected bool $load_migrations_playground = false;
}
