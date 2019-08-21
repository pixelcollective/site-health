<?php

namespace TinyPixel\SiteHealth\Concerns;

use function \add_filter;
use function \is_ssl;
use function \wp_get_theme;
use function \wp_get_upload_dir;

trait WordPress
{
    /**
     * WordPress accessor mappings
     */
    protected function mappings()
    {
        $this->mappings = [
            'addFilter' => [$this, 'addFilter'],
            'isSSL'     => \is_ssl(),
            'getTheme'     => \wp_get_theme(),
            'getUploadDir' => \wp_get_upload_dir(),
        ];
    }

    protected function addFilter($hook, $action) {
        return \add_filter($hook, $action);
    }

    /**
     * WordPress accessors
     */
    protected function accessors()
    {
        array_map(function ($wpFn) {
            return $wpFn;
        }, $this->mappings);
    }

    protected function wpFunction($wpFn)
    {
        return $wpFn;
    }
}
