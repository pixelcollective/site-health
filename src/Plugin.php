<?php

namespace TinyPixel\SiteHealth;

use \ApcCache;
use function DI\get;
use function DI\autowire;
use DI\ContainerBuilder;
use DI\Container;
use TinyPixel\SiteHealth\SiteHealth;
use TinyPixel\SiteHealth\Info;
use TinyPixel\SiteHealth\Tests;
use TinyPixel\SiteHosts\Audits\BedrockPlugins;

/**
 * Plugin runtime
 *
 */
class Plugin
{
    /**
     * Builder
     *
     * @param \TinyPixel\SiteHealth\Builder
     */
    protected $builder;

    /**
     * Container
     *
     * @param \TinyPixel\SiteHealth\Container
     */
    protected $container;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->builder = new ContainerBuilder();
    }

    /**
     * Run plugin.
     */
    public function run()
    {
        $siteHealth = $this->container->make('health.manager');
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
            \TinyPixel\SiteHealth\SiteHealthManager::class => autowire(),
            \TinyPixel\SiteHealth\SiteAuditManager::class => autowire(),
            \TinyPixel\SiteHealth\SiteReportManager::class => autowire(),
            \TinyPixel\SiteHealth\Audits\BedrockPluginAudits::class => autowire(),
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
            'health.manager' =>
                get(\TinyPixel\SiteHealth\SiteHealthManager::class),
            'site.reports.manager' =>
                get(\TinyPixel\SiteHealth\SiteReportManager::class),
            'site.audits.manager' =>
                get(\TinyPixel\SiteHealth\SiteAuditManager::class),
            'site.audits.bedrock.plugins' =>
                get(\TinyPixel\SiteHealth\Audits\BedrockPluginAudits::class),
            'site.audits.all' => [
                'site.audits.bedrock.plugins',
            ],
        ]);
    }
}
