<?php

namespace Skeleton\Modules\Test\Controllers;

/**
 * Log controller.
 *
 * @copyright Copyright (c) 2023 innobotics (https://innobotics.eu)
 * @author Norbert Lakatos <norbert@innobotics.eu>
 */
class LogController extends \Skeleton\Modules\Test\Controllers\ControllerBase
{
    public function initialize()
    {
        parent::initialize();
    }

    public function logAction()
    {
        $this->getDI()->getLog()->debug('Ouch... It is a debug.');
        $this->getDI()->getLog()->info('Ouch... It is an info.');
        $this->getDI()->getLog()->notice('Ouch... It is a notice.');
        $this->getDI()->getLog()->warning('Ouch... It is an warning.');
        $this->getDI()->getLog()->error('Ouch... It is an error.');
        $this->getDI()->getLog()->critical('Ouch... It is a critical.');
        $this->getDI()->getLog()->alert('Ouch... It is an alert.');
        $this->getDI()->getLog()->emergency('Ouch... It is an emergency.');
    }
}
