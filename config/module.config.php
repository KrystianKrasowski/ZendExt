<?php

return [
    'service_manager' => [
        'initializers' => [
            'ZendExt\ServiceManager\ServiceInjectionInitializer',
            'ZendExt\ServiceManager\ConfigInjectionInitializer',
            'ZendExt\ServiceManager\ServiceManagerInjectionInitializer',
        ],
    ],
];