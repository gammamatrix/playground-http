<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Playground\Http\Requests\Contracts;

/**
 * \Playground\Http\Requests\Contracts\PaginationFlags
 */
interface PaginationFlags
{
    /**
     * @return array<string, mixed>
     */
    public function getPaginationFlags(): array;

    /**
     * @param  array<string, mixed>  $rules
     */
    public function rules_filters_flags(array &$rules): void;
}
