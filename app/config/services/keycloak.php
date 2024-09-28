<?php

/**
 * Setting up keycloak
 */
$di->setShared('keycloak', function () {
    $keycloak = new \Skeleton\Library\Keycloak();

    return $keycloak;
});
