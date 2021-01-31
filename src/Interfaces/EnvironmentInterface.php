<?php

namespace App\Interfaces;

interface EnvironmentInterface
{
    /**
     * @return array
     */
    public function getConfig(): array;

    /**
     * @return array
     */
    public function getRoutes(): array;

    /**
     * @param string $route
     *
     * @return string
     */
    public function getRoute(string $route): string;

    /**
     * @return array
     */
    public function getResources(): array;

    /**
     * @param string $resource
     *
     * @return string
     */
    public function getResource(string $resource): string;

    /**
     * @param string $param
     *
     * @return string
     */
    public function getWebSocket(string $param): string;
}