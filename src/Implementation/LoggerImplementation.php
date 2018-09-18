<?php

namespace Chetkov\Logger\Implementation;

/**
 * Interface LoggerImplementation
 * @package Chetkov\Logger\Implementation
 */
interface LoggerImplementation
{
    /**
     * @param string $message
     * @param string $level
     * @param array $data
     */
    public function log(string $message, string $level, array $data = []): void;
}
