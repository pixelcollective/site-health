<?php

/**
 * Bedrock Site Health
 *
 * @wordpress-muplugin
 *
 * Plugin Name:       Bedrock Site Health
 * Plugin URI:        https://tinypixel.dev/open-source/plugins/bedrock-site-health
 * Description:       Roots-specific site health checkups.
 * Version:           1.0.0
 * Requires at least: 7.2
 * Requires PHP:      7.2
 * Author:            Kelly Mears
 * Author URI:        https://tinypixel.dev/open-source/plugins/bedrock-site-health
 * Text Domain:       plugin-slug
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

require __DIR__ . '/vendor/autoload.php';

$siteHealth = new TinyPixel\SiteHealth\Plugin();
$siteHealth->boot();
$siteHealth->run();
