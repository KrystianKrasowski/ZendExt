<?php

namespace ZendExt\Form\Annotation;

use Zend\Filter\FilterChain;
use Zend\InputFilter\Factory;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Validator\ValidatorChain;
use ZendExt\ServiceManager\Annotation\Inject;
use ZendExt\ServiceManager\Annotation\Service;

/**
 * @Service()
 */
class AnnotationBuilder extends \Zend\Form\Annotation\AnnotationBuilder
{
    /**
     * @var ServiceLocatorInterface
     * @Inject(name="ServiceManager")
     */
    private $serviceLocator;

    public function createForm($entity)
    {
        $inputFilterFactory = $this
            ->getFormFactory()
            ->getInputFilterFactory();

        $this->prepareValidatorChain($inputFilterFactory);
        $this->prepareFilterChainFactory($inputFilterFactory);

        return parent::createForm($entity);
    }

    private function prepareValidatorChain(Factory $inputFilterFactory)
    {
        $validatorManager = $this
            ->getServiceLocator()
            ->get('ValidatorManager');

        $validatorChain = new ValidatorChain();
        $validatorChain->setPluginManager($validatorManager);

        $inputFilterFactory->setDefaultValidatorChain($validatorChain);
    }

    private function prepareFilterChainFactory(Factory $inputFilterFactory)
    {
        $filterManager = $this
            ->getServiceLocator()
            ->get('FilterManager');

        $filterChain = new FilterChain();
        $filterChain->setPluginManager($filterManager);

        $inputFilterFactory->setDefaultFilterChain($filterChain);
    }

    private function getServiceLocator()
    {
        return $this->serviceLocator;
    }
}