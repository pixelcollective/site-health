<?php

namespace TinyPixel\SiteHealth\Audits;

use TinyPixel\SiteHealth\Audits\BaseAudit;

/**
 * Audit: Bedrock plugins.
 *
 * @version 1.0.0
 * @since   1.0.0
 */
class BedrockPluginAudits extends BaseAudit
{
    /**
     * Test for bedrock-autoloader.php presence.
     *
     * @return array
     */
    public function autoloader()
    {
        $autoloaderAccessible = $this->isAccessible(self::$muPlugins, 'bedrock-autoloader');

        return [
            'label' => __('Bedrock: MU-Plugin autoloader found.', 'sage'),
            'description' => __('Confirms that <code>bedrock-autoloader.php</code> is accessible from the <code>mu-plugins</code> directory.', 'roots'),
            'status' => $autoloaderAccessible ? 'good' : 'recommended',
            'badge'  => $autoloaderAccessible ?
                ['label' => __('Autoloader found', 'roots'), 'color' => 'green' ] :
                ['label' => __('Autoloader not found', 'roots'), 'color' => 'red'],
            'test' => __FUNCTION__,
        ];
    }

    /**
     * Test for disallow-indexing.php presence.
     *
     * @return array
     */
    public function disallowIndexing()
    {
        $disallowIndexingAccessible = $this->isAccessible(self::$muPlugins, 'disallow-indexing');

        return [
            'label' => __('Bedrock: Disallow indexing plugin present', 'sage'),
            'description' => __('Confirms that <code>disallow-indexing.php</code> is accessible from the <code>mu-plugins</code> directory.', 'roots'),
            'status' => $disallowIndexingAccessible ? 'good' : 'recommended',
            'badge'  => $disallowIndexingAccessible ?
                ['label' => __('Disallow indexing plugin found'), 'color' => 'green'] :
                ['label' => __('Disallow indexing plugin not found'), 'color' => 'red'],
            'test' => __FUNCTION__,
        ];
    }

    /**
     * Test for register-theme-directory.php presence.
     *
     * @return array
     */
    public function registerThemeDirectory()
    {
        $test    = $this->isAccessible(self::$muPlugins, 'register-theme-directory');

        ($results = new $this->builder())
            ->test(__FUNCTION__)
            ->label(__('Bedrock: Register theme directory plugin present', 'sage'))
            ->description(__('Confirms that <code>register-theme-directory.php</code> is accessible from the <code>mu-plugins</code> directory.', 'roots'))
            ->condition($test)
                ->success(['status' => 'good', 'badge' => [
                    'label' => __('Register theme directory plugin found', 'sage'),
                    'color' => 'green'
                ]])
                ->fail(['status' => 'recommend', 'badge' => [
                    'label' => __('Register theme directory plugin not found', 'sage'),
                    'color' => 'red'
                ]]);

        return $results->make();
    }
}
