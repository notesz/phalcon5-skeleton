<?php

namespace Skeleton\Providers;

use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;

/**
 * Register database (slave)
 */
class DatabaseSlaveProvider implements ServiceProviderInterface
{
    /**
     * @var string
     */
    protected $providerName = 'database_slave';

    /**
     * @param DiInterface $di
     *
     * @return void
     */
    public function register(DiInterface $di): void
    {
        $di->setShared($this->providerName, function () {
            $config = $this->getConfig();

            $class = 'Phalcon\Db\Adapter\Pdo\\' . $config->database_slave->adapter;
            $connection = new $class([
                'host'     => $config->database_slave->host,
                'username' => $config->database_slave->username,
                'password' => $config->database_slave->password,
                'dbname'   => $config->database_slave->dbname,
                'charset'  => $config->database_slave->charset
            ]);

            return $connection;
        });
    }
}
