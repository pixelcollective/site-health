<?php

/**
 * Bedrock Site Health
 *
 * @wordpress-plugin
 *
 * Plugin Name:       Bedrock Site Health
 * Plugin URI:        https://tinypixel.dev/open-source/plugins/bedrock-site-health
 * Description:       Site Health modifications
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Your Name
 * Author URI:        https://example.com
 * Text Domain:       plugin-slug
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

require __DIR__ . '/tests.php';

class SiteHealth
{
    use Tests;

    /**
     * Enabled tests
     * @var array
     */
    protected $enabled = [
        'bedrock-autoloader' => true,
        'disallow-indexing'  => true,
        'register-theme-directory' => true,
    ];

    /**
     * Constructor.
     *
     */
    public function __construct()
    {
        $this->refs = [
            'sslEnabled'   => 'is_ssl',
            'getTheme'     => 'wp_get_theme',
            'getUploadDir' => 'wp_get_upload_dir',
        ];
    }

    /**
     * Invoke.
     */
    public function __invoke()
    {
        \add_filter('debug_information', [$this, 'debugInfo']);
        \add_filter('site_status_tests', [$this, 'debugTest']);
    }

    /**
     * Run tests.
     *
     * @param  array $tests
     * @return array
     */
    public function debugTest($tests) : array
    {
        $tests = ['async' => [], 'direct' => []];

        $tests['direct'] = $this->testDirect($tests['direct']);
        $tests['async']  = $this->testAsync($tests['async']);

        return $tests;
    }

    /**
     * Direct tests.
     *
     * @param  array $tests
     * @return array
     */
    protected function testDirect($tests) : array
    {
        $tests = $this->bedrockPluginChecks($tests);

        return $tests;
    }

    /**
     * Asynchronous tests.
     *
     * @param  array $async
     * @return array
     */
    protected function testAsync($async = []) : array
    {
        return $async;
    }

    /**
     * Bedrock Plugin Checks.
     *
     * @return array
     */
    public function bedrockPluginChecks($bedrockPluginChecks = []) : array
    {
        $bedrockPluginChecks['bedrock-autoloader'] = [
            'label' => __('Bedrock: Autoloader plugin present', 'sage'),
            'test'  => [$this, 'bedrockAutoloader'],
        ];

        $bedrockPluginChecks['disallow-indexing'] = [
            'label' => __('Bedrock: Disallow indexing plugin present', 'sage'),
            'test'  => [$this, 'disallowIndexing'],
        ];

        $bedrockPluginChecks['register-theme-directory'] = [
            'label' => __('Bedrock: Register theme directory plugin present', 'sage'),
            'test'  => [$this, 'registerThemeDirectory'],
        ];

        return $bedrockPluginChecks;
    }

    /**
     * Bedrock autoloader.
     */
    public function bedrockAutoloader()
    {
        if ($this->shouldTest('bedrock-autoloader')) {
            $autoloaderAccessible = $this->isAccessible(__DIR__ . '/..', 'bedrock-autoloader');

            return [
                'label'       => __('Bedrock Autoloader', 'roots'),
                'description' => __('Confirms that <code>bedrock-autoloader.php</code> is accessible from the <code>mu-plugins</code> directory.', 'roots'),
                'status' => $autoloaderAccessible ?
                            'good' :
                            'recommended',
                'badge'  => $autoloaderAccessible ?
                            ['label' => __('Autoloader found'), 'color' => 'green'] :
                            ['label' => __('Autoloader not found'), 'color' => 'red'],
                'test'   => 'bedrock-autoloader',
            ];
        }
    }

    /**
     * Bedrock autoloader.
     */
    public function disallowIndexing()
    {
        if ($this->shouldTest('disallow-indexing')) {
            $disallowIndexingAccessible = $this->isAccessible(__DIR__ . '/..', 'disallow-indexing');

            return [
                'label'       => __('Disallow indexing plugin', 'roots'),
                'description' => __('Confirms that <code>disallow-indexing.php</code> is accessible from the <code>mu-plugins</code> directory.', 'roots'),
                'status' => $disallowIndexingAccessible ?
                            'good' :
                            'recommended',
                'badge'  => $disallowIndexingAccessible ?
                            ['label' => __('Disallow indexing plugin found'), 'color' => 'green'] :
                            ['label' => __('Disallow indexing plugin not found'), 'color' => 'red'],
                'test'   => 'disallow-indexing',
            ];
        }
    }

    /**
     * Register theme directory.
     */
    public function registerThemeDirectory()
    {
        if ($this->shouldTest('register-theme-directory')) {
            $registerThemeDirAccessible = $this->isAccessible(__DIR__ . '/..', 'register-theme-directory');

            return [
                'label'       => __('Bedrock register theme directory plugin', 'roots'),
                'description' => __('Confirms that <code>register-theme-directory.php</code> is accessible from the <code>mu-plugins</code> directory.', 'roots'),
                'status' => $registerThemeDirAccessible ?
                            'good' :
                            'recommended',
                'badge'  => $registerThemeDirAccessible ?
                            ['label' => __('Register theme directory plugin found'), 'color' => 'green'] :
                            ['label' => __('Register theme directory plugin not found'), 'color' => 'red'],
                'test'   => 'register-theme-directory',
            ];
        }
    }

    /**
     * Should test.
     *
     * @param  string $test
     * @return bool
     */
    protected function shouldTest(string $test) : bool
    {
        return isset($this->enabled[$test]) && $this->enabled[$test] == true;
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

(new SiteHealth())();

/* if (shouldTest('disallow-indexing')) {
    if (file_exists(__DIR__ . '/disallow-indexing.php')) {
        $this->tests['disallow-indexing'] = true;
    } else {
        $this->tests['disallow-indexing'] = false;
    }
}

if (shouldTest('register-theme-directory')) {
    if (file_exists(__DIR__ . '/register-theme-directory.php')) {
        $this->tests['register-theme-directory'] = true;
    } else {
        $this->tests['register-theme-directory'] = false;
    }
} */
