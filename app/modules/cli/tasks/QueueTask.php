<?php

namespace Skeleton\Modules\Cli\Tasks;

/**
 * Queue task.
 *
 * @copyright Copyright (c) 2023 innobotics (https://innobotics.eu)
 * @author Norbert Lakatos <norbert@innobotics.eu>
 */
class QueueTask extends \Phalcon\Cli\Task
{
    public function mainAction()
    {
        echo '[START]' . PHP_EOL;

        foreach ($this->getDI()->getQueue()->getItems() as $item) {
            echo '[PROCESS] ' . $item['id'] . ' ' . $this->getDI()->getQueue()->process($item['id']) . PHP_EOL;
        }

        echo '[DONE]' . PHP_EOL;
    }
}
