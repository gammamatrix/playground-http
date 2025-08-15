<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Playground\Http\Requests\Concerns;

use Illuminate\Support\Str;

/**
 * \Playground\Http\Requests\Concerns\StoreSlug
 */
trait StoreSlug
{
    protected string $slug_table = '';

    /**
     * @param  array<string, mixed>  $rules
     */
    public function rules_store_slug_create(array &$rules): void
    {
        $rules['slug'] = [
            'nullable',
            'string',
        ];

        if ($this->slug_table) {
            $rules['slug'][] = sprintf('unique:%1$s', $this->slug_table);
        }
    }

    /**
     * @param  array<string, mixed>  $rules
     */
    public function rules_store_slug_update(array &$rules): void
    {
        $rules['slug'] = [
            'nullable',
            'string',
        ];

        if ($this->slug_table) {
            /**
             * @var int|string $id
             */
            $id = $this->id;
            $rules['slug'][] = sprintf('unique:%1$s,id,%2$s', $this->slug_table, $id);
        }
    }

    /**
     * @return array{
     *     slug: string,
     *     label: string,
     *     title: string
     * }
     */
    public function prepareForValidationForSlug(): array
    {
        $slug = $this->get('slug');
        $title = $this->get('title');
        $label = $this->get('label');

        $merge = false;

        if (empty($slug) && (! empty($label) || ! empty($title))) {
            if (! empty($title) && is_string($title)) {
                $merge = true;
                $slug = Str::of($title)->slug('-')->toString();
            } elseif (! empty($label) && is_string($label)) {
                $merge = true;
                $slug = Str::of($label)->slug('-')->toString();
            }
        } elseif (! empty($slug) && is_string($slug)) {
            $merge = true;
            $slug = Str::of($slug)->slug('-')->toString();
        }

        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '__FILE__' => __FILE__,
        //     '__LINE__' => __LINE__,
        //     '$merge' => $merge,
        //     '$slug' => $slug,
        //     '$title' => $title,
        //     '$label' => $label,
        // ]);

        if ($merge) {
            $this->merge([
                'slug' => $slug,
            ]);
        }

        return [
            'slug' => is_string($slug) ? $slug : '',
            'label' => is_string($label) ? $label : '',
            'title' => is_string($title) ? $title : '',
        ];
    }
}
