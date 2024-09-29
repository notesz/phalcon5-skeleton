<?php

namespace Skeleton\Providers;

use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;
use Skeleton\Library\Queue;

/**
 * Register queue
 */
class QueueProvider implements ServiceProviderInterface
{
    /**
     * @var string
     */
    protected $providerName = 'queue';

    /**
     * @param DiInterface $di
     *
     * @return void
     */
    public function register(DiInterface $di): void
    {
        $di->setShared($this->providerName, function () {
            return new Queue();
        });
    }
}
