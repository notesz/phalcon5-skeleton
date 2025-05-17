<?php

use Skeleton\Providers\ConfigProvider;
use Skeleton\Providers\DatabaseProvider;
use Skeleton\Providers\DatabaseSlaveProvider;
use Skeleton\Providers\RedisProvider;
use Skeleton\Providers\CookiesProvider;
use Skeleton\Providers\RouterProvider;
use Skeleton\Providers\HelperProvider;
use Skeleton\Providers\LogProvider;
use Skeleton\Providers\QueueProvider;
use Skeleton\Providers\ImageProvider;
use Skeleton\Providers\PaginationProvider;
use Skeleton\Providers\FileStorageProvider;
use Skeleton\Providers\XlsProvider;
use Skeleton\Providers\UrlProvider;
use Skeleton\Providers\SessionProvider;
use Skeleton\Providers\FlashProvider;
use Skeleton\Providers\KeycloakProvider;

return [
    'cli' => [
        ConfigProvider::class,
        DatabaseProvider::class,
        DatabaseSlaveProvider::class,
        RedisProvider::class,
        HelperProvider::class,
        LogProvider::class,
        QueueProvider::class,
        ImageProvider::class,
        FileStorageProvider::class,
        XlsProvider::class,
        KeycloakProvider::class
    ],
    'web' => [
        ConfigProvider::class,
        DatabaseProvider::class,
        DatabaseSlaveProvider::class,
        RedisProvider::class,
        CookiesProvider::class,
        RouterProvider::class,
        HelperProvider::class,
        LogProvider::class,
        QueueProvider::class,
        ImageProvider::class,
        PaginationProvider::class,
        FileStorageProvider::class,
        XlsProvider::class,
        UrlProvider::class,
        SessionProvider::class,
        FlashProvider::class,
        KeycloakProvider::class
    ]
];
