<?php

namespace Tests\Chetkov\Logger;

use Chetkov\Logger\Validation\ConfigValidator;
use PHPUnit\Framework\TestCase;

/**
 * Class ConfigValidatorTest
 * @package Tests\Chetkov\Logger
 */
class ConfigValidatorTest extends TestCase
{
    /**
     * @var ConfigValidator
     */
    private $configValidator;

    /**
     * ConfigValidatorTest constructor.
     * @param null|string $name
     * @param array $data
     * @param string $dataName
     */
    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->configValidator = new ConfigValidator();
    }

    public function testValidateFileLoggerConfig(): void
    {
        $isConfigValid = $this->configValidator->validateFileLoggerConfig([
            'path' => LOGGER_ROOT . '/logs',
            'date_format_for_grouping' => 'Y-m',
        ]);
        $this->assertTrue($isConfigValid);

        $isConfigValid = $this->configValidator->validateFileLoggerConfig([]);
        $this->assertFalse($isConfigValid);
    }

    public function testValidateMongoLoggerConfig(): void
    {
        $isConfigValid = $this->configValidator->validateMongoLoggerConfig([
            // Входные параметры для MongoDB\Client
            'uri' => 'mongodb://127.0.0.1/',
            'uri_options' => [],
            'driver_options' => [],

            // Входные параметры Implementation\Mongo\MongoLogger
            'database' => 'logs',
            'date_format_for_grouping' => 'Y-m',
        ]);
        $this->assertTrue($isConfigValid);

        $isConfigValid = $this->configValidator->validateMongoLoggerConfig([]);
        $this->assertFalse($isConfigValid);
    }

    public function testGetErrors(): void
    {
        $this->assertInternalType('array', $this->configValidator->getErrors());
    }
}
