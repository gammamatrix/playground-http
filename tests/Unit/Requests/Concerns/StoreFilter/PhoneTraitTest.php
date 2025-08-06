<?php

declare(strict_types=1);
/**
 * Playground
 */

namespace Tests\Unit\Playground\Http\Requests\Concerns\StoreFilter;

use Playground\Http\Requests\StoreRequest;
use Tests\Unit\Playground\Http\TestCase;

/**
 * \Tests\Unit\Playground\Http\Requests\Concerns\StoreFilter\PhoneTraitTest
 *
 * @see \Playground\Http\Requests\Concerns\StoreFilter::filterBits()
 * @see \Playground\Http\Requests\Concerns\StoreFilter::filterBits()
 */
class PhoneTraitTest extends TestCase
{
    /**
     * filterPhone
     *
     * @see \Playground\Http\Requests\Concerns\StoreFilter::filterPhone()
     */
    public function test_filter_phone(): void
    {
        $instance = new StoreRequest;

        $empty = '';

        $this->assertSame($empty, $instance->filterPhone(''));
        $this->assertSame($empty, $instance->filterPhone(null));

        $this->assertSame('1234567890', $instance->filterPhone('123-456-7890'));
        $this->assertSame('9,,,1234567890,,1234', $instance->filterPhone('9,,,123-456-7890,,1234'));
    }
}
