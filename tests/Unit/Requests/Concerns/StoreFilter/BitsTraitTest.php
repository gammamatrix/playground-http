<?php

declare(strict_types=1);
/**
 * Playground
 */

namespace Tests\Unit\Playground\Http\Requests\Concerns\StoreFilter;

use Playground\Http\Requests\StoreRequest;
use Tests\Unit\Playground\Http\TestCase;

/**
 * \Tests\Unit\Playground\Http\Requests\Concerns\StoreFilter\BitsTraitTest
 *
 * @see \Playground\Http\Requests\Concerns\StoreFilter::filterBits()
 * @see \Playground\Http\Requests\Concerns\StoreFilter::filterBits()
 */
class BitsTraitTest extends TestCase
{
    /**
     * filterBits: $exponent = 0
     *
     * @see \Playground\Http\Requests\Concerns\StoreFilter::filterBits()
     */
    public function test_filter_bits_for_exponent_zero(): void
    {
        $instance = new StoreRequest;

        $this->assertSame(0, $instance->filterBits(0));

        $value = 1 + 2 + 4 + 8 + 16 + 32;
        $expected = 1;
        $this->assertSame($expected, $instance->filterBits($value));
    }

    /**
     * filterBits: $exponent > 0
     *
     * @see \Playground\Http\Requests\Concerns\StoreFilter::filterBits()
     */
    public function test_filter_bits_for_exponent_greater_than_zero(): void
    {
        $instance = new StoreRequest;

        $value = 1 + 2 + 4 + 8 + 16 + 32;

        $exponent = 1;
        $expected = 1 + 2;
        $this->assertSame($expected, $instance->filterBits($value, $exponent));

        $exponent = 2;
        $expected = 1 + 2 + 4;
        $this->assertSame($expected, $instance->filterBits($value, $exponent));

        $exponent = 3;
        $expected = 1 + 2 + 4 + 8;
        $this->assertSame($expected, $instance->filterBits($value, $exponent));

        $exponent = 4;
        $expected = 1 + 2 + 4 + 8 + 16;
        $this->assertSame($expected, $instance->filterBits($value, $exponent));

        $exponent = 5;
        $expected = 1 + 2 + 4 + 8 + 16 + 32;
        $this->assertSame($expected, $instance->filterBits($value, $exponent));
    }
}
