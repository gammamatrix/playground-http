<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Playground\Http\Requests\Concerns;

/**
 * \Playground\Http\Requests\Concerns\PaginationIds
 */
trait PaginationIds
{
    /**
     * @var array<string, mixed>
     */
    protected array $paginationIds = [
        'id' => ['label' => 'ID', 'type' => 'uuid'],
        // 'created_by_id' => ['label' => 'Created By', 'type' => 'uuid'],
        // 'modified_by_id' => ['label' => 'Modified By', 'type' => 'uuid'],
        // 'owned_by_id' => ['label' => 'Owner', 'type' => 'uuid'],
        // 'parent_id' => ['label' => 'Parent', 'type' => 'uuid'],
    ];

    /**
     * @return array<string, mixed>
     */
    public function getPaginationIds(): array
    {
        return $this->paginationIds;
    }

    /**
     * @param  array<string, mixed>  $rules
     */
    public function rules_filters_ids(array &$rules): void
    {
        foreach ($this->getPaginationIds() as $column => $meta) {
            if (empty($column) || ! is_string($column)) {
                continue;
            }

            $rule_key = sprintf('filter.%1$s', $column);

            $rules[$rule_key] = 'nullable';
        }
    }

    /**
     * @return array<mixed>
     */
    public function prepareForValidationIds(): array
    {
        $filter = $this->input('filter');
        $filter = empty($filter) || ! is_array($filter) ? [] : $filter;

        $merge = false;

        foreach ($this->getPaginationIds() as $column => $meta) {
            if (! empty($filter[$column])) {
                $id = [];
                if (is_array($filter[$column])) {
                    foreach ($filter[$column] as $key => $value) {
                        if (is_array($meta) && ! empty($meta['type']) && $meta['type'] === 'integer') {
                            if (is_numeric($value) && $value > 0) {
                                $id[] = intval($value);
                            }
                        } else {
                            if (is_string($value) && $value) {
                                $id[] = $value;
                            }
                        }
                    }
                } elseif (is_numeric($filter[$column]) && $filter[$column] > 0) {
                    $id[] = intval($filter[$column]);
                } elseif (is_string($filter[$column]) && $filter[$column]) {
                    $id[] = $filter[$column];
                }
                $filter[$column] = $id;
                $merge = true;
            }
        }

        if ($merge) {
            $this->merge([
                'filter' => $filter,
            ]);
        }

        return $filter;
    }
}
