<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Playground\Http\Requests;

/**
 * \Playground\Http\Requests\StoreRequest
 */
class StoreRequest extends FormRequest implements Contracts\StoreContent, Contracts\StoreFilter, Contracts\StoreSlug
{
    use Concerns\StoreContent;
    use Concerns\StoreFilter;
    use Concerns\StoreSlug;

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'slug.unique' => __('playground-http::validation.slug.unique'),
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $rules = parent::rules();

        $this->rules_store_slug_create($rules);

        return $rules;
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->prepareForValidationForSlug();
    }
}
