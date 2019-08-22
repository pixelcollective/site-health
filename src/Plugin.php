<?php

namespace TinyPixel\SiteHealth;

use function DI\get;
use function DI\autowire;
use DI\Container;
use DI\ContainerBuilder;
use TinyPixel\SiteHealth\AuditManager;
use TinyPixel\SiteHealth\ReportManager;
use TinyPixel\SiteHealth\HealthManager;
use TinyPixel\SiteHealth\Audits\AuditBuilder;
use TinyPixel\SiteHealth\Audits\BedrockPluginAudits;

/**
 * Plugin runtime
 *
 */
class Plugin
{
    /**
     * Builder
     *
     * @param \DI\Builder
     */
    protected $builder;

    /**
     * Container
     *
     * @param \DI\Container
     */
    protected $container;

    /**
     * Audits
     *
     * @param array
     */
    protected $audits = [
        BedrockPluginAudits::class => [
            'disallowIndexing',
            'autoloader',
            'registerThemeDirectory',
        ],
    ];

    /**
     * Reports
     *
     * @param array
     */
    protected $reports = [];

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->builder = new \DI\ContainerBuilder();
    }

    /**
     * Run plugin.
     */
    public function run()
    {
        $this->container->make('health.manager');
    }

    /**
     * Boot container service.
     *
     * @return void
     */
    public function boot() : void
    {
        $this->configureContainer();

        $this->defineContainerServices();

        $this->defineContainerAliases();

        $this->container = $this->buildContainer();
    }

    /**
     * Build container.
     *
     * @return DI\Container
     */
    public function buildContainer() : Container
    {
        return $this->builder->build();
    }

    /**
     * Configure container.
     *
     * @return void
     */
    public function configureContainer() : void
    {
        $this->builder->useAnnotations(false)
                      ->useAutowiring(true);
    }

    /**
     * Define services.
     *
     * @return void
     */
    public function defineContainerServices() : void
    {
        $this->builder->addDefinitions([
            AuditBuilder::class        => autowire(),
            BedrockPluginAudits::class => autowire(),
            SiteHealthManager::class   => autowire(),
            SiteReportManager::class   => autowire(),
            SiteAuditManager::class    => autowire()->constructor(),
        ]);
    }

    /**
     * Define service aliases.
     *
     * @return void
     */
    public function defineContainerAliases() : void
    {
        $this->builder->addDefinitions([
            'health.manager'  => get(HealthManager::class),
            'audits.manager'  => get(AuditManager::class),
            'reports.manager' => get(ReportManager::class),
            'audits.builder'  => get(AuditBuilder::class),
            'audits.bedrock.plugins' => get(BedrockPluginAudits::class),
            'audits'  => $this->audits,
            'reports' => $this->reports,
        ]);
    }
}
