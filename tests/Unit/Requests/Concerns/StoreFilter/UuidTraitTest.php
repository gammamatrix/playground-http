<?php

declare(strict_types=1);
/**
 * Playground
 */

namespace Tests\Unit\Playground\Http\Requests\Concerns\StoreFilter;

use Faker\Factory;
use Playground\Http\Requests\Concerns\StoreFilter;
use Playground\Http\Requests\StoreRequest;
use Tests\Unit\Playground\Http\TestCase;

/**
 * \Tests\Unit\Playground\Http\Requests\Concerns\StoreFilter\UuidTraitTest
 *
 * @see StoreFilter::filterUuid()
 */
class UuidTraitTest extends TestCase
{
    /**
     * filterUuid
     *
     * @see StoreFilter::filterUuid()
     */
    public function test_filter_uuid(): void
    {
        $instance = new StoreRequest;

        $faker = Factory::create();
        $uuid = $faker->uuid;
        $this->assertNotEmpty($uuid);
        $this->assertSame($uuid, $instance->filterUuid($uuid));
    }
}
