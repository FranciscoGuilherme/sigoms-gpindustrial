<?php

namespace App\Services;

use App\Interfaces\EnvironmentInterface;

/**
 * @package App\Services
 */
final class EnvironmentService implements EnvironmentInterface
{
    /**
     * @var array $config
     */
    private array $config = [];

    /**
     * @var array $routes
     */
    private array $routes = [];

    /**
     * @var array $resources
     */
    private array $resources = [];

    /**
     * @var array $websocket
     */
    private array $websocket = [];

    public function __construct()
    {
        $this->config = include('/app/config/environment.php');
        $this->routes = $this->config['routes'];
        $this->resources = $this->config['resources'];
        $this->websocket = $this->config['websocket'];
    }

    /**
     * {@inheritDoc}
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    /**
     * {@inheritDoc}
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }

    /**
     * {@inheritDoc}
     */
    public function getRoute(string $route): string
    {
        return $this->routes[$route];
    }

    /**
     * {@inheritDoc}
     */
    public function getResources(): array
    {
        return $this->resources;
    }

    /**
     * {@inheritDoc}
     */
    public function getResource(string $resource): string
    {
        return $this->resources[$resource];
    }

    /**
     * {@inheritDoc}
     */
    public function getWebSocket(): array
    {
        return $this->websocket;
    }
}