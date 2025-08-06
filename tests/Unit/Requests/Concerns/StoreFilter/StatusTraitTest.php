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
 * \Tests\Unit\Playground\Http\Requests\Concerns\StoreFilter\DateTraitTest
 *
 * @see \Playground\Http\Requests\Concerns\StoreFilter::filterStatus()
 */
class StatusTraitTest extends TestCase
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
     * filterStatus
     *
     * @see \Playground\Http\Requests\Concerns\StoreFilter::filterStatus()
     */
    public function test_filter_status_with_empty_input(): void
    {
        $input = [];
        $instance = $this->getStoreRequest($input);
        $instance->filterStatus($input);
        $this->assertSame([], $input);
    }

    /**
     * filterStatus
     *
     * @see \Playground\Http\Requests\Concerns\StoreFilter::filterStatus()
     */
    public function test_filter_status_with_integer(): void
    {
        $input = ['status' => 1];
        $instance = $this->getStoreRequest($input);
        $instance->filterStatus($input);
        $this->assertSame(['status' => 1], $input);
    }

    /**
     * filterStatus
     *
     * @see \Playground\Http\Requests\Concerns\StoreFilter::filterStatus()
     */
    public function test_filter_status_with_integer_as_string(): void
    {
        $input = ['status' => '1'];
        $instance = $this->getStoreRequest($input);
        $instance->filterStatus($input);
        $this->assertSame(['status' => 1], $input);
    }

    /**
     * filterStatus
     *
     * @see \Playground\Http\Requests\Concerns\StoreFilter::filterStatus()
     */
    public function test_filter_status_with_integer_as_negative_float(): void
    {
        $input = ['status' => '-1.0'];
        $instance = $this->getStoreRequest($input);
        $instance->filterStatus($input);
        $this->assertSame(['status' => 1], $input);
    }

    /**
     * filterStatus
     *
     * @see \Playground\Http\Requests\Concerns\StoreFilter::filterStatus()
     */
    public function test_filter_status_with_map(): void
    {
        $input = [
            'status' => [
                'active' => 1,
                'lock' => true,
                'public' => 0,
            ],
        ];

        $instance = $this->getStoreRequest($input);
        $instance->filterStatus($input);

        $this->assertSame([
            'status' => [
                'active' => true,
                'lock' => true,
                'public' => false,
            ],
        ], $input);
    }
}
