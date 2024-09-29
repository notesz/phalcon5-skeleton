<?php

namespace Skeleton\Providers;

use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;
use Skeleton\Library\Xls;

/**
 * Register xls
 */
class XlsProvider implements ServiceProviderInterface
{
    /**
     * @var string
     */
    protected $providerName = 'xls';

    /**
     * @param DiInterface $di
     *
     * @return void
     */
    public function register(DiInterface $di): void
    {
        $di->setShared($this->providerName, function () {
            return new Xls();
        });
    }
}
