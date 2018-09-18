<?php

namespace Chetkov\Logger;

/**
 * Interface Logger
 * @package Chetkov\Logger
 */
interface Logger
{
    public const LEVEL_DEBUG = 'debug';
    public const LEVEL_INFO = 'info';
    public const LEVEL_WARNING = 'warning';
    public const LEVEL_ERROR = 'error';
    public const LEVEL_CRITICAL = 'critical';

    /**
     * @param string $message
     * @param array $data
     */
    public function debug(string $message, array $data = []): void;

    /**
     * @param string $message
     * @param array $data
     */
    public function info(string $message, array $data = []): void;

    /**
     * @param string $message
     * @param array $data
     */
    public function warning(string $message, array $data = []): void;

    /**
     * @param string $message
     * @param array $data
     */
    public function error(string $message, array $data = []): void;

    /**
     * @param string $message
     * @param array $data
     */
    public function critical(string $message, array $data = []): void;
}
