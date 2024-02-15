<?php

declare(strict_types=1);

return [
    'generator' => [
        'amqp'       => [
            'consumer' => [
                'namespace' => 'Application\\Amqp\\Consumer',
            ],
            'producer' => [
                'namespace' => 'Application\\Amqp\\Producer',
            ],
        ],
        'aspect'     => [
            'namespace' => 'Application\\Aspect',
        ],
        'command'    => [
            'namespace' => 'Application\\Command',
        ],
        'controller' => [
            'namespace' => 'Application\\Http\\Controller',
        ],
        'job'        => [
            'namespace' => 'Application\\Job',
        ],
        'listener'   => [
            'namespace' => 'Application\\Listener',
        ],
        'middleware' => [
            'namespace' => 'Application\\Http\\Middleware',
        ],
        'Process'    => [
            'namespace' => 'Application\\Processes',
        ],
    ],
];
