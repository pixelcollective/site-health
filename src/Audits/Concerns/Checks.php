<?php

namespace TinyPixel\SiteHealth\Audits\Concerns;

trait Checks
{
    /**
     * Is accessible.
     *
     * @param  string $baseDir
     * @param  string $file
     * @return bool
     */
    public function isAccessible(string $baseDir, string $file) : bool
    {
        return file_exists("{$baseDir}/{$file}.php");
    }

    /**
     * Should test.
     *
     * @param  string $test
     * @return bool
     */
    protected function shouldAudit(string $test) : bool
    {
        return true;
    }
}
