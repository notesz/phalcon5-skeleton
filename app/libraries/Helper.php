<?php

namespace Skeleton\Library;

/**
 * Helper.
 *
 * @copyright Copyright (c) 2023 innobotics (https://innobotics.eu)
 * @author Norbert Lakatos <norbert@innobotics.eu>
 */
class Helper
{

    /**
     * Get client ip.
     *
     * @return string
     */
    public static function getClientIp()
    {
        return
            $_ENV['HTTP_CLIENT_IP'] ?:
                $_ENV['HTTP_X_FORWARDED_FOR'] ?:
                    $_ENV['HTTP_X_FORWARDED'] ?:
                        $_ENV['HTTP_FORWARDED_FOR'] ?:
                            $_ENV['HTTP_FORWARDED'] ?:
                                $_ENV['REMOTE_ADDR'];
    }

    /**
     * Debugger
     *
     * @param $content
     *
     * @return void
     */
    public function dump($content)
    {
        echo (new \Phalcon\Debug\Dump())->variable($content);

        die();
    }

}
