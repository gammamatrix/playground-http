<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Playground\Http\Requests\Contracts;

/**
 * Playground\Http\Requests\Contracts\PaginationIds
 */
interface PaginationIds
{
    /**
     * @return array<string, mixed>
     */
    public function getPaginationIds(): array;

    /**
     * @param  array<string, mixed>  $rules
     */
    public function rules_filters_ids(array &$rules): void;

    /**
     * @return array<mixed>
     */
    public function prepareForValidationIds(): ?array;
}
