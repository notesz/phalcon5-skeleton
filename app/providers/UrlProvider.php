<?php

namespace Skeleton\Providers;

use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;
use Phalcon\Mvc\Url;

/**
 * Register url
 */
class UrlProvider implements ServiceProviderInterface
{
    /**
     * @var string
     */
    protected $providerName = 'url';

    /**
     * @param DiInterface $di
     *
     * @return void
     */
    public function register(DiInterface $di): void
    {
        $di->setShared($this->providerName, function () {
            $config = $this->getConfig();

            $url = new Url();
            $url->setBaseUri($config->application->baseUri);

            return $url;
        });
    }
}
