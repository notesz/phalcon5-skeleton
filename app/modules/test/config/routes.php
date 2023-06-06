<?php

// cache
$router->add('/test/cache', [
    'namespace'  => 'Skeleton\Modules\Test\Controllers',
    'module'     => 'test',
    'controller' => 'cache',
    'action'     => 'cache'
])->setName('test-cache-cache');

// log
$router->add('/test/log', [
    'namespace'  => 'Skeleton\Modules\Test\Controllers',
    'module'     => 'test',
    'controller' => 'log',
    'action'     => 'log'
])->setName('test-log-log');
