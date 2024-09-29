<?php

namespace Skeleton\Providers;

use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;
use Skeleton\Library\Pagination;

/**
 * Register pagination
 */
class PaginationProvider implements ServiceProviderInterface
{
    /**
     * @var string
     */
    protected $providerName = 'pagination';

    /**
     * @param DiInterface $di
     *
     * @return void
     */
    public function register(DiInterface $di): void
    {
        $di->setShared($this->providerName, function () {
            return new Pagination();
        });
    }
}
