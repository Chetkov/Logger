<?php

namespace Chetkov\Logger\Validation;

/**
 * Class ConfigValidator
 * @package Chetkov\Logger\Validation
 */
class ConfigValidator
{
    /**
     * @var string[]
     */
    private $errors = [];

    /**
     * @param array $config
     * @return bool
     */
    public function validateFileLoggerConfig(array $config): bool
    {
        $result = true;
        $this->errors = [];

        if (!isset($config['path'])) {
            $this->errors[] = 'Не определен обязательный параметр: path';
            $result = false;
        }

        return $result;
    }

    /**
     * @param array $config
     * @return bool
     */
    public function validateMongoLoggerConfig(array $config): bool
    {
        $result = true;
        $this->errors = [];

        if (!isset($config['uri'])) {
            $this->errors[] = 'Не определен обязательный параметр: uri';
            $result = false;
        }

        if (!isset($config['database'])) {
            $this->errors[] = 'Не определен обязательный параметр: database';
            $result = false;
        }

        return $result;
    }

    /**
     * @return string[]
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
