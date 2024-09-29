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
        return $this->getDI()->getKeycloak()->login();
    }

    public function callbackAction()
    {
        if ($this->getDI()->getKeycloak()->loginCallback() == true) {
            $this->getDI()->getFlash()->success('Success');
        } else {
            $this->getDI()->getFlash()->error('Error');
        }

        return $this->response->redirect('/');
    }

    public function logoutAction()
    {
        return $this->getDI()->getKeycloak()->logout();
    }
}
