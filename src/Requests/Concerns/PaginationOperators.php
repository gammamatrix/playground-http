<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Playground\Http\Requests\Concerns;

/**
 * \Playground\Http\Requests\Concerns\PaginationColumns
 */
trait PaginationOperators
{
    /**
     * @return array<string, mixed>
     */
    public function getPaginationOperators(): array
    {
        return [
            '|' => [],
            '&' => [],
            '=' => [],
            '!=' => [],
            '<>' => [],
            '<=>' => [],
            '<' => [],
            '<=' => [],
            '>=' => [],
            'NULL' => [],
            'NOTNULL' => [],
            'LIKE' => [],
            'NOTLIKE' => [],
            'BETWEEN' => [],
            'NOTBETWEEN' => [],
        ];
    }
}
