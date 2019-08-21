<?php

namespace TinyPixel\SiteHealth;

use TinyPixel\SiteHealth\Suites\BedrockPlugins;

/**
 * Site health.
 */
class Tests
{
    /**
     * Sets.
     * @var array
     */
    protected $sets = [
        'async'  => [],
        'direct' => [],
    ];

    /**
     * Constructor.
     *
     */
    public function __construct()
    {
        $this->tests = [
            'bedrock.plugins' => [
                'autoloader' => true,
                'disallow-indexing' => true,
                'register-theme-directory' => true,
            ],
        ];

        $this->suites = [
            'bedrock.plugins' => [
                'label'   => 'bedrock-plugins',
                'invoke'  => new BedrockPlugins(),
                'tests'   => $this->tests['bedrock.plugins'],
                'enabled' => true,
            ],
        ];
    }

    /**
     * Run tests.
     *
     * @return array
     */
    public function suites($sets) : array
    {
        $sets['async'] = [];
        $sets['direct'] = $this->direct();

        return $sets;
    }

    /**
     * Direct tests.
     *
     * @param  array $results
     * @return array
     */
    protected function direct() : array
    {
        $results = [];

        foreach($this->suites as $suite => $params) {
            if($params['enabled'] == true) {
                $results = $params['invoke']($params['tests']);
            }
        }

        return $results;
    }

    /**
     * Asynchronous tests.
     *
     * @param  array $async
     * @return array
     */
    protected function async($async = []) : array
    {
        return $async;
    }
}
