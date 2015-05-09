<?php

namespace ZendExt\ServiceManager;

use Doctrine\Common\Annotations\AnnotationReader;
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
    }

    public function initialize($instance, ServiceLocatorInterface $serviceLocator)
    {
        if (!is_object($instance)) {
            return;
        }

        $this->serviceLocator = $serviceLocator;
        $this->instance = $instance;

        $reflection = new ReflectionClass($instance);

        $classAnnotation = $this->annotationReader
            ->getClassAnnotation($reflection, 'ZendExt\ServiceManager\Annotation\Service');

        if ($classAnnotation === null) {
            return;
        }

        array_walk($reflection->getProperties(), array($this, 'processPropertyInjection'));
        array_walk($reflection->getMethods(), array($this, 'processMethodInjection'));
    }

    abstract protected function processPropertyInjection(ReflectionProperty $property);

    abstract protected function processMethodInjection(ReflectionMethod $method);
}