<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Playground\Http\Requests\Contracts;

/**
 * \Playground\Http\Requests\StoreSlug
 */
interface StoreSlug
{
    /**
     * @param  array<string, string|array<string, mixed>>  $rules
     */
    public function rules_store_slug_create(array &$rules): void;

    /**
     * @param  array<string, string|array<string, mixed>>  $rules
     */
    public function rules_store_slug_update(array &$rules): void;

    /**
     * @return array<string, string>
     */
    public function prepareForValidationForSlug(): array;
}
