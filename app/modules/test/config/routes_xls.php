<?php

$router->add('/test/xls', [
    'namespace'  => 'Skeleton\Modules\Test\Controllers',
    'module'     => 'test',
    'controller' => 'xls',
    'action'     => 'index'
])->setName('test-xls-index');

$router->add('/test/xls/generate', [
    'namespace'  => 'Skeleton\Modules\Test\Controllers',
    'module'     => 'test',
    'controller' => 'xls',
    'action'     => 'generate'
])->setName('test-xls-generate');
