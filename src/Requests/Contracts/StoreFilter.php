<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Playground\Http\Requests\Contracts;

use Illuminate\Support\Carbon;
use Ramsey\Uuid\Uuid;

/**
 * \Playground\Http\Requests\Contracts\StoreFilter
 *
 * Playground filter handler
 *
 * It is expected that the data may not have the proper type from forms.
 * These filters correct those values. Parameters must not be cast.
 * Allow the method to decide what to return to prevent model cast errors.
 */
interface StoreFilter
{
    /**
     * Filter an array.
     *
     * @param  mixed  $value  The value to filter.
     * @return array<mixed> Returns an array.
     */
    public function filterArray(mixed $value): array;

    /**
     * Filter an array and encode it to json.
     *
     * NOTE: This may not be necessary if the field has been cast in the model.
     *
     * @param  mixed  $value  The value to filter.
     * @return string|false Returns an array converted to JSON.
     */
    public function filterArrayToJson(mixed $value): string|false;

    /**
     * Filter a bit value
     *
     * @param  int  $value  The value to filter.
     * @param  int  $exponent  The maximum power of the exponent to sum.
     */
    public function filterBits($value, $exponent = 0): int;

    /**
     * Filter a boolean value
     *
     * @param  mixed  $value  The value to filter.
     */
    public function filterBoolean(mixed $value): bool;

    /**
     * Filter a date value as an SQL UTC string.
     *
     * @param  string  $value  The date to filter.
     * @param  string  $locale  i18n
     */
    public function filterDate(mixed $value, $locale = 'en-US'): ?string;

    /**
     * Filter a date value as a Carbon date.
     *
     * @param  string  $value  The date to filter.
     * @param  string  $locale  i18n
     */
    public function filterDateAsCarbon($value, $locale = 'en-US'): ?Carbon;

    /**
     * Filter an email address.
     *
     * @param  mixed  $email  The address to filter.
     */
    public function filterEmail(mixed $email): string;

    /**
     * Filter a float value
     *
     * @param  mixed  $value  The value to filter.
     * @param  string  $locale  i18n
     */
    public function filterFloat(mixed $value, $locale = 'en-US'): ?float;

    /**
     * Filter HTML from content.
     *
     * FILTER_FLAG_NO_ENCODE_QUOTES - do not encode quotes.
     *
     * @param  string  $content  The string to filter.
     */
    public function filterHtml(string $content): string;

    /**
     * Filter an integer value
     *
     * @param  mixed  $value  The value to filter.
     * @param  string  $locale  i18n
     */
    public function filterInteger(mixed $value, $locale = 'en-US'): int;

    /**
     * Filter an integer value ID.
     *
     * @param  mixed  $value  The value to filter.
     */
    public function filterIntegerId(mixed $value): ?int;

    /**
     * Filter a positive integer value or return zero.
     *
     * @param  mixed  $value  The value to filter.
     * @param  bool  $absolute  Use `abs()` on the value to convert negative to positive.
     */
    public function filterIntegerPositive(mixed $value, $absolute = true): int;

    /**
     * Filter a percent value
     *
     * NOTE: Only removes the percent sign.
     *
     * @param  mixed  $value  The value to filter.
     * @param  string  $locale  i18n
     */
    public function filterPercent(mixed $value, $locale = 'en-US'): ?float;

    /**
     * Filter a phone number.
     */
    public function filterPhone(mixed $value, string $locale = 'en-US'): string;

    /**
     * Filter the status
     *
     * @param  array<string, mixed>  $input  The status input.
     */
    public function filterStatus(array &$input): void;

    /**
     * Filter common fields
     *
     * @param  array<string, mixed>  $input  The common fields: avatar, byline, icon, image, locale, url
     */
    public function filterCommonFields(array &$input): void;

    /**
     * Filter system fields
     *
     * @param  array<string, mixed>  $input  The system fields input.
     */
    public function filterSystemFields(array &$input): void;

    /**
     * Filter a URI.
     */
    public function filterUri(mixed $value): string;

    /**
     * Filter a UUID
     *
     * @param  mixed  $value  The value to filter.
     */
    public function filterUuid(mixed $value): ?string;
}
