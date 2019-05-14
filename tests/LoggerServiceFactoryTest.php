<?php

namespace Tests\Chetkov\Logger;

use PHPUnit\Framework\TestCase;
use Chetkov\Logger\LoggerService;
use Chetkov\Logger\LoggerServiceException;
use Chetkov\Logger\LoggerServiceFactory;
use Tests\Chetkov\Logger\Tool\TempFilesManager;

/**
 * Class LoggerServiceFactoryTest
 * @package Tests\Chetkov\Logger
 */
class LoggerServiceFactoryTest extends TestCase
{
    use TempFilesManager;

    /**
     * @var LoggerServiceFactory
     */
    private $loggerServiceFactory;

    /**
     * LoggerServiceFactoryTest constructor.
     * @param null|string $name
     * @param array $data
     * @param string $dataName
     */
    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->loggerServiceFactory = LoggerServiceFactory::getInstance();
    }

    public function testGetInstance(): void
    {
        $this->assertInstanceOf(LoggerServiceFactory::class, $this->loggerServiceFactory);
    }

    /**
     * @throws LoggerServiceException
     */
    public function testBuild(): void
    {
        $loggerService = $this->loggerServiceFactory->build('TempForTesting');
        $this->assertInstanceOf(LoggerService::class, $loggerService);

        $loggerService = $this->loggerServiceFactory->build('TempForTesting', LoggerService::IMPLEMENTATION_FILE, [
            'path' => $this->getTmpDirPath(),
            'date_format_for_grouping' => '',
        ]);
        $this->assertInstanceOf(LoggerService::class, $loggerService);

        $this->removeFile($this->getTmpFilePath('TempForTesting'));
        $this->removeTmpDir($this->getTmpDirPath());

        $this->expectException(LoggerServiceException::class);
        $this->loggerServiceFactory->build('TempForTesting', 'UNKNOWN', [
            'path' => $this->getTmpDirPath(),
        ]);
    }
}
