<?php

namespace Skeleton\Providers;

use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;
use Skeleton\Library\Log;

/**
 * Register log
 */
class LogProvider implements ServiceProviderInterface
{
    /**
     * @var string
     */
    protected $providerName = 'log';

    /**
     * @param DiInterface $di
     *
     * @return void
     */
    public function register(DiInterface $di): void
    {
        $di->setShared($this->providerName, function () {
            return new Log();
        });
    }
}
