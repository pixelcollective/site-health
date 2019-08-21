<?php

namespace TinyPixel\SiteHealth\Suites;

use TinyPixel\SiteHealth\Concerns\Checks;
use TinyPixel\SiteHealth\Concerns\WordPress;

/**
 * Tests: Bedrock plugins.
 *
 * @version 1.0.0
 * @since   1.0.0
 */
class BedrockPlugins
{
    use Checks;

    /**
     * Invoke
     *
     * @return array
     */
    public function __invoke($tests) : array
    {
        return [
            'disallow-indexing' => $tests['disallow-indexing'] == true ? [
                'test'  => [$this, 'disallowIndexing'],
            ] : null,

            'register-theme-directory' => $tests['register-theme-directory'] == true ? [
                'test'  => [$this, 'registerThemeDirectory'],
            ] : null,

            'autoloader' => $tests['autoloader'] == true ? [
                'test' => [$this, 'autoloader'],
            ] : null,
        ];
    }

    /**
     * Bedrock autoloader.
     *
     * @return array
     */
    public function autoloader()
    {
            $autoloaderAccessible = $this->isAccessible(__DIR__ . '/../../..', 'bedrock-autoloader');

            return [
                    'label' => 'Bedrock: Autoloader plugin present.',
                    'description' => __('Confirms that <code>bedrock-autoloader.php</code> is accessible from the <code>mu-plugins</code> directory.', 'roots'),
                    'status' => $autoloaderAccessible ?
                                'good' :
                                'recommended',
                    'badge'  => $autoloaderAccessible ?
                                ['label' => __('Autoloader found'), 'color' => 'green'] :
                                ['label' => __('Autoloader not found'), 'color' => 'red'],
                    'test' => 'autoloader'
            ];
    }

    /**
     * Bedrock autoloader.
     *
     * @return array
     */
    public function disallowIndexing()
    {
            $disallowIndexingAccessible = $this->isAccessible(__DIR__ . '/../../..', 'disallow-indexing');

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
     * Register theme directory.
     *
     * @return array
     */
    public function registerThemeDirectory()
    {

        $registerThemeDirAccessible = $this->isAccessible(__DIR__ . '/../../..', 'register-theme-directory');

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
