<?php

$router->add('/user/login', [
    'namespace'  => 'Skeleton\Modules\Frontend\Controllers',
    'module'     => 'frontend',
    'controller' => 'keycloak',
    'action'     => 'login'
])->setName('frontend-keycloak-login');

$router->add('/user/logout', [
    'namespace'  => 'Skeleton\Modules\Frontend\Controllers',
    'module'     => 'frontend',
    'controller' => 'keycloak',
    'action'     => 'logout'
])->setName('frontend-keycloak-logout');

$router->add('/user/login/kc-callback', [
    'namespace'  => 'Skeleton\Modules\Frontend\Controllers',
    'module'     => 'frontend',
    'controller' => 'keycloak',
    'action'     => 'callback'
])->setName('frontend-keycloak-callback');
