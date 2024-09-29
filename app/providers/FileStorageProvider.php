<?php

namespace Skeleton\Providers;

use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;
use Skeleton\Library\Filestorage;

/**
 * Register filestorage
 */
class FileStorageProvider implements ServiceProviderInterface
{
    /**
     * @var string
     */
    protected $providerName = 'filestorage';

    /**
     * @param DiInterface $di
     *
     * @return void
     */
    public function register(DiInterface $di): void
    {
        $di->setShared($this->providerName, function () {
            return new Filestorage();
        });
    }
}
