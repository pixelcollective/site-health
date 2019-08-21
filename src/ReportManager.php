<?php

namespace TinyPixel\SiteHealth;

use \WP_Theme;

/**
 * Site Report Manager.
 *
 */
class ReportManager
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
    public function generateReports() : array
    {
        $this->info['theme'] = $this->themeInfo(\wp_get_theme());

        return $this->info;
    }

    /**
     * Add theme info.
     *
     * @param  WP_Theme $theme
     * @return array
     */
    protected function themeInfo(WP_Theme $theme) : array
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
