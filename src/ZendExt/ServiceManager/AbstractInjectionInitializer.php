<?php

namespace ZendExt\ServiceManager;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;
use Zend\ServiceManager\InitializerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

abstract class AbstractInjectionInitializer implements InitializerInterface
{
    /**
     * @var AnnotationReader
     */
    protected $annotationReader;

    /**
     * @var ServiceLocatorInterface
     */
    protected $serviceLocator;

    /**
     * @var object|array
     */
    protected $instance;

    public function __construct()
    {
        $this->annotationReader = new AnnotationReader();
        AnnotationRegistry::registerLoader('class_exists');
        AnnotationReader::addGlobalIgnoredName('triggers');
    }

    public function initialize($instance, ServiceLocatorInterface $serviceLocator)
    {
        if (!is_object($instance)) {
            return;
        }

        $reflection = new ReflectionClass($instance);

        $classAnnotation = $this->annotationReader
            ->getClassAnnotation($reflection, 'ZendExt\ServiceManager\Annotation\Service');

        if ($classAnnotation === null) {
            return;
        }

        $reflectionProperties = $reflection->getProperties();
        $reflectionMethods = $reflection->getMethods();

        foreach ($reflectionProperties as $property) {
            $this->processPropertyInjection($property, $instance, $serviceLocator);
        }

        foreach ($reflectionMethods as $method) {
            $this->processMethodInjection($method, $instance, $serviceLocator);
        }
    }

    abstract protected function processPropertyInjection(ReflectionProperty $property, $instance, ServiceLocatorInterface $serviceLocator);

    abstract protected function processMethodInjection(ReflectionMethod $method, $instance, ServiceLocatorInterface $serviceLocator);
}