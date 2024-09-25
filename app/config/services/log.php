<?php

/**
 * Setting up logger
 */
$di->setShared('log', function () {
    $log = new \Skeleton\Library\Log();

    return $log;
});
