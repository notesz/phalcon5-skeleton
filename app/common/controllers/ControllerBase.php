<?php

namespace Skeleton\Common\Controllers;

/**
 * Base controller.
 *
 * @copyright Copyright (c) 2023 innobotics (https://innobotics.eu)
 * @author Norbert Lakatos <norbert@innobotics.eu>
 */
class ControllerBase extends \Phalcon\Mvc\Controller
{
    protected $keycloakUser;

    /**
     * Initialize.
     */
    public function initialize()
    {
        $this->setKeycloak();
    }

    /**
     * Forward to error 404
     *
     * @return bool
     */
    public function forward404()
    {
        $this->dispatcher->forward([
            'controller' => 'error',
            'action'     => 'error404'
        ]);

        return false;
    }

    public function setKeycloak()
    {
        $this->keycloakUser = [];
        if ($this->di->get('config')->keycloak->enable === true) {
            $this->keycloakUser = $this->di->get('keycloak')->getUserDetails();
        }
        $this->view->setVar('keycloakUser', $this->keycloakUser);
    }

    /**
     * @param \Phalcon\Mvc\Dispatcher $dispatcher
     */
    public function afterExecuteRoute(\Phalcon\Mvc\Dispatcher $dispatcher)
    {
    }
}
