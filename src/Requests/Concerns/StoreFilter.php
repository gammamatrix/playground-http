<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Playground\Http\Requests\Concerns;

use Illuminate\Support\Carbon;
use Ramsey\Uuid\Uuid;

/**
 * \Playground\Http\Requests\Concerns\StoreFilter
 *
 * Playground filter handler
 *
 * It is expected that the data may not have the proper type from forms.
 * These filters correct those values. Parameters must not be cast.
 * Allow the method to decide what to return to prevent model cast errors.
 */
trait StoreFilter
{
    protected string $date_format = 'Y-m-d H:i:s';

    /**
     * Filter an array.
     *
     * @param  mixed  $value  The value to filter.
     * @return array<mixed> Returns an array.
     */
    public function filterArray(mixed $value): array
    {
        if (is_array($value)) {
            return $value;
        } elseif (! empty($value) && is_string($value)) {
            return (array) $value;
        }

        return [];
    }

    /**
     * Filter an array and encode it to json.
     *
     * NOTE: This may not be necessary if the field has been cast in the model.
     *
     * @param  mixed  $value  The value to filter.
     * @return string|false Returns an array converted to JSON.
     */
    public function filterArrayToJson(mixed $value): string|false
    {
        if (is_array($value)) {
            return json_encode($value);
        } elseif (is_string($value)) {
            return $value;
        } else {
            return json_encode([]);
        }
    }

    /**
     * Filter a bit value
     *
     * @param  int  $value  The value to filter.
     * @param  int  $exponent  The maximum power of the exponent to sum.
     */
    public function filterBits($value, $exponent = 0): int
    {
        $exponent = is_scalar($exponent) ? intval(abs($exponent)) : 0;

        /**
         * @var int $pBits The summed bit power values.
         */
        $pBits = 0;
        // $pBits = 4 + 2 + 1;

        for ($i = 0; $i <= $exponent; $i++) {
            $pBits += pow(2, $i);
        }

        return intval(abs($value)) & $pBits;
    }

    /**
     * Filter a boolean value
     *
     * @param  mixed  $value  The value to filter.
     */
    public function filterBoolean(mixed $value): bool
    {
        if (is_string($value) && ! is_numeric($value)) {
            return strtolower($value) === 'true';
        } elseif (is_numeric($value)) {
            return $value > 0;
        } else {
            return (bool) $value;
        }
    }

    /**
     * Filter a date value as an SQL UTC string.
     *
     * @param  string  $value  The date to filter.
     * @param  string  $locale  i18n
     */
    public function filterDate(mixed $value, $locale = 'en-US'): ?string
    {
        if (empty($value) || ! (
            is_string($value)
            || $value instanceof \DateTimeInterface
        )) {
            return null;
        }

        $PLAYGROUND_DATE_SQL = config('playground.date.sql');
        $PLAYGROUND_DATE_SQL = empty($PLAYGROUND_DATE_SQL) || ! is_string($PLAYGROUND_DATE_SQL) ? 'Y-m-d H:i:s' : $PLAYGROUND_DATE_SQL;

        return Carbon::parse($value)->format($PLAYGROUND_DATE_SQL);
        // return Carbon::parse($value)->format(config('playground.date.sql', 'Y-m-d H:i:s'));
    }

    /**
     * Filter a date value as a Carbon date.
     *
     * @param  string  $value  The date to filter.
     * @param  string  $locale  i18n
     */
    public function filterDateAsCarbon($value, $locale = 'en-US'): ?Carbon
    {
        if (empty($value)) {
            return null;
        }

        // return new Carbon($value);
        return Carbon::parse($value);
    }

    /**
     * Filter an email address.
     *
     * @param  mixed  $email  The address to filter.
     */
    public function filterEmail(mixed $email): string
    {
        $email = is_string($email) ? filter_var($email, FILTER_SANITIZE_EMAIL) : '';

        return is_string($email) ? $email : '';
    }

    /**
     * Filter a float value
     *
     * @param  mixed  $value  The value to filter.
     * @param  string  $locale  i18n
     */
    public function filterFloat(mixed $value, $locale = 'en-US'): ?float
    {
        if ($value === '' || $value === null) {
            return null;
        }

        return is_numeric($value) ? floatval($value) : null;
        // return (new \NumberFormatter(
        //     $locale,
        //     \NumberFormatter::DECIMAL
        // ))->parse($value);
    }

    /**
     * Filter HTML from content.
     *
     * FILTER_FLAG_NO_ENCODE_QUOTES - do not encode quotes.
     *
     * @param  mixed  $content  The string to filter.
     */
    public function filterHtml(mixed $content): string
    {
        $content = is_string($content) ? filter_var(
            $content,
            FILTER_SANITIZE_STRING,
            FILTER_FLAG_NO_ENCODE_QUOTES
        ) : '';

        return is_string($content) ? $content : '';
    }

    /**
     * Filter an integer value
     *
     * @param  mixed  $value  The value to filter.
     * @param  string  $locale  i18n
     */
    public function filterInteger(mixed $value, $locale = 'en-US'): int
    {
        if ($value === '' || $value === null) {
            return 0;
        }

        // $value = (new \NumberFormatter(
        //     $locale,
        //     \NumberFormatter::DECIMAL
        // ))->parse($value, \NumberFormatter::TYPE_INT64);

        return is_numeric($value) ? intval($value) : 0;
        // return is_int($value) ? $value : 0;
    }

    /**
     * Filter an integer value ID.
     *
     * @param  mixed  $value  The value to filter.
     */
    public function filterIntegerId(mixed $value): ?int
    {
        return is_numeric($value) && ($value > 0) ? (int) $value : null;
    }

    /**
     * Filter a positive integer value or return zero.
     *
     * @param  mixed  $value  The value to filter.
     * @param  bool  $absolute  Use `abs()` on the value to convert negative to positive.
     */
    public function filterIntegerPositive(mixed $value, $absolute = true): int
    {
        $value = is_scalar($value) ? intval($value) : 0;

        return $absolute && ($value < 0) ? (int) abs($value) : $value;
    }

    /**
     * Filter a percent value
     *
     * NOTE: Only removes the percent sign.
     *
     * @param  mixed  $value  The value to filter.
     * @param  string  $locale  i18n
     */
    public function filterPercent(mixed $value, $locale = 'en-US'): ?float
    {
        if ($value === '' || $value === null) {
            return null;
        }

        if (is_string($value)) {
            $value = str_replace('%', '', $value);
        }

        return $this->filterFloat($value, $locale);
    }

    /**
     * Filter a phone number.
     */
    public function filterPhone(mixed $value, string $locale = 'en-US'): string
    {
        if (empty($value)) {
            return '';
        }

        if (is_numeric($value)) {
            return strval($value);
        }

        if (is_string($value)) {
            // Allow commas, pluses, pound: +,#
            $value = filter_var(str_replace([
                '-',
                '.',
                '',
                '$',
                '_',
                '+',
                '!',
                '*',
                '\'',
                '(',
                ')',
                '{',
                '}',
                '|',
                '\\',
                '^',
                '~',
                '`',
                '[',
                ']',
                '<',
                '>',
                '/',
                '#',
                '%',
                '"',
                ';',
                '/',
                '?',
                ':',
                '@',
                '&',
                '=',
            ], '', $value), FILTER_SANITIZE_URL);
        }

        return is_string($value) ? $value : '';
    }

    /**
     * Filter the status
     *
     * @param  array<string, mixed>  $input  The status input.
     */
    public function filterStatus(array &$input): void
    {
        if (! $this->exists('status')) {
            return;
        }

        $status = $this->input('status');

        if (is_numeric($status)) {
            $input['status'] = (int) abs(intval($status));
        }

        // NOTE: Array status requires model bit status handling.
        if (is_array($status)) {
            $input['status'] = [];
            foreach ($status as $key => $value) {
                if ($key && is_string($key)) {
                    $input['status'][$key] = ! empty($value);
                }
            }
        }
    }

    /**
     * Filter common fields
     *
     * @param  array<string, mixed>  $input  The common fields: avatar, byline, icon, image, locale, url
     */
    public function filterCommonFields(array &$input): void
    {
        if ($this->exists('avatar')) {
            $input['avatar'] = $this->filterHtml($this->input('avatar'));
        }

        if ($this->exists('byline')) {
            $input['byline'] = $this->filterHtml($this->input('byline'));
        }

        if ($this->exists('icon')) {
            $input['icon'] = $this->filterHtml($this->input('icon'));
        }

        if ($this->exists('image')) {
            $input['image'] = $this->filterHtml($this->input('image'));
        }

        if ($this->exists('label')) {
            $input['label'] = $this->filterHtml($this->input('label'));
        }

        if ($this->exists('locale')) {
            $input['locale'] = $this->filterHtml($this->input('locale'));
        }

        if ($this->exists('title')) {
            $input['title'] = $this->filterHtml($this->input('title'));
        }

        if ($this->exists('url')) {
            $input['url'] = $this->filterUri($this->input('url'));
        }
    }

    /**
     * Filter content fields
     *
     * @param  array<string, mixed>  $input  The content fields: content, summary, description, introduction
     */
    public function filterContentFields(array &$input): void
    {
        if ($this->exists('content')) {
            $input['content'] = $this->purify($this->input('content'));
        }

        if ($this->exists('summary')) {
            $input['summary'] = $this->purify($this->input('summary'));
        }

        if ($this->exists('description')) {
            $input['description'] = $this->exorcise($this->input('description'));
        }

        if ($this->exists('introduction')) {
            $input['introduction'] = $this->exorcise($this->input('introduction'));
        }
    }

    /**
     * Filter system fields
     *
     * @param  array<string, mixed>  $input  The system fields input.
     */
    public function filterSystemFields(array &$input): void
    {
        // Filter group fields.
        if ($this->exists('gids')) {
            $gids = $this->input('gids');
            if (isset($gids) && is_numeric($gids)) {
                $input['gids'] = (int) abs($gids);
            }
        }

        /**
         * @var int $pBits The allowed permission bits: rwx
         */
        $pBits = 4 + 2 + 1;

        if ($this->exists('po')) {
            $po = $this->input('po');
            if (isset($po) && is_numeric($po)) {
                $input['po'] = intval(abs($po)) & $pBits;
            }
        }

        if ($this->exists('pg')) {
            $pg = $this->input('pg');
            if (isset($pg) && is_numeric($pg)) {
                $input['pg'] = intval(abs($pg)) & $pBits;
            }
        }
        if ($this->exists('pw')) {
            $pw = $this->input('pw');
            if (isset($pw) && is_numeric($pw)) {
                $input['pw'] = intval(abs($pw)) & $pBits;
            }
        }

        if ($this->exists('rank')) {
            $rank = $this->input('rank');
            if (isset($rank) && is_numeric($rank)) {
                $input['rank'] = (int) $rank;
            }
        }

        if ($this->exists('size')) {
            $size = $this->input('size');
            if (isset($size) && is_numeric($size)) {
                $input['size'] = (int) $size;
            }
        }
    }

    /**
     * Filter a URI.
     */
    public function filterUri(mixed $value): string
    {
        if (empty($value) || ! is_string($value)) {
            return '';
        }

        $value = filter_var($value, FILTER_SANITIZE_URL);

        return is_string($value) ? $value : '';
    }

    /**
     * Filter a UUID
     *
     * @param  mixed  $value  The value to filter.
     */
    public function filterUuid(mixed $value): ?string
    {
        return is_string($value) && Uuid::isValid($value)
            ? $value : null;
    }
}
