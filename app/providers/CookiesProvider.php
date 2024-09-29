<?php

namespace Skeleton\Providers;

use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;
use Phalcon\Http\Response\Cookies;

/**
 * Register Cookies
 */
class CookiesProvider implements ServiceProviderInterface
{
    /**
     * @var string
     */
    protected $providerName = 'cookies';

    /**
     * @param DiInterface $di
     *
     * @return void
     */
    public function register(DiInterface $di): void
    {
        $di->set($this->providerName, function() {
            $cookies = new Cookies();

            $cookies->useEncryption(false);

            return $cookies;
        });
    }
}
