<?php

declare(strict_types=1);
/**
 * Playground
 */

namespace Tests\Unit\Playground\Http\Requests\Concerns\StoreFilter;

use Playground\Http\Requests\StoreRequest;
use Tests\Unit\Playground\Http\TestCase;

/**
 * \Tests\Unit\Playground\Http\Requests\Concerns\StoreFilter\ArrayTraitTest
 *
 * @see \Playground\Http\Requests\Concerns\StoreFilter::filterArray()
 * @see \Playground\Http\Requests\Concerns\StoreFilter::filterArrayToJson()
 */
class ArrayTraitTest extends TestCase
{
    /**
     * filterArray
     *
     * @see \Playground\Http\Requests\Concerns\StoreFilter::filterArray()
     */
    public function test_filter_array(): void
    {
        $instance = new StoreRequest;

        // Always return an array, no matter the input.

        // empty array
        $this->assertSame([], $instance->filterArray([]));

        // NULL
        $this->assertSame([], $instance->filterArray(null));

        // false
        $this->assertSame([], $instance->filterArray(false));

        // true
        $this->assertSame([], $instance->filterArray(true));

        $value = 'just-a-string-value';

        // A string is converted to any array.
        $this->assertSame([$value], $instance->filterArray($value));

        // A test array should not be altered.
        $value = [
            'i' => 'am-a-test-array',
            'someNullValue' => null,
            'aString' => 'thanks!',
            'object' => (object) ['ok' => true],
        ];

        // Returns the same array.
        $this->assertSame($value, $instance->filterArray($value));
    }

    /**
     * filterArrayToJson
     *
     * @see \Playground\Http\Requests\Concerns\StoreFilter::filterArrayToJson()
     */
    public function test_filter_array_to_json(): void
    {
        $instance = new StoreRequest;

        // Unexpected values return a json encoded empty array..

        // empty array
        $this->assertSame(json_encode([]), $instance->filterArrayToJson([]));

        // NULL
        $this->assertSame(json_encode([]), $instance->filterArrayToJson(null));

        // false
        $this->assertSame(json_encode([]), $instance->filterArrayToJson(false));

        // true
        $this->assertSame(json_encode([]), $instance->filterArrayToJson(true));

        $value = 'just-a-string-value';

        // A string will remain a string, unchanged.
        $this->assertSame($value, $instance->filterArrayToJson($value));

        // A test array should not be altered.
        $value = [
            'i' => 'am-a-test-array',
            'someNullValue' => null,
            'aString' => 'thanks!',
            'object' => (object) ['ok' => true],
        ];

        // Returns the same array.
        $this->assertSame(json_encode($value), $instance->filterArrayToJson($value));
    }
}
