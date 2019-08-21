<?php

namespace TinyPixel\SiteHealth;

/**
 * Site Report Manager.
 *
 */
class SiteReportManager
{
    /**
     * Info
     */
    protected $info;

    /**
     * WordPress hooks.
     *
     * @param  array $info
     * @return array
     */
    public function debugInfo() : array
    {
        $this->info['theme'] = $this->themeInfo($this->refs['getTheme']());

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
