<?php

namespace ZendExt\ServiceManager;

use ReflectionMethod;
use ReflectionProperty;

class ServiceInjectionInitializer extends AbstractInjectionInitializer
{
    const INJECT_ANNOTATION = 'ZendExt\ServiceManager\Annotation\Inject';

    protected function processPropertyInjection(ReflectionProperty $property)
    {
        $inject = $this->annotationReader->getPropertyAnnotation($property, self::INJECT_ANNOTATION);

        if ($inject === null) {
            return;
        }

        $service = $this->serviceLocator->get($inject->name);
        $property->setAccessible(true);
        $property->setValue($this->instance, $service);
    }

    protected function processMethodInjection(ReflectionMethod $method)
    {
        $inject = $this->annotationReader->getMethodAnnotation($method, self::INJECT_ANNOTATION);

        if ($inject === null) {
            return;
        }

        $service = $this->serviceLocator->get($inject->name);
        $method->setAccessible(true);
        $method->invoke($this->instance, $service);
    }
}