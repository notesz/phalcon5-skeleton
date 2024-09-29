<?php

namespace Skeleton\Modules\Frontend\Controllers;

/**
 * Index controller.
 *
 * @copyright Copyright (c) 2023 innobotics (https://innobotics.eu)
 * @author Norbert Lakatos <norbert@innobotics.eu>
 */
class IndexController extends \Skeleton\Modules\Frontend\Controllers\ControllerBase
{
    public function initialize()
    {
        parent::initialize();
    }

    /**
     * Index.
     *
     * @return void
     */
    public function indexAction()
    {
    }

    public function testcacheAction()
    {
        $cacheKey = $this->getDI()->getConfig()->redis->keyPrefix . '_teszt';

        $source = 'Cache';

        if ($this->getDI()->getRedis()->get($cacheKey) === null) {

            $source = 'Nem cache';

            sleep(10);

            $content = 'Lorem ipsum...';

            $this->getDI()->getRedis()->set($cacheKey, $content);
        }

        $content = $this->getDI()->getRedis()->get($cacheKey);

        $this->view->setVar('content', $content);
        $this->view->setVar('source', $source);
    }
}
