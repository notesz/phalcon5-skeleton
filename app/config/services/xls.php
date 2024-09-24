<?php

/**
 * Setting up XLS
 */
$di->setShared('xls', function () {
    $xls = new \Skeleton\Library\Xls();

    return $xls;
});
