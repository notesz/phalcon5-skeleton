<?php

namespace Skeleton\Providers;

use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;
use Phalcon\Session\Manager;
use Phalcon\Storage\SerializerFactory;
use Phalcon\Storage\AdapterFactory;
use Phalcon\Session\Adapter\Redis;

/**
 * Register session
 */
class SessionProvider implements ServiceProviderInterface
{
    /**
     * @var string
     */
    protected $providerName = 'session';

    /**
     * @param DiInterface $di
     *
     * @return void
     */
    public function register(DiInterface $di): void
    {
        $di->setShared($this->providerName, function () {
            $config = $this->getConfig();

            $options = [
                'host'       => $config->redis->host,
                'port'       => $config->redis->port,
                'persistent' => false,
                'lifetime'   => $config->session->expire
            ];

            $session           = new Manager();
            $serializerFactory = new SerializerFactory();
            $factory           = new AdapterFactory($serializerFactory);
            $redis             = new Redis($factory, $options);

            $session
                ->setAdapter($redis)
                ->start();

            return $session;
        });
    }
}
