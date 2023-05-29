<?php

/**
 * Register the session flash service with Bootstrap classes
 */
$di->set('flash', function () {

    $flash = new Phalcon\Flash\Session();

    $flash->setCssClasses([
        'error'   => 'error_message callout alert radius flashSession',
        'success' => 'success_message callout success radius flashSession',
        'warning' => 'warning_message callout warning radius flashSession',
        'notice'  => 'notice_message callout secondary radius flashSession'
    ]);

    $flash->setCssIconClasses([
        'error'   => 'fi-alert',
        'success' => 'fi-check',
        'notice'  => 'fi-star',
        'warning' => 'fi-flag',
    ]);

    $flash->setCustomTemplate('
        <div class="%cssClass%">
            <i class="%cssIconClass%"></i> %message%
            <button class="close-button" aria-label="Close" type="button" data-close>
                <span aria-hidden="true">&times;</span>
            </button>
        </div>'
    );

    $flash->setAutoescape(false);

    return $flash;
});
