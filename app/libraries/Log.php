<?php

namespace Skeleton\Library;

use Phalcon\Logger\Formatter\Line;
use Phalcon\Logger\Formatter\Json;
use Phalcon\Logger\Logger;
use Phalcon\Logger\Adapter\Stream;
use Phalcon\Logger\Exception;

/**
 * Log.
 *
 * @copyright Copyright (c) 2023 innobotics (https://innobotics.eu)
 * @author Norbert Lakatos <norbert@innobotics.eu>
 */
class Log
{
    protected $config;

    protected $logger;

    protected $logFilePath;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->config = \Phalcon\Di\Di::getDefault()->get('config');

        if (!is_dir($this->config->log->dir . \date('Y') . '/')) {
            mkdir($this->config->log->dir . \date('Y') . '/');
        }

        $this->logFilePath = $this->config->log->dir . \date('Y') . '/' . $this->config->project . '.' . \date('Ymd') . '.log';

        switch ($this->config->log->format) {
            case 'json':
                $formatter = new Json();
                $formatter->setDateFormat($this->config->log->format_date);
                break;
            case 'line':
            default:
                $formatter = new Line();
                $formatter->setFormat($this->config->log->format_line);
                $formatter->setDateFormat($this->config->log->format_date);
        }

        $adapter = new Stream($this->logFilePath);
        $adapter->setFormatter($formatter);

        $this->logger  = new Logger(
            'messages', [
                'main' => $adapter
            ]
        );
    }

    /**
     * Debugging information that reveals the details of the event in detail.
     *
     * @param $string
     * @return void
     * @throws Exception
     */
    public function debug($string = '')
    {
        $this->logger->debug($string);
    }

    /**
     * Any interesting events. For instance: user has signed in.
     *
     * @param $string
     * @return void
     * @throws Exception
     */
    public function info($string = '')
    {
        $this->logger->info($string);
    }

    /**
     * Important events within the expected behavior.
     *
     * @param $string
     * @return void
     * @throws Exception
     */
    public function notice($string = '')
    {
        $this->logger->notice($string);
    }

    /**
     * Exceptional cases which are still not errors.
     * For example usage of a deprecated method or wrong API request
     *
     * @param $string
     * @return void
     * @throws Exception
     */
    public function warning($string = '')
    {
        $this->logger->warning($string);
    }

    /**
     * Errors to be monitored, but which don't require an urgent fixing.
     *
     * @param $string
     * @return void
     * @throws Exception
     */
    public function error($string = '')
    {
        $this->logger->error($string);
    }

    /**
     * Critical state or an event. For instance: unavailability of a component or an unhandled exception.
     *
     * @param $string
     * @return void
     * @throws Exception
     */
    public function critical($string = '')
    {
        $this->logger->critical($string);
    }

    /**
     * Error and an event to be solved in the shortest time. For example, the database is unavailable.
     *
     * @param $string
     * @return void
     * @throws Exception
     */
    public function alert($string = '')
    {
        $this->logger->alert($string);
    }

    /**
     * Whole app/system is completely out of order.
     *
     * @param $string
     * @return void
     * @throws Exception
     */
    public function emergency($string = '')
    {
        $this->logger->emergency($string);
    }
}
