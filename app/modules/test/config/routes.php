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

// image
include __DIR__ . '/routes_image.php';

// filestorage
include __DIR__ . '/routes_filestorage.php';

// phpinfo
$router->add('/test/phpinfo', [
    'namespace'  => 'Skeleton\Modules\Test\Controllers',
    'module'     => 'test',
    'controller' => 'phpinfo',
    'action'     => 'phpinfo'
])->setName('test-phpinfo-phpinfo');

// xls
include __DIR__ . '/routes_xls.php';
