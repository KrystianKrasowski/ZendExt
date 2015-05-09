<?php

namespace ZendExt\ServiceManager;

use ReflectionMethod;
use ReflectionProperty;

class ConfigInjectionInitializer extends AbstractInjectionInitializer
{
    const CONFIG_ANNOTATION = 'ZendExt\ServiceManager\Annotation\Config';

    protected function processPropertyInjection(ReflectionProperty $property)
    {
        $inject = $this->annotationReader->getPropertyAnnotation($property, self::CONFIG_ANNOTATION);

        if ($inject === null) {
            return;
        }

        $configValue = $this->getConfigValue($inject);

        $property->setAccessible(true);
        $property->setValue($this->instance, $configValue);
    }

    private function getConfigValue($inject)
    {
        $configContainer = $this->serviceLocator->get('Config');
        $nestedKeys = explode('.', $inject->key);

        foreach ($nestedKeys as $key) {
            $configContainer = $configContainer[$key];
        }

        return $configContainer;
    }

    protected function processMethodInjection(ReflectionMethod $method)
    {
        $inject = $this->annotationReader->getMethodAnnotation($method, self::CONFIG_ANNOTATION);

        if ($inject === null) {
            return;
        }

        $configValue = $this->getConfigValue($inject);

        $method->setAccessible(true);
        $method->invoke($this->instance, $configValue);
    }
}