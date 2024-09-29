<?php

namespace Skeleton\Providers;

use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;
use Skeleton\Library\Image;

/**
 * Register image
 */
class ImageProvider implements ServiceProviderInterface
{
    /**
     * @var string
     */
    protected $providerName = 'image';

    /**
     * @param DiInterface $di
     *
     * @return void
     */
    public function register(DiInterface $di): void
    {
        $di->setShared($this->providerName, function () {
            return new Image();
        });
    }
}
