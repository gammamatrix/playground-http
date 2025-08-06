<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Playground\Http\Requests\Contracts;

use HTMLPurifier;

/**
 * \Playground\Http\Requests\Contracts\StoreContent
 */
interface StoreContent
{
    /**
     * Exorcise all html from the string.
     *
     * @uses \htmlspecialchars()
     * @uses \strip_tags()
     */
    public static function exorcise(mixed $content): string;

    /**
     * Purify a string with HTMLPurifier.
     */
    public function purify(mixed $content): string;

    /**
     * Get HTMLPurifier
     *
     * @param  array<string, mixed>  $config
     */
    public function getHtmlPurifier(array $config = []): HTMLPurifier;
}
