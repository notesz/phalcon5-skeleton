<?php

// index
$router->add('/', [
    'namespace'  => 'Skeleton\Modules\Frontend\Controllers',
    'module'     => 'frontend',
    'controller' => 'index',
    'action'     => 'index'
])->setName('frontend-index');

if ($this->getConfig()->keycloak->enable === true) {
    require_once __DIR__ . '/routes_keycloak.php';
}
