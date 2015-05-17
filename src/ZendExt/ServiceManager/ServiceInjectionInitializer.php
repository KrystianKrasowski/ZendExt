<?php

namespace ZendExt\ServiceManager;

use ReflectionMethod;
use ReflectionProperty;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\ServiceLocatorInterface;

class ServiceInjectionInitializer extends AbstractInjectionInitializer
{
    const INJECT_ANNOTATION = 'ZendExt\ServiceManager\Annotation\Inject';

    protected function processPropertyInjection(ReflectionProperty $property, $instance, ServiceLocatorInterface $serviceLocator)
    {
        $inject = $this->annotationReader->getPropertyAnnotation($property, self::INJECT_ANNOTATION);

        if ($inject === null) {
            return;
        }

        if (!$serviceLocator->has($inject->name)) {
            throw new ServiceNotFoundException(sprintf('Service %s is not defined', $inject->name));
        }

        $service = $serviceLocator->get($inject->name);
        $property->setAccessible(true);
        $property->setValue($instance, $service);
    }

    protected function processMethodInjection(ReflectionMethod $method, $instance, ServiceLocatorInterface $serviceLocator)
    {
        $inject = $this->annotationReader->getMethodAnnotation($method, self::INJECT_ANNOTATION);

        if ($inject === null) {
            return;
        }

        if (!$serviceLocator->has($inject->name)) {
            throw new ServiceNotFoundException(sprintf('Service %s is not defined', $inject->name));
        }

        $service = $serviceLocator->get($inject->name);
        $method->setAccessible(true);
        $method->invoke($instance, $service);
    }
}