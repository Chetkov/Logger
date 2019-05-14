<?php

namespace Chetkov\Logger;

use MongoDB\Client;
use Chetkov\Logger\Implementation\File\FileLogger;
use Chetkov\Logger\Implementation\LoggerImplementation;
use Chetkov\Logger\Implementation\Mongo\MongoLogger;
use Chetkov\Logger\Validation\ConfigValidator;

/**
 * Class LoggerServiceFactory
 * @package Chetkov\Logger
 */
class LoggerServiceFactory
{
    /**
     * @var LoggerServiceFactory
     */
    private static $instance;

    /**
     * @var ConfigValidator
     */
    private $configValidator;

    /**
     * LoggerServiceFactory constructor.
     */
    private function __construct()
    {
        $this->configValidator = new ConfigValidator();
    }

    /**
     * @return LoggerServiceFactory
     */
    public static function getInstance(): self
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * @param string $name
     * @param string $implementation
     * @param array $config
     * @return LoggerService
     * @throws LoggerServiceException
     */
    public function build(string $name, string $implementation = LoggerService::IMPLEMENTATION_MONGO, array $config = []): LoggerService
    {
        $config = $config ?: $this->loadDefaultConfig($implementation);
        $loggerImplementation = $this->buildLoggerImplementation($name, $implementation, $config);
        return new LoggerService($loggerImplementation);
    }

    /**
     * @param string $implementation
     * @return array
     * @throws LoggerServiceException
     */
    private function loadDefaultConfig(string $implementation): array
    {
        $implementationNameParts = explode('\\', $implementation);
        $implementationName = array_pop($implementationNameParts);

        $configFile = LOGGER_ROOT . "/config/{$implementationName}Config.php";
        if (!file_exists($configFile)) {
            throw new LoggerServiceException("Не определен конфиг для $implementationName");
        }

        return require $configFile;
    }

    /**
     * @param string $name
     * @param string $implementation
     * @param array $config
     * @return LoggerImplementation
     * @throws LoggerServiceException
     */
    private function buildLoggerImplementation(string $name, string $implementation, array $config): LoggerImplementation
    {
        $dateFormatForGrouping = $config['date_format_for_grouping'] ?? LoggerService::DEFAULT_DATE_FORMAT_FOR_GROUPING;

        switch ($implementation) {
            case LoggerService::IMPLEMENTATION_FILE:
                if (!$this->configValidator->validateFileLoggerConfig($config)) {
                    $message = implode(PHP_EOL, $this->configValidator->getErrors());
                    throw new LoggerServiceException($message);
                }

                $loggerImplementation = new FileLogger($config['path'], $name, $dateFormatForGrouping);
                break;
            case LoggerService::IMPLEMENTATION_MONGO:
                if (!$this->configValidator->validateMongoLoggerConfig($config)) {
                    $message = implode(PHP_EOL, $this->configValidator->getErrors());
                    throw new LoggerServiceException($message);
                }

                $mongoClient = new Client(
                    $config['uri'],
                    $config['uri_options'] ?? [],
                    $config['driver_options'] ?? []
                );
                $loggerImplementation = new MongoLogger($mongoClient, $config['database'], $name, $dateFormatForGrouping);
                break;
            default:
                throw new LoggerServiceException('Попытка инстанциировать несуществующую реализацию логера');
        }

        return $loggerImplementation;
    }
}
