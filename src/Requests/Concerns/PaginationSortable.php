<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Playground\Http\Requests\Concerns;

/**
 * \Playground\Http\Requests\Concerns\PaginationSortable
 */
trait PaginationSortable
{
    /**
     * @var array<string, mixed>
     */
    protected array $sortable = [
        'label' => ['label' => 'Label', 'type' => 'string'],
        // 'rank' => ['label' => 'Rank', 'type' => 'numeric'],
        // 'slug' => ['label' => 'Slug', 'type' => 'string'],
        // 'active' => ['label' => 'Active', 'type' => 'boolean'],
        // 'flagged' => ['label' => 'Flagged', 'type' => 'boolean'],
        // 'locked' => ['label' => 'Locked', 'type' => 'boolean'],
    ];

    /**
     * @return array<string, mixed>
     */
    public function getSortable(): array
    {
        return $this->sortable;
    }

    /**
     * @param  array<string, mixed>  $rules
     */
    public function rules_sortable(array &$rules): void
    {
        $sortable = $this->getSortable();

        if (! empty($sortable)) {
            $rules['sort.*'] = [
                'string',
            ];
            $rules['sort.*'][] = sprintf('in:%1$s', sprintf(
                '%1$s,-%2$s',
                implode(',', array_keys($sortable)),
                implode(',-', array_keys($sortable))
            ));
        }
    }

    /**
     * @return array<string, mixed>
     */
    public function prepareForValidationSort(): array
    {
        $sortable = [];

        $sort = $this->input('sort');

        if (! empty($sort)) {
            if (is_string($sort)) {
                // Convert sort to array
                $sortable = explode(',', $sort);
            } elseif (is_array($sort)) {
                $sortable = $sort;
            }
        }

        $this->merge([
            'sort' => $sortable,
        ]);

        return $sortable;
    }
}
