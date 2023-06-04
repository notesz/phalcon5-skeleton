<?php

namespace Skeleton\Modules\Cli\Tasks;

/**
 * Test task.
 *
 * @copyright Copyright (c) 2023 innobotics (https://innobotics.eu)
 * @author Norbert Lakatos <norbert@innobotics.eu>
 */
class TestTask extends \Phalcon\Cli\Task
{
    public function mainAction()
    {
        echo 'Use: ./cli [OPTIONS][FUNCTION][PARAMETERS]' . PHP_EOL;
        echo '' . PHP_EOL;
        echo 'Options:' . PHP_EOL;
        echo ' --test progress 1000     show version information' . PHP_EOL;
        echo ' --test random 16         show a random string' . PHP_EOL;
        echo ' --test uuid              show a random uuid' . PHP_EOL;
    }

    public function progressAction($count)
    {
        $bar = new \Dariuszp\CliProgressBar($count);
        $bar->display();

        for ($i = 0; $i < $count+1; $i++) {
            $bar->progress();
            usleep(1000);
        }

        $bar->end();
    }

    public function randomAction(int $length = 16)
    {
        echo $this->di->get('helper')->getRandomString($length);
    }

    public function uuidAction()
    {
        echo $this->di->get('helper')->getuuid();
    }
}
