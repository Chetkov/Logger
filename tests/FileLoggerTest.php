<?php

namespace Tests\Chetkov\Logger;

use Chetkov\Logger\Implementation\File\FileLogger;
use PHPUnit\Framework\TestCase;
use Chetkov\Logger\LoggerService;
use Tests\Chetkov\Logger\Tool\TempFilesManager;

/**
 * Class FileLoggerTest
 * @package Tests\Chetkov\Logger
 */
class FileLoggerTest extends TestCase
{
    use TempFilesManager;

    public function testLog(): void
    {
        $tmpDirectoryPath = $this->getTmpDirPath();
        $logName = 'FileLoggerTest_TestLog';
        $logFile = $this->getTmpFilePath($logName);
        $this->removeFile($logFile);

        $fileLogger = new FileLogger($tmpDirectoryPath, $logName);

        $message = 'Тестовое сообщение';
        $level = strtoupper(LoggerService::LEVEL_INFO);
        $data = ['тест' => 'тест'];
        $fileLogger->log($message, $level, $data);

        $this->assertFileExists($logFile);

        $content = file_get_contents($logFile);
        $this->assertContains($message, $content);
        $this->assertContains($level, $content);
        $this->assertContains(json_encode($data), $content);

        $this->removeFile($logFile);
        $this->removeTmpDir($tmpDirectoryPath);
    }
}
