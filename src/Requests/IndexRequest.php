<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Playground\Http\Requests;

/**
 * \Playground\Http\Requests\IndexRequest
 */
class IndexRequest extends FormRequest implements Contracts\PaginationColumns, Contracts\PaginationDates, Contracts\PaginationFlags, Contracts\PaginationIds, Contracts\PaginationOperators, Contracts\PaginationSortable
{
    use Concerns\PaginationColumns;
    use Concerns\PaginationDates;
    use Concerns\PaginationFlags;
    use Concerns\PaginationIds;
    use Concerns\PaginationOperators;
    use Concerns\PaginationSortable;

    /**
     * The number of models to return for pagination.
     *
     * @var int
     */
    protected $perPage = 15;

    /**
     * The maximum number of models to return for pagination.
     *
     * @var int
     */
    protected $perPageMax = 100;

    /**
     * @var array<string, string|array<mixed>>
     */
    public const RULES = [
        'perPage' => [
            'nullable',
            'integer',
        ],
        'page' => [
            'nullable',
            'integer',
        ],
        'sort' => [
            'nullable',
        ],
        'filter' => [
            'nullable',
            'array',
        ],
        // Trashed
        'filter.trash' => [
            'nullable',
            'in:hide,with,only',
        ],
    ];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = parent::rules();

        $this->rules_filters($rules);
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '__FILE__' => __FILE__,
        //     '__LINE__' => __LINE__,
        //     '$rules' => $rules,
        // ]);

        // \Log::debug(__METHOD__, [
        //     '$action' => $action,
        //     '$rules' => $rules,
        // ]);
        return $rules;
    }

    /**
     * @param  array<string, mixed>  $rules
     */
    public function rules_filters(array &$rules): void
    {
        if (method_exists($this, 'rules_filters_flags')) {
            $this->rules_filters_flags($rules);
        }
        if (method_exists($this, 'rules_filters_dates')) {
            $this->rules_filters_dates($rules);
        }
        if (method_exists($this, 'rules_filters_ids')) {
            $this->rules_filters_ids($rules);
        }
        if (method_exists($this, 'rules_filters_columns')) {
            $this->rules_filters_columns($rules);
        }
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '__FILE__' => __FILE__,
        //     '__LINE__' => __LINE__,
        //     '$this->input()' => $this->input(),
        // ]);

        $this->prepareForValidationPagination();

        if (method_exists($this, 'prepareForValidationForDates')) {
            $this->prepareForValidationForDates();
        }

        if (method_exists($this, 'prepareForValidationIds')) {
            $this->prepareForValidationSort();
        }

        if (method_exists($this, 'prepareForValidationIds')) {
            $this->prepareForValidationSort();
        }
    }

    /**
     * Handle a passed validation attempt.
     *
     * @return void
     */
    protected function passedValidation()
    {
        // NOTE sort could be converted back to a string
    }

    /**
     * @return array<string, ?int>
     */
    public function prepareForValidationPagination(): array
    {
        $page = $this->get('page');
        $page = is_numeric($page) ? (int) abs(intval($page)) : null;
        $perPage = $this->get('perPage');
        $perPage = is_numeric($perPage) ? (int) abs(intval($perPage)) : $this->perPage;
        $perPage = $perPage > $this->perPageMax ? $this->perPageMax : $perPage;

        $this->merge([
            'page' => $page,
            'perPage' => $perPage,
        ]);

        return [
            'page' => $page,
            'perPage' => $perPage,
        ];
    }
}
