<?php

namespace Tests\Chetkov\Logger;

use Chetkov\Logger\LoggerService;
use PHPUnit\Framework\TestCase;
use Chetkov\Logger\LoggerServiceFactory;
use Tests\Chetkov\Logger\Tool\TempFilesManager;

/**
 * Class LoggerServiceTest
 * @package Tests\Chetkov\Logger
 */
class LoggerServiceTest extends TestCase
{
    use TempFilesManager;

    /**
     * @var LoggerService
     */
    private $loggerService;

    /**
     * LoggerServiceTest constructor.
     * @param null|string $name
     * @param array $data
     * @param string $dataName
     */
    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->loggerService = LoggerServiceFactory::getInstance()
            ->build('TempForTesting', LoggerService::IMPLEMENTATION_FILE, [
                'path' => $this->getTmpDirPath(),
            ]);
    }

    public function __destruct()
    {
        $config = require LOGGER_ROOT . '/config/FileLoggerConfig.php';

        $dateFormatForGrouping = $config['date_format_for_grouping'] ?? LoggerService::DEFAULT_DATE_FORMAT_FOR_GROUPING;

        $path = $this->getTmpDirPath();
        if ($dateFormatForGrouping) {
            $currentDateTime = new \DateTime();
            $path .= "/{$currentDateTime->format($dateFormatForGrouping)}";
        }

        $fileName = $path . '/TempForTesting.log';
        $this->removeFile($fileName);
        $this->removeTmpDir($path);
        $this->removeTmpDir($this->getTmpDirPath());
    }

    public function testDebug(): void
    {
        $this->loggerService->debug('debug');
        $this->assertTrue(true);
    }

    public function testInfo(): void
    {
        $this->loggerService->info('info');
        $this->assertTrue(true);
    }

    public function testWarning(): void
    {
        $this->loggerService->warning('warning');
        $this->assertTrue(true);
    }

    public function testError(): void
    {
        $this->loggerService->error('error');
        $this->assertTrue(true);
    }

    public function testCritical(): void
    {
        $this->loggerService->critical('critical');
        $this->assertTrue(true);
    }
}
