<?php

/**
 * Bedrock Site Health
 *
 * @wordpress-muplugin
 *
 * Plugin Name:  Bedrock Site Health
 * Plugin URI:   https://tinypixel.dev/open-source/plugins/bedrock-site-health
 * Description:  Roots-specific site health checkups.
 * Version:      1.0.0
 * Requires PHP: 7.2
 * Author:       Kelly Mears
 * Author URI:   https://tinypixel.dev/open-source/plugins/bedrock-site-health
 * License:      MIT
 * License URI:  https://github.com/pixelcollective/site-health/tree/master/LICENSE.md
 * Text Domain:  site-health
 * Domain Path:  resources/languages
 */

require __DIR__ . '/vendor/autoload.php';

use TinyPixel\SiteHealth\Plugin;

(new class {
    public function __invoke()
    {
        $siteHealth = new Plugin();

        $siteHealth->boot();

        $siteHealth->run();
    }
})();
