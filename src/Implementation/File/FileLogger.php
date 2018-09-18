<?php

namespace Chetkov\Logger\Implementation\File;

use Chetkov\Logger\Implementation\LoggerImplementation;
use Chetkov\Logger\LoggerServiceException;

/**
 * Class FileLogger
 * @package Chetkov\Logger\Implementation\File
 */
class FileLogger implements LoggerImplementation
{
    /**
     * @var resource
     */
    private $fileDescriptor;

    /**
     * FileLogger constructor.
     * @param string $path
     * @param string $name
     * @param string $dateFormatForGrouping
     * @throws LoggerServiceException
     */
    public function __construct(string $path, string $name = 'default', string $dateFormatForGrouping = '')
    {
        $this->createDirectoryIfItNotExist($path);
        if ($dateFormatForGrouping) {
            $currentDateTime = new \DateTime();
            $path .= "/{$currentDateTime->format($dateFormatForGrouping)}";
            $this->createDirectoryIfItNotExist($path);
        }

        $fileDescriptor = fopen("$path/$name.log", 'ab');
        if (!$fileDescriptor) {
            throw new LoggerServiceException('Не удлось получить дескриптор файла');
        }

        $this->fileDescriptor = $fileDescriptor;
    }

    public function __destruct()
    {
        fclose($this->fileDescriptor);
    }

    /**
     * @param string $message
     * @param string $level
     * @param array $data
     */
    public function log(string $message, string $level, array $data = []): void
    {
        $message = (new \DateTime())->format(DATE_ATOM)
            . ' :: ' . strtoupper($level)
            . ' :: ' . $message
            . ' :: ' . json_encode($data)
            . PHP_EOL;
        fwrite($this->fileDescriptor, $message);
    }

    /**
     * @param string $directoryPath
     * @throws LoggerServiceException
     */
    private function createDirectoryIfItNotExist(string $directoryPath): void
    {
        if (!file_exists($directoryPath) && !mkdir($directoryPath) && !is_dir($directoryPath)) {
            throw new LoggerServiceException("Не удалось создать директорию: $directoryPath");
        }
    }
}
