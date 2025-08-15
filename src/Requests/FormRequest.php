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
     * @var array<string, mixed>
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
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return static::RULES;
    }
}
