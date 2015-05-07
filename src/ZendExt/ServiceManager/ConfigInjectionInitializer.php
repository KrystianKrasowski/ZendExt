<?php

namespace ZendExt\ServiceManager;

use Doctrine\Common\Annotations\AnnotationReader;
use ReflectionClass;
use Zend\ServiceManager\InitializerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ConfigInjectionInitializer implements InitializerInterface
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
            $inject = $annotations->getPropertyAnnotation($property, 'ZendExt\ServiceManager\Annotation\Config');

            if ($inject === null) {
                continue;
            }

            $configContainer = $serviceLocator->get('Config');
            $nestedKeys = explode('.', $inject->key);

            foreach ($nestedKeys as $key) {
                $configContainer = $configContainer[$key];
            }

            $property->setAccessible(true);
            $property->setValue($instance, $configContainer);
        }
    }
}