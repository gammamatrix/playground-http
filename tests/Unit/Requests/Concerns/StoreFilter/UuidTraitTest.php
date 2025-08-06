<?php

declare(strict_types=1);
/**
 * Playground
 */

namespace Tests\Unit\Playground\Http\Requests\Concerns\StoreFilter;

use Playground\Http\Requests\StoreRequest;
use Tests\Unit\Playground\Http\TestCase;

/**
 * \Tests\Unit\Playground\Http\Requests\Concerns\StoreFilter\UuidTraitTest
 *
 * @see \Playground\Http\Requests\Concerns\StoreFilter::filterUuid()
 */
class UuidTraitTest extends TestCase
{
    /**
     * filterUuid
     *
     * @see \Playground\Http\Requests\Concerns\StoreFilter::filterUuid()
     */
    public function test_filter_uuid(): void
    {
        $instance = new StoreRequest;

        $faker = \Faker\Factory::create();
        $uuid = $faker->uuid;
        $this->assertNotEmpty($uuid);
        $this->assertSame($uuid, $instance->filterUuid($uuid));
    }
}
