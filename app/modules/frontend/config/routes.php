<?php

// index
$router->add('/', [
    'namespace'  => 'Skeleton\Modules\Frontend\Controllers',
    'module'     => 'frontend',
    'controller' => 'index',
    'action'     => 'index'
])->setName('frontend-index');

$router->add('/test-cache', [
    'namespace'  => 'Skeleton\Modules\Frontend\Controllers',
    'module'     => 'frontend',
    'controller' => 'index',
    'action'     => 'testcache'
])->setName('frontend-testcache');
