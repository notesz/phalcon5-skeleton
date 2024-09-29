<?php

namespace Skeleton\Providers;

use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;
use Skeleton\Library\Keycloak;

/**
 * Register keycloak
 */
class KeycloakProvider implements ServiceProviderInterface
{
    /**
     * @var string
     */
    protected $providerName = 'keycloak';

    /**
     * @param DiInterface $di
     *
     * @return void
     */
    public function register(DiInterface $di): void
    {
        $di->setShared($this->providerName, function () {
            return new Keycloak();
        });
    }
}
