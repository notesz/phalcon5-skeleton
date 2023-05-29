<?php

namespace Skeleton\Modules\Frontend;

use Phalcon\Di\DiInterface;
use Phalcon\Autoload\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Php as PhpEngine;
use Phalcon\Mvc\ModuleDefinitionInterface;

/**
 * Frontend module.
 *
 * @copyright Copyright (c) 2023 innobotics (https://innobotics.eu)
 * @author Norbert Lakatos <norbert@innobotics.eu>
 */
class Module implements ModuleDefinitionInterface
{
    /**
     * Registers an autoloader related to the module
     *
     * @param DiInterface $di
     */
    public function registerAutoloaders(DiInterface $di = null) {
        $loader = new Loader();

        $loader->setNamespaces([
            'Skeleton\Modules\Frontend\Controllers' => __DIR__ . '/controllers/',
            'Skeleton\Modules\Frontend\Models'      => __DIR__ . '/models/',
            'Skeleton\Common\Models'                => __DIR__ . '/../../common/models/',
            'Skeleton\Common\Controllers'           => __DIR__ . '/../../common/controllers/'
        ]);

        $loader->register();
    }

    /**
     * Registers services related to the module
     *
     * @param DiInterface $di
     */
    public function registerServices(DiInterface $di)
    {
        /**
         * Setting up the view component
         */
        $di->set('view', function () {
            $view = new View();
            $view->setViewsDir(__DIR__ . '/views/');
            $view->registerEngines([
                '.phtml' => PhpEngine::class
            ]);

            return $view;
        });
    }
}
