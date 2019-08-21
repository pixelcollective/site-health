<?php

namespace TinyPixel\SiteHealth;

use TinyPixel\SiteHealth\Concerns\WordPress;
use TinyPixel\SiteHealth\Info;
use TinyPixel\SiteHealth\Tests;

/**
 * Site health.
 */
class SiteHealth
{
    use WordPress;

    /**
     * Invoke.
     */
    public function __invoke()
    {
        $this->mappings();
        $this->accessors();

        $this->info  = new Info();
        $this->tests = new Tests();

        \add_filter('site_status_tests', [$this->tests, 'suites']);
    }

    /**
     * WordPress hooks.
     *
     * @param  array $info
     * @return array
     */
    public function debugInfo(array $info) : array
    {
        $info = [];

        $info['theme'] = $this->themeInfo($this->refs['getTheme']());

        return $info;
    }

    /**
     * Add theme info.
     *
     * @param  array $theme
     * @return array
     */
    protected function themeInfo($theme) : array
    {
        return [
            'label'  => __('Theme', 'roots'),
            'description' => __('Shows information about currently active theme', 'roots'),
            'fields' => [
                'theme' => [
                    'label'   => __('Name', 'sage'),
                    'value'   => $theme->get('Name'),
                    'private' => false,
                ],
                'version' => [
                    'label'   => __('Version', 'sage'),
                    'value'   => $theme->get('Version'),
                    'private' => false,
                ],
            ],
        ];
    }
}
