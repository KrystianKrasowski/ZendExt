<?php

namespace ZendExt\ServiceManager;

use Doctrine\Common\Annotations\AnnotationReader;
use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;
use Zend\ServiceManager\InitializerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ServiceManagerInjectionInitializer extends AbstractInjectionInitializer
{
    const SERVICES_ANNOTATION = 'ZendExt\ServiceManager\Annotation\ServiceManager';

    protected function processPropertyInjection(ReflectionProperty $property)
    {
        $inject = $this->annotationReader->getPropertyAnnotation($property, self::SERVICES_ANNOTATION);

        if ($inject === null) {
            return;
        }

        $property->setAccessible(true);
        $property->setValue($this->instance, $this->serviceLocator);
    }

    protected function processMethodInjection(ReflectionMethod $method)
    {
        $inject = $this->annotationReader->getMethodAnnotation($method, self::SERVICES_ANNOTATION);

        if ($inject === null) {
            return;
        }

        $method->setAccessible(true);
        $method->invoke($this->instance, $this->serviceLocator);
    }
}