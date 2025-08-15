<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Playground\Http\Requests\Contracts;

/**
 * \Playground\Http\Requests\Contracts\PaginationDates
 */
interface PaginationDates
{
    /**
     * @return array<string, mixed>
     */
    public function getPaginationDates(): array;

    /**
     * @param  array<string, mixed>  $rules
     */
    public function rules_filters_dates(array &$rules): void;

    /**
     * @return ?array<mixed>
     */
    public function prepareForValidationForDates(): ?array;
}
