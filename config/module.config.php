<?php

return [
    'service_manager' => [
        'invokables' => [
            'ZendExt\AnnotationBuilder' => 'ZendExt\Form\Annotation\AnnotationBuilder',
            'ZendExt\FlashMessenger' => 'ZendExt\Plugin\FlashMessenger',
            'ZendExt\Redirector' => 'ZendExt\Plugin\Redirector',
            'ZendExt\FormMessenger' => 'ZendExt\Plugin\FormMessenger',
        ],
        'initializers' => [
            'ZendExt\ServiceManager\ServiceInjectionInitializer',
            'ZendExt\ServiceManager\ConfigInjectionInitializer',
        ],
    ],

    'filters' => [
        'invokables' => [
            'ZendExt\BcryptPassword' => 'ZendExt\Filter\BcryptPassword',
        ],
        'aliases' => [
            'BcryptPassword' => 'ZendExt\BcryptPassword',
        ],
    ],
];