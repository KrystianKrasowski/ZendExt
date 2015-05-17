<?php

namespace ZendExt\ServiceManager;

use ReflectionMethod;
use ReflectionProperty;
use Zend\ServiceManager\ServiceLocatorInterface;

class ConfigInjectionInitializer extends AbstractInjectionInitializer
{
    const CONFIG_ANNOTATION = 'ZendExt\ServiceManager\Annotation\Config';

    protected function processPropertyInjection(ReflectionProperty $property, $instance, ServiceLocatorInterface $serviceLocator)
    {
        $inject = $this->annotationReader->getPropertyAnnotation($property, self::CONFIG_ANNOTATION);

        if ($inject === null) {
            return;
        }

        $configValue = $this->getConfigValue($inject, $serviceLocator);

        $property->setAccessible(true);
        $property->setValue($instance, $configValue);
    }

    private function getConfigValue($inject, ServiceLocatorInterface $serviceLocator)
    {
        $configContainer = $serviceLocator->get('Config');
        $nestedKeys = explode('.', $inject->key);

        foreach ($nestedKeys as $key) {
            $configContainer = $configContainer[$key];
        }

        return $configContainer;
    }

    protected function processMethodInjection(ReflectionMethod $method, $instance, ServiceLocatorInterface $serviceLocator)
    {
        $inject = $this->annotationReader->getMethodAnnotation($method, self::CONFIG_ANNOTATION);

        if ($inject === null) {
            return;
        }

        $configValue = $this->getConfigValue($inject, $serviceLocator);

        $method->setAccessible(true);
        $method->invoke($instance, $configValue);
    }
}