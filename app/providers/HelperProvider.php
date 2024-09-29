<?php

namespace Skeleton\Providers;

use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;

/**
 * Register helper
 */
class HelperProvider implements ServiceProviderInterface
{
    /**
     * @var string
     */
    protected $providerName = 'helper';

    /**
     * @param DiInterface $di
     *
     * @return void
     */
    public function register(DiInterface $di): void
    {
        $di->setShared($this->providerName, function () {
            $helper = new \Skeleton\Library\Helper();

            return $helper;
        });
    }
}
