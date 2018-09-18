<?php

namespace Chetkov\Logger;

use Chetkov\Logger\Implementation\File\FileLogger;
use Chetkov\Logger\Implementation\LoggerImplementation;
use Chetkov\Logger\Implementation\Mongo\MongoLogger;

/**
 * Class LoggerService
 * @package Chetkov\Logger
 */
class LoggerService implements Logger
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
     * @param string $message
     * @param array $data
     */
    public function debug(string $message, array $data = []): void
    {
        $this->loggerImplementation->log($message, self::LEVEL_DEBUG, $data);
    }

    /**
     * @param string $message
     * @param array $data
     */
    public function info(string $message, array $data = []): void
    {
        $this->loggerImplementation->log($message, self::LEVEL_INFO, $data);
    }

    /**
     * @param string $message
     * @param array $data
     */
    public function warning(string $message, array $data = []): void
    {
        $this->loggerImplementation->log($message, self::LEVEL_WARNING, $data);
    }

    /**
     * @param string $message
     * @param array $data
     */
    public function error(string $message, array $data = []): void
    {
        $this->loggerImplementation->log($message, self::LEVEL_ERROR, $data);
    }

    /**
     * @param string $message
     * @param array $data
     */
    public function critical(string $message, array $data = []): void
    {
        $this->loggerImplementation->log($message, self::LEVEL_CRITICAL, $data);
    }
}
