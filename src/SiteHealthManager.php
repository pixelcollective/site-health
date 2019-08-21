<?php

namespace TinyPixel\SiteHealth;

use TinyPixel\SiteHealth\Concerns\WordPress;

/**
 * Site health manager.
 *
 */
class SiteHealthManager
{
    /**
     * Constructor.
     *
     * @param \DI\Container $container
     */
    public function __construct(\DI\Container $container)
    {
        $manager = $container->make('site.audits.manager');

        \add_filter('site_status_tests', [$manager, 'performAudits']);
    }
}
