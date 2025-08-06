<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Playground\Http\Requests\Concerns;

use HTMLPurifier;

/**
 * \Playground\Http\Requests\Concerns\StoreContent
 */
trait StoreContent
{
    protected ?HTMLPurifier $purifier = null;

    protected ?string $safeIframeRegexp = '%^(https?:)?(\/\/www\.youtube(?:-nocookie)?\.com\/embed\/|\/\/player\.vimeo\.com\/)%';

    /**
     * Exorcise all html from the string.
     *
     * @uses \htmlspecialchars()
     * @uses \strip_tags()
     */
    public static function exorcise(mixed $content): string
    {
        return is_string($content) ? htmlspecialchars(
            strip_tags($content),
            ENT_HTML5
        ) : '';
    }

    /**
     * Purify a string with HTMLPurifier.
     */
    public function purify(mixed $content): string
    {
        return is_string($content) ? $this->getHtmlPurifier()->purify($content) : '';
    }

    /**
     * Get HTMLPurifier
     *
     * @param  array<string, mixed>  $config
     */
    public function getHtmlPurifier(array $config = []): HTMLPurifier
    {
        if ($this->purifier === null) {
            $hpc = \HTMLPurifier_Config::createDefault();

            /**
             * @var array<string, string>
             */
            $purifier = empty($config) ? config('playground-http.purifier') : $config;

            $serializerPath = null;

            if (is_array($purifier) && ! empty($purifier)) {

                if (array_key_exists('iframes', $purifier)
                    && (is_null($purifier['iframes']) || (is_string($purifier['iframes']) && $purifier['iframes']))
                ) {
                    $this->safeIframeRegexp = $purifier['iframes'];
                }

                if (! empty($purifier['path'])
                    && is_string($purifier['path'])
                ) {
                    $serializerPath = $purifier['path'];
                }
            }

            if ($serializerPath) {
                $hpc->set('Cache.SerializerPath', $serializerPath);
            }

            if ($this->safeIframeRegexp) {
                $hpc->set('HTML.SafeIframe', true);
                $hpc->set('URI.SafeIframeRegexp', $this->safeIframeRegexp);
            }

            $this->purifier = new HTMLPurifier($hpc);
        }

        return $this->purifier;
    }
}
