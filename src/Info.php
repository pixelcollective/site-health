<?php

namespace TinyPixel\SiteHealth;

/**
 * Site health.
 */
class Info
{
    /**
     * Run tests.
     *
     * @param  array $tests
     * @return array
     */
    public function debug() : array
    {
        $tests['direct'] = $this->testDirect($tests['direct']);
        $tests['async']  = $this->testAsync($tests['async']);

        return $tests;
    }
}
