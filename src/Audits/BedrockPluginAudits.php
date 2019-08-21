<?php

namespace TinyPixel\SiteHealth\Audits;

use TinyPixel\SiteHealth\Audits\Concerns\Checks;

/**
 * Tests: Bedrock plugins.
 *
 * @version 1.0.0
 * @since   1.0.0
 */
class BedrockPluginAudits
{
    use Checks;

    /**
     * Base directory for MU Plugins.
     *
     * @var string
     */
    public static $muPlugins = __DIR__ . '/../../..';

    /**
     * Invoke
     *
     * @return array
     */
    public function __invoke() : array
    {
        if ($this->shouldAudit('disallow-indexing') == true) {
            $results['disallow-indexing'] = [
                'test'  => [$this, 'disallowIndexing'],
            ];
        }

        if ($this->shouldAudit('register-theme-directory') == true) {
            $results['register-theme-directory'] = [
                'test'  => [$this, 'registerThemeDirectory'],
            ];
        }

        if ($this->shouldAudit('autoloader') == true) {
            $results['autoloader'] = [
                'test'  => [$this, 'autoloader'],
            ];
        }

        return $results;
    }

    /**
     * Test for bedrock-autoloader.php presence.
     *
     * @return array
     */
    public function autoloader()
    {
            $autoloaderAccessible = $this->isAccessible(self::$muPlugins, 'bedrock-autoloader');

            return [
                'label' => __('Bedrock: Autoloader plugin present.', 'roots'),
                'description' => __('Confirms that <code>bedrock-autoloader.php</code> is accessible from the <code>mu-plugins</code> directory.', 'roots'),
                'status' => $autoloaderAccessible ?
                    'good' :
                    'recommended',
                'badge'  => $autoloaderAccessible ?
                    ['label' => __('Autoloader found', 'roots'), 'color' => 'green' ] :
                    ['label' => __('Autoloader not found', 'roots'), 'color' => 'red'],
                'test' => 'autoloader'
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
                'status' => $disallowIndexingAccessible ?
                    'good' :
                    'recommended',
                'badge'  => $disallowIndexingAccessible ?
                    ['label' => __('Disallow indexing plugin found'), 'color' => 'green'] :
                    ['label' => __('Disallow indexing plugin not found'), 'color' => 'red'],
                'test' => 'disallow-indexing',
            ];
    }

    /**
     * Test for register-theme-directory.php presence.
     *
     * @return array
     */
    public function registerThemeDirectory()
    {

        $registerThemeDirAccessible = $this->isAccessible(self::$muPlugins, 'register-theme-directory');

        return [
            'label' => __('Bedrock: Register theme directory plugin present', 'sage'),
            'description' => __('Confirms that <code>register-theme-directory.php</code> is accessible from the <code>mu-plugins</code> directory.', 'roots'),
            'status' => $registerThemeDirAccessible ?
                'good' :
                'recommended',
            'badge'  => $registerThemeDirAccessible ?
                ['label' => __('Register theme directory plugin found'), 'color' => 'green'] :
                ['label' => __('Register theme directory plugin not found'), 'color' => 'red'],
            'test' => 'register-theme-directory'
        ];
    }
}
