<?php

declare(strict_types=1);
/**
 * Playground
 */

namespace Tests\Unit\Playground\Http\Requests\Concerns\StoreFilter;

use Playground\Http\Requests\StoreRequest;
use Tests\Unit\Playground\Http\TestCase;

/**
 * \Tests\Unit\Playground\Http\Requests\Concerns\StoreFilter\ValueTraitTest
 *
 * @see \Playground\Http\Requests\Concerns\StoreFilter::filterBoolean()
 * @see \Playground\Http\Requests\Concerns\StoreFilter::filterFloat()
 * @see \Playground\Http\Requests\Concerns\StoreFilter::filterInteger()
 * @see \Playground\Http\Requests\Concerns\StoreFilter::filterPercent()
 */
class ValueTraitTest extends TestCase
{
    /**
     * filterBoolean
     *
     * @see \Playground\Http\Requests\Concerns\StoreFilter::filterBoolean()
     */
    public function test_filter_boolean(): void
    {
        $instance = new StoreRequest;

        // Always return an array, no matter the input.

        // empty array
        $this->assertFalse($instance->filterBoolean([]));

        // NULL
        $this->assertFalse($instance->filterBoolean(null));

        // false
        $this->assertFalse($instance->filterBoolean([]));

        // true
        $this->assertTrue($instance->filterBoolean(true));

        // Positive numbers are true
        $this->assertTrue($instance->filterBoolean(10));
        $this->assertTrue($instance->filterBoolean(1));
        $this->assertFalse($instance->filterBoolean(0));
        $this->assertFalse($instance->filterBoolean(-10));

        // Empty string
        $this->assertFalse($instance->filterBoolean(''));

        $this->assertTrue($instance->filterBoolean('true'));

        $this->assertFalse($instance->filterBoolean('not-true'));

        $value = [
            'i' => 'am-a-test-array',
            'someNullValue' => null,
            'aString' => 'thanks!',
            'object' => (object) ['ok' => true],
        ];

        $this->assertTrue($instance->filterBoolean($value));
    }

    /**
     * filterEmail
     *
     * @see \Playground\Http\Requests\Concerns\StoreFilter::filterEmail()
     */
    public function test_filter_email(): void
    {
        $instance = new StoreRequest;

        $value = false;
        $this->assertSame('', $instance->filterEmail($value));

        $value = 'not valid email with spaces @ example.com';
        $this->assertSame('notvalidemailwithspaces@example.com', $instance->filterEmail($value));

        $value = 'test@';
        $this->assertSame($value, $instance->filterEmail($value));

        $value = 'test@example.com';
        $this->assertSame($value, $instance->filterEmail($value));
        $value = '<test@example.com>';
        $this->assertSame('test@example.com', $instance->filterEmail($value));

        $value = 'test+with.plus-addressing@example.com';
        $this->assertSame($value, $instance->filterEmail($value));
    }

    /**
     * filterHtml
     *
     * @see \Playground\Filters\ContentTrait::purify() HTMLPurifier
     * @see \Playground\Http\Requests\Concerns\StoreFilter::filterHtml()
     */
    public function test_filter_html(): void
    {
        $instance = new StoreRequest;

        $value = '<b>Tags should be removed.</b>';
        $this->assertSame('Tags should be removed.', $instance->filterHtml($value));

        $value = '<a href="https://google.com">No links allowed either.</a>';
        $this->assertSame('No links allowed either.', $instance->filterHtml($value));
    }
}
