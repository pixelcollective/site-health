<?php

namespace TinyPixel\SiteHealth\Audits;

use TinyPixel\SiteHealth\Audits\AuditBuilder;
use TinyPixel\SiteHealth\Audits\Concerns\Checks;

/**
 * Base Audit
 *
 * @version 1.0.0
 * @since   1.0.0
 */
class BaseAudit
{
    use Checks;

    /**
     * Base directory for MU Plugins.
     *
     * @var string
     */
    public static $muPlugins = __DIR__ . '/../../..';

    /**
     * Audit builder
     */
    public $auditBuilder;

    /**
     * Constructor.
     *
     */
    public function __construct(AuditBuilder $auditBuilder)
    {
        $this->builder = $auditBuilder;

        return $this;
    }

    /**
     * Run audits and return arrayed results.
     *
     * @return array
     */
    public function run(string $function)
    {
        if ($this->shouldAudit($function) == true) {
            return [
                'label' => (string) $function,
                'function' => [$this, (string) $function],
            ];
        }
    }
}
