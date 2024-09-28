<?php

namespace Skeleton\Modules\Frontend\Controllers;

/**
 * Keycloak controller.
 *
 * @copyright Copyright (c) 2024 innobotics (https://innobotics.eu)
 * @author Norbert Lakatos <norbert@innobotics.eu>
 */
class KeycloakController extends \Skeleton\Common\Controllers\ControllerBase
{
    public function initialize()
    {
        parent::initialize();
    }

    public function loginAction()
    {
        return $this->di->get('keycloak')->login();
    }

    public function callbackAction()
    {
        if ($this->di->get('keycloak')->loginCallback() == true) {
            $this->flash->success('Success');
        } else {
            $this->flash->error('Error');
        }

        return $this->response->redirect('/');
    }

    public function logoutAction()
    {
        return $this->di->get('keycloak')->logout();
    }
}
