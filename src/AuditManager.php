<?php

namespace TinyPixel\SiteHealth;

use DI\Container;
use TinyPixel\SiteHealth\Audits\AuditBuilder;

/**
 * Site audit manager.
 *
 */
class AuditManager
{
    /**
     * Audits
     *
     * @param array
     */
    protected $audits;

    /**
     * Results
     *
     * @param object
     */
    protected $results;

    /**
     * Constructor
     *
     * @param \DI\Container $container
     */
    public function __construct(
        Container $container,
        AuditBuilder $builder
    ) {
        $this->builder = $builder;
        $this->container = $container;

        $this->definitions = $container->make('audits');
    }

    /**
     * Run tests
     *
     * @param  array $audits
     * @return array
     */
    public function performAudits()
    {
        foreach ($this->definitions as $type => $audits) {
            $this->results[$type] = $this->runTests($audits);
        }

        return $this->results;
    }

    /**
     * Direct tests
     *
     * @return array
     */
    protected function runTests($audits = [])
    {
        $testResults = [];

        if ($audits) {
            foreach ($audits as $audit) {
                $testResults = $this->container->make($audit)->run($testResults);
            }
        }

        return $testResults;
    }
}
