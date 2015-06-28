<?php

namespace ZendExt\Plugin;

use Zend\Mvc\Router\RouteInterface;
use Zend\Mvc\Router\RouteMatch as BaseRouteMatch;
use Zend\Stdlib\Request;
use ZendExt\ServiceManager\Annotation\Inject;
use ZendExt\ServiceManager\Annotation\Service;

/**
 * @Service()
 */
class RouteMatch
{
    /**
     * @var RouteInterface
     * @Inject(name="Router")
     */
    private $router;

    /**
     * @var Request
     * @Inject(name="Request")
     */
    private $request;

    /**
     * @var BaseRouteMatch
     */
    private $routeMatch;

    public function getRouteParam($key, $default = null)
    {
        return $this
            ->getRouteMatch()
            ->getParam($key, $default);
    }

    public function getRouteMatch()
    {
        if ($this->routeMatch === null) {
            $this->buildRouteMatch();
        }

        return $this->routeMatch;
    }

    private function buildRouteMatch()
    {
        $this->routeMatch = $this->router->match($this->request);
    }
}