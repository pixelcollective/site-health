<?php

namespace TinyPixel\SiteHealth\Audits;

/**
 * Audit Builder
 *
 * @version 1.0.0
 * @since   1.0.0
 */
class AuditBuilder
{
    /**
     * Label
     * @var string
     */
    public $label;

    /**
     * Description
     * @var string
     */
    public $description;

    /**
     * Test
     * @var string
     */
    public $test;

    /**
     * Status
     * @var string
     */
    public $status;

    /**
     * Badge
     * @var array
     */
    public $badge;

    /**
     * Condition
     * @var bool
     */
    public $condition;

    /**
     * Setter
     */
    public function __call($name, $value)
    {
        $this->$name = $value;

        return $this;
    }

    /**
     * When fail
     */
    public function fail($fail)
    {
        if ($this->condition == false) {
            $this->badge  = $fail['badge'];
            $this->status = $fail['status'];
        }

        return $this;
    }

    /**
     * Set properties if audit passed.
     */
    public function success($success)
    {
        if ($this->condition == true) {
            $this->badge  = $success['badge'];
            $this->status = $success['status'];
        }

        return $this;
    }

    /**
     * Return audit as an array
     */
    public function make() : array
    {
        return [
            'label'       => $this->label,
            'badge'       => $this->badge,
            'status'      => $this->status,
            'test'        => $this->test,
            'description' => $this->description,
        ];
    }
}
