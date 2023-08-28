<?php

if (!isset($dotenv)) {
    $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__ . '/../../..'));
    $dotenv->load();
}

defined('ENVIRONMENT') || define('ENVIRONMENT', $_ENV['ENVIRONMENT'] ?: 'prod');

defined('BASE_PATH') || define('BASE_PATH', realpath(dirname(__FILE__) . '/../..'));
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
        'host'     => $_ENV['DATABASE_MASTER_HOST'],
        'username' => $_ENV['DATABASE_MASTER_USER'],
        'password' => $_ENV['DATABASE_MASTER_PASS'],
        'dbname'   => $_ENV['DATABASE_MASTER_NAME'],
        'charset'  => 'utf8'
    ],

    'database_slave' => [
        'adapter'  => 'mysql',
        'host'     => $_ENV['DATABASE_SLAVE_HOST'],
        'username' => $_ENV['DATABASE_SLAVE_USER'],
        'password' => $_ENV['DATABASE_SLAVE_PASS'],
        'dbname'   => $_ENV['DATABASE_SLAVE_NAME'],
        'charset'  => 'utf8'
    ],

    'application' => [
        'modules'             => \explode(',', $_ENV['MODULES']),
        'appDir'              => APP_PATH . '/',
        'viewsDir'            => [
            'layout' => APP_PATH . '/common/views/',
        ],
        'modelsDir'           => APP_PATH . '/common/models/',
        'controllersDir'      => APP_PATH . '/common/controllers/',
        'cacheDir'            => BASE_PATH . '/cache/',
        'baseUri'             => '/',

        'migrationsDir'       => BASE_PATH . '/db/migrations/',
        'logInDb'             => true,
        'no-auto-increment'   => true,
        'skip-ref-schema'     => true,
        'skip-foreign-checks' => true,
        'migrationsTsBased'   => true
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

    'mailer' => [
        'XMailer'           => $_ENV['PROJECT'] . ' (' . $_ENV['ENVIRONMENT'] . ')',
        'senderName'        => $_ENV['MAIL_SENDER_NAME'],
        'senderEmail'       => $_ENV['MAIL_SENDER_EMAIL'],
        'smtpHost'          => $_ENV['MAIL_SMTP_HOST'],
        'smtpPort'          => $_ENV['MAIL_SMTP_PORT'],
        'smtpSecure'        => $_ENV['MAIL_SMTP_SECURE'],
        'smtpUsername'      => $_ENV['MAIL_SMTP_USER'],
        'smtpPassword'      => $_ENV['MAIL_SMTP_PASSWORD']
    ],
]);
