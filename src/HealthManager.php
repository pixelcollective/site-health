<?php

namespace TinyPixel\SiteHealth;

use TinyPixel\SiteHealth\Concerns\WordPress;

/**
 * Site health manager.
 *
 */
class HealthManager
{
    /**
     * Constructor
     *
     * @param \DI\Container $container
     */
    public function __construct(\DI\Container $container)
    {
        $auditManager = $container->make('audits.manager');
        $reportManager = $container->make('reports.manager');

        \add_filter('site_status_tests', [$auditManager, 'performAudits']);
    }
}
