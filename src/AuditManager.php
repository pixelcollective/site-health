<?php

namespace TinyPixel\SiteHealth;

use DI\Container;
use TinyPixel\SiteHealth\Audits\AuditBuilder;
use TinyPixel\SiteHealth\Audits\Concerns\Checks;

/**
 * Site audit manager.
 *
 */
class AuditManager
{
    use Checks;

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

        $this->suites = $this->container->make('audits');

        $this->results = [
            'direct' => [],
            'async'  => [],
        ];
    }

    /**
     * Run audits and return arrayed results.
     *
     * @return array
     */
    public function runAudits($audits)
    {
        array_map(
            [$this, 'runTests'],
            array_keys($this->suites),
            array_values($this->suites),
        );

        return $this->results;
    }

    /**
     * Run an audit's tests.
     *
     * @return array
     */
    public function runTests(string $suite, array $tests)
    {
        $class = $this->container->make($suite);

        foreach (array_map([$class, 'run'], $tests) as $result) {
            $this->results['direct'][$result['label']] = [
                'test' => $result['function']
            ];
        }
    }
}
