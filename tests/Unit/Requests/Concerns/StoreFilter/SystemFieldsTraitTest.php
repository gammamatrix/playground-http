<?php

declare(strict_types=1);
/**
 * Playground
 */

namespace Tests\Unit\Playground\Http\Requests\Concerns\StoreFilter;

use Playground\Http\Requests\StoreRequest;
use Playground\Test\MockingTrait;
use Tests\Unit\Playground\Http\TestCase;

/**
 * \Tests\Unit\Playground\Http\Requests\Concerns\StoreFilter\SystemFieldsTraitTest
 *
 * @see \Playground\Http\Requests\Concerns\StoreFilter::filterSystemFields()
 * @see \Playground\Http\Requests\Concerns\StoreFilter::filterSystemFields()
 */
class SystemFieldsTraitTest extends TestCase
{
    use MockingTrait;

    /**
     * @param  array<string, mixed>  $input
     */
    public function getStoreRequest(
        array $input = [],
        string $uri = '/testing',
        string $method = 'POST',
    ): StoreRequest {
        /**
         * @var StoreRequest
         */
        $instance = $this->mockRequest(
            StoreRequest::class,
            $uri,
            $method,
            $input
        );

        return $instance;
    }

    /**
     * filterSystemFields: empty
     *
     * @see \Playground\Http\Requests\Concerns\StoreFilter::filterSystemFields()
     */
    public function test_filter_system_fields_with_empty_input(): void
    {
        $input = [];
        $instance = $this->getStoreRequest($input);
        $instance->filterSystemFields($input);
        $this->assertSame([], $input);
    }

    /**
     * filterSystemFields: gids
     *
     * @see \Playground\Http\Requests\Concerns\StoreFilter::filterSystemFields()
     */
    public function test_filter_system_fields_for_groups(): void
    {
        $input = ['gids' => 1];
        $instance = $this->getStoreRequest($input);

        $instance->filterSystemFields($input);
        $this->assertSame(['gids' => 1], $input);
    }

    /**
     * filterSystemFields: po, pg, pw
     *
     * @see \Playground\Http\Requests\Concerns\StoreFilter::filterSystemFields()
     */
    public function test_filter_system_fields_for_valid_permissions(): void
    {
        $input = [
            'po' => 7,
            'pg' => 4,
            'pw' => 4,
        ];

        $instance = $this->getStoreRequest($input);

        $instance->filterSystemFields($input);

        $this->assertSame([
            'po' => 7,
            'pg' => 4,
            'pw' => 4,
        ], $input);
    }

    /**
     * filterSystemFields: po, pg, pw
     *
     * @see \Playground\Http\Requests\Concerns\StoreFilter::filterSystemFields()
     */
    public function test_filter_system_fields_for_invalid_permissions(): void
    {
        $input = [
            'po' => 100,
            'pg' => 4,
            'pw' => 4,
        ];
        $instance = $this->getStoreRequest($input);

        $instance->filterSystemFields($input);

        $this->assertSame([
            'po' => 4,
            'pg' => 4,
            'pw' => 4,
        ], $input);
    }

    /**
     * filterSystemFields: rank
     *
     * @see \Playground\Http\Requests\Concerns\StoreFilter::filterSystemFields()
     */
    public function test_filter_system_fields_for_rank(): void
    {
        $input = ['rank' => 0];
        $instance = $this->getStoreRequest($input);
        $instance->filterSystemFields($input);
        $this->assertSame(['rank' => 0], $input);

        $input = ['rank' => 1];
        $instance = $this->getStoreRequest($input);
        $instance->filterSystemFields($input);
        $this->assertSame(['rank' => 1], $input);

        $input = ['rank' => -1];
        $instance = $this->getStoreRequest($input);
        $instance->filterSystemFields($input);
        $this->assertSame(['rank' => -1], $input);
    }

    /**
     * filterSystemFields: size
     *
     * @see \Playground\Http\Requests\Concerns\StoreFilter::filterSystemFields()
     */
    public function test_filter_system_fields_for_size(): void
    {
        $input = ['size' => 0];
        $instance = $this->getStoreRequest($input);
        $instance->filterSystemFields($input);
        $this->assertSame(['size' => 0], $input);

        $input = ['size' => 1];
        $instance = $this->getStoreRequest($input);
        $instance->filterSystemFields($input);
        $this->assertSame(['size' => 1], $input);

        $input = ['size' => -1];
        $instance = $this->getStoreRequest($input);
        $instance->filterSystemFields($input);
        $this->assertSame(['size' => -1], $input);
    }
}
