<?php

namespace TinyPixel\SiteHealth;

/**
 * Site audits manager.
 *
 */
class SiteAuditManager
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
     * Constructor.
     *
     * @param \DI\Container $container
     */
    public function __construct(\DI\Container $container)
    {
        $this->container = $container;

        $this->audits = $container->make('site.audits.all');

        $this->results = (object) [
            'direct' => [],
            'async'  => [],
        ];
    }

    /**
     * Run tests.
     *
     * @param  array $audits
     * @return array
     */
    public function performAudits(array $audits) : array
    {
        $this->direct();
        $this->async();

        return [
            'async'  => $this->results->async,
            'direct' => $this->results->direct,
        ];
    }

    /**
     * Direct tests.
     *
     * @return array
     */
    protected function direct() : array
    {
        foreach ($this->audits as $audit) {
            $this->results->direct = $this->container->make($audit)($audit);
        }

        return $this->results->direct;
    }

    /**
     * Asynchronous tests.
     *
     * @return array
     */
    protected function async() : array
    {
        return [];
    }
}
