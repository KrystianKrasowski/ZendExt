<?php

namespace ZendExt\ServiceManager;

use Doctrine\Common\Annotations\AnnotationReader;
use ReflectionClass;
use Zend\ServiceManager\InitializerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ServiceManagerInjectionInitializer implements InitializerInterface
{
    public function initialize($instance, ServiceLocatorInterface $serviceLocator)
    {
        if (!is_object($instance)) {
            return;
        }

        $reflection = new ReflectionClass($instance);
        $annotations = new AnnotationReader();

        if ($annotations->getClassAnnotation($reflection, 'ZendExt\ServiceManager\Annotation\Service') === null) {
            return;
        }

        foreach ($reflection->getProperties() as $property) {
            $inject = $annotations->getPropertyAnnotation($property, 'ZendExt\ServiceManager\Annotation\ServiceManager');

            if ($inject === null) {
                continue;
            }

            $property->setAccessible(true);
            $property->setValue($instance, $serviceLocator);
        }
    }
}