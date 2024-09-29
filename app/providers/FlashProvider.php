<?php

namespace Skeleton\Providers;

use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;
use Phalcon\Flash\Session;

/**
 * Register flash
 */
class FlashProvider implements ServiceProviderInterface
{
    /**
     * @var string
     */
    protected $providerName = 'flash';

    /**
     * @param DiInterface $di
     *
     * @return void
     */
    public function register(DiInterface $di): void
    {
        $di->set($this->providerName, function () {

            $flash = new Session();

            $flash->setCssClasses([
                'error'   => 'alert alert-danger',
                'success' => 'alert alert-success',
                'warning' => 'alert alert-info',
                'notice'  => 'alert alert-info'
            ]);

            $flash->setCustomTemplate('
                <div class="%cssClass%">
                    %message%
                </div>'
            );

            $flash->setAutoescape(false);

            return $flash;
        });
    }
}
