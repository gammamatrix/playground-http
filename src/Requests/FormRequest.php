<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Playground\Http\Requests;

use Illuminate\Foundation\Http\FormRequest as BaseFormRequest;

/**
 * \Playground\Http\Requests\FormRequest
 */
class FormRequest extends BaseFormRequest
{
    /**
     * @var array<string, string|array<mixed>>
     */
    public const RULES = [];

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // return true;
        $user = $this->user();

        if (empty($user)) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = is_array(static::RULES) ? static::RULES : [];

        return $rules;
    }
}
