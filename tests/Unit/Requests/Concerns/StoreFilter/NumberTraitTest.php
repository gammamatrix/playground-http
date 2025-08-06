<?php

declare(strict_types=1);
/**
 * Playground
 */

namespace Tests\Unit\Playground\Http\Requests\Concerns\StoreFilter;

use Playground\Http\Requests\StoreRequest;
use Tests\Unit\Playground\Http\TestCase;

/**
 * \Tests\Unit\Playground\Http\Requests\Concerns\StoreFilter\NumberTraitTest
 *
 * @see \Playground\Http\Requests\Concerns\StoreFilter::filterBits()
 * @see \Playground\Http\Requests\Concerns\StoreFilter::filterBits()
 */
class NumberTraitTest extends TestCase
{
    /**
     * filterFloat
     *
     * @see \Playground\Http\Requests\Concerns\StoreFilter::filterFloat()
     */
    public function test_filter_float(): void
    {
        $instance = new StoreRequest;

        $this->assertNull($instance->filterFloat(''));
        $this->assertNull($instance->filterFloat(null));

        $this->assertSame(0.0, $instance->filterFloat(0));
        $this->assertSame(1.0, $instance->filterFloat(1));
    }

    /**
     * filterInteger
     *
     * @see \Playground\Http\Requests\Concerns\StoreFilter::filterInteger()
     */
    public function test_filter_integer(): void
    {
        $instance = new StoreRequest;

        $this->assertSame(0, $instance->filterInteger(''));
        $this->assertSame(0, $instance->filterInteger(null));
        $this->assertSame(0, $instance->filterInteger(false));

        // Needs i18n for numberformatter
        // $this->assertSame(1000, $instance->filterInteger('1,000'));
        // $this->assertSame(2000, $instance->filterInteger('2,000.01'));
        $this->assertSame(0, $instance->filterInteger(0));
        $this->assertSame(1, $instance->filterInteger(1));
        $this->assertSame(-1001, $instance->filterInteger(-1001));
    }

    /**
     * filterIntegerId
     *
     * @see \Playground\Http\Requests\Concerns\StoreFilter::filterIntegerId()
     */
    public function test_filter_integer_id(): void
    {
        $instance = new StoreRequest;

        $this->assertNull($instance->filterIntegerId(''));
        $this->assertNull($instance->filterIntegerId(null));
        $this->assertNull($instance->filterIntegerId(false));

        $this->assertNull($instance->filterIntegerId('1,000'));
        $this->assertNull($instance->filterIntegerId('2,000.01'));
        $this->assertNull($instance->filterIntegerId(0));
        $this->assertSame(1, $instance->filterIntegerId(1));
        $this->assertNull($instance->filterIntegerId(-1001));
        $this->assertNull($instance->filterIntegerId('-1001'));
        $this->assertSame(1, $instance->filterIntegerId('1'));
        $this->assertSame(100, $instance->filterIntegerId('100'));
        $this->assertSame(2000000, $instance->filterIntegerId('2000000.0'));
    }

    /**
     * filterIntegerPositive
     *
     * @see \Playground\Http\Requests\Concerns\StoreFilter::filterIntegerPositive()
     */
    public function test_filter_integer_positive(): void
    {
        $instance = new StoreRequest;

        $this->assertSame(0, $instance->filterIntegerPositive(''));
        $this->assertSame(0, $instance->filterIntegerPositive(null));
        $this->assertSame(0, $instance->filterIntegerPositive(false));

        $this->assertSame(1, $instance->filterIntegerPositive('1,000'));
        $this->assertSame(2, $instance->filterIntegerPositive('2,000.01'));
        $this->assertSame(0, $instance->filterIntegerPositive(0));
        $this->assertSame(1, $instance->filterIntegerPositive(1));
        $this->assertSame(1001, $instance->filterIntegerPositive(-1001));
        $this->assertSame(1001, $instance->filterIntegerPositive(-1001));

        $absolute = true;
        $this->assertSame(0, $instance->filterIntegerPositive('', $absolute));
        $this->assertSame(0, $instance->filterIntegerPositive(null, $absolute));
        $this->assertSame(0, $instance->filterIntegerPositive(false, $absolute));

        $this->assertSame(1, $instance->filterIntegerPositive('1,000', $absolute));
        $this->assertSame(2, $instance->filterIntegerPositive('2,000.01', $absolute));
        $this->assertSame(0, $instance->filterIntegerPositive(0, $absolute));
        $this->assertSame(1, $instance->filterIntegerPositive(1, $absolute));
        $this->assertSame(1001, $instance->filterIntegerPositive(-1001, $absolute));
        $this->assertSame(1001, $instance->filterIntegerPositive(-1001, $absolute));

        $absolute = false;
        $this->assertSame(0, $instance->filterIntegerPositive('', $absolute));
        $this->assertSame(0, $instance->filterIntegerPositive(null, $absolute));
        $this->assertSame(0, $instance->filterIntegerPositive(false, $absolute));

        $this->assertSame(1, $instance->filterIntegerPositive('1,000', $absolute));
        $this->assertSame(2, $instance->filterIntegerPositive('2,000.01', $absolute));
        $this->assertSame(0, $instance->filterIntegerPositive(0, $absolute));
        $this->assertSame(1, $instance->filterIntegerPositive(1, $absolute));
        $this->assertSame(-1001, $instance->filterIntegerPositive(-1001, $absolute));
        $this->assertSame(-1001, $instance->filterIntegerPositive(-1001, $absolute));
    }

    /**
     * filterPercent
     *
     * @see \Playground\Http\Requests\Concerns\StoreFilter::filterPercent()
     */
    public function test_filter_percent(): void
    {
        $instance = new StoreRequest;

        $this->assertNull($instance->filterPercent(''));
        $this->assertNull($instance->filterPercent(null));
        $this->assertNull($instance->filterPercent(false));

        // $this->assertSame(1000.0, $instance->filterPercent('1,000%'));

        // $this->assertSame(1000.0, $instance->filterPercent('1,000'));
        // $this->assertSame(2000.01, $instance->filterPercent('2,000.01'));
        $this->assertSame(0.0, $instance->filterPercent(0));
        $this->assertSame(1.0, $instance->filterPercent(1));
        $this->assertSame(-1001.0, $instance->filterPercent('-1001 %'));
    }
}
