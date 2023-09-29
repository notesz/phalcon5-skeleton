<?php

function dump(...$vars) {
    foreach ($vars as $var) {
        echo (new \Phalcon\Support\Debug\Dump())->variable($var);
    }
}

function dd(...$vars) {
    dump(...$vars);
    exit;
}