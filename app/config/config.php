<?php

defined('ENVIRONMENT') || define('ENVIRONMENT', $_ENV['ENVIRONMENT'] ?: 'prod');

defined('BASE_PATH') || define('BASE_PATH', $_ENV['BASE_PATH'] ?: realpath(dirname(__FILE__) . '/../..'));
defined('APP_PATH') || define('APP_PATH', BASE_PATH . '/app');

$version = file_get_contents(BASE_PATH . '/composer.json');
$version = json_decode($version, true);
$version = !empty($version['version']) ? $version['version'] : '';

$revision = '';

if ($_ENV['ENVIRONMENT'] == 'prod') {
    $revision = \exec('git rev-parse --short HEAD');
} else {
    $revision = '12345';
}


\define('VERSION', $version . (!empty($revision) ? '.' . $revision : ''));

return new \Phalcon\Config\Config([
    'project' => $_ENV['PROJECT'],

    'base_url' => $_ENV['BASE_URL'],

    'version' => $_ENV['PROJECT'] . '.' . VERSION,

    'environment' => $_ENV['ENVIRONMENT'],

    'database' => [
        'adapter'  => 'mysql',
        'master' => [
            'host'     => $_ENV['DATABASE_MASTER_HOST'],
            'username' => $_ENV['DATABASE_MASTER_USER'],
            'password' => $_ENV['DATABASE_MASTER_PASS'],
            'dbname'   => $_ENV['DATABASE_MASTER_NAME'],
            'charset'  => 'utf8'
        ],
        'slave' => [
            'host'     => $_ENV['DATABASE_SLAVE_HOST'],
            'username' => $_ENV['DATABASE_SLAVE_USER'],
            'password' => $_ENV['DATABASE_SLAVE_PASS'],
            'dbname'   => $_ENV['DATABASE_SLAVE_NAME'],
            'charset'  => 'utf8'
        ]
    ],

    'application' => [
        'modules'        => \explode(',', $_ENV['MODULES']),
        'appDir'         => APP_PATH . '/',
        'viewsDir'       => [
            'layout' => APP_PATH . '/common/views/',
        ],
        'modelsDir'      => APP_PATH . '/common/models/',
        'controllersDir' => APP_PATH . '/common/controllers/',
        'migrationsDir'  => APP_PATH . '/migrations/',
        'cacheDir'       => BASE_PATH . '/cache/',
        'baseUri'        => '/'
    ],

    'pagination' => [
        'key'     => 'oldal',
        'perpage' => 48,
        'keyword' => 'kereses'
    ],

    'redis' => [
        'host'      => $_ENV['REDIS_HOST'],
        'port'      => $_ENV['REDIS_PORT'],
        'lifetime'  => $_ENV['REDIS_LIFETIME'],
        'keyPrefix' => '_' . $_ENV['PROJECT']
    ],

    'session' => [
        'expire' => 3600
    ],

    'log' => [
        'dir' => BASE_PATH . '/log/'
    ],
]);
