<?php

// cache
$router->add('/test/cache', [
    'namespace'  => 'Skeleton\Modules\Test\Controllers',
    'module'     => 'test',
    'controller' => 'cache',
    'action'     => 'cache'
])->setName('test-cache-cache');
