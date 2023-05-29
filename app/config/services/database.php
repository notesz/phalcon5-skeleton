<?php

/**
 * Setting up master and slave database connection
 */
$di->setShared('dbMaster', function () {
    $config = $this->getConfig();

    $class = 'Phalcon\Db\Adapter\Pdo\\' . $config->database->adapter;
    $connection = new $class([
        'host'     => $config->database->master->host,
        'username' => $config->database->master->username,
        'password' => $config->database->master->password,
        'dbname'   => $config->database->master->dbname,
        'charset'  => $config->database->master->charset
    ]);

    return $connection;
});
$di->setShared('dbSlave', function () {
    $config = $this->getConfig();

    $class = 'Phalcon\Db\Adapter\Pdo\\' . $config->database->adapter;
    $connection = new $class([
        'host'     => $config->database->slave->host,
        'username' => $config->database->slave->username,
        'password' => $config->database->slave->password,
        'dbname'   => $config->database->slave->dbname,
        'charset'  => $config->database->slave->charset
    ]);

    return $connection;
});
