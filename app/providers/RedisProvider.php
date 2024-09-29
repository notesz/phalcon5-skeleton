<?php

namespace Skeleton\Providers;

use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;
use Phalcon\Storage\SerializerFactory;
use Phalcon\Cache\Adapter\Redis;

/**
 * Register redis
 */
class RedisProvider implements ServiceProviderInterface
{
    /**
     * @var string
     */
    protected $providerName = 'redis';

    /**
     * @param DiInterface $di
     *
     * @return void
     */
    public function register(DiInterface $di): void
    {
        $di->setShared($this->providerName, function () {
            $config = $this->getConfig();

            $serializerFactory = new SerializerFactory();

            $redis = new Redis($serializerFactory, [
                'lifetime'   => $config->redis->lifetime,
                'host'       => $config->redis->host,
                'port'       => $config->redis->port,
                'persistent' => false,
                'index'      => 1,
            ]);

            return $redis;
        });
    }
}
