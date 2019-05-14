<?php

namespace Chetkov\Logger;

use Chetkov\Logger\Implementation\File\FileLogger;
use Chetkov\Logger\Implementation\LoggerImplementation;
use Chetkov\Logger\Implementation\Mongo\MongoLogger;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

/**
 * Class LoggerService
 * @package Chetkov\Logger
 */
class LoggerService implements LoggerInterface
{
    public const IMPLEMENTATION_FILE = FileLogger::class;
    public const IMPLEMENTATION_MONGO = MongoLogger::class;

    public const DEFAULT_DATE_FORMAT_FOR_GROUPING = 'Y-m';

    /**
     * @var LoggerImplementation
     */
    private $loggerImplementation;

    /**
     * LoggerService constructor.
     * @param LoggerImplementation $loggerImplementation
     */
    public function __construct(LoggerImplementation $loggerImplementation)
    {
        $this->loggerImplementation = $loggerImplementation;
    }

    /**
     * System is unusable.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function emergency($message, array $context = []): void
    {
        $this->loggerImplementation->log($message, LogLevel::EMERGENCY, $context);
    }

    /**
     * Action must be taken immediately.
     *
     * Example: Entire website down, database unavailable, etc. This should
     * trigger the SMS alerts and wake you up.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function alert($message, array $context = []): void
    {
        $this->loggerImplementation->log($message, LogLevel::ALERT, $context);
    }

    /**
     * Critical conditions.
     *
     * Example: Application component unavailable, unexpected exception.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function critical($message, array $context = []): void
    {
        $this->loggerImplementation->log($message, LogLevel::CRITICAL, $context);
    }

    /**
     * Runtime errors that do not require immediate action but should typically
     * be logged and monitored.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function error($message, array $context = []): void
    {
        $this->loggerImplementation->log($message, LogLevel::ERROR, $context);
    }

    /**
     * Exceptional occurrences that are not errors.
     *
     * Example: Use of deprecated APIs, poor use of an API, undesirable things
     * that are not necessarily wrong.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function warning($message, array $context = []): void
    {
        $this->loggerImplementation->log($message, LogLevel::WARNING, $context);
    }

    /**
     * Normal but significant events.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function notice($message, array $context = []): void
    {
        $this->loggerImplementation->log($message, LogLevel::NOTICE, $context);
    }

    /**
     * Interesting events.
     *
     * Example: User logs in, SQL logs.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function info($message, array $context = []): void
    {
        $this->loggerImplementation->log($message, LogLevel::INFO, $context);
    }

    /**
     * Detailed debug information.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function debug($message, array $context = []): void
    {
        $this->loggerImplementation->log($message, LogLevel::DEBUG, $context);
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed $level
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function log($level, $message, array $context = []): void
    {
        $this->loggerImplementation->log($message, $level, $context);
    }
}
