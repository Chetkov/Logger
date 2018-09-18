<?php

namespace Tests\Chetkov\Logger\Tool;

/**
 * Trait TempFilesManager
 * @package Tests\Chetkov\Logger\Tool
 */
trait TempFilesManager
{
    /**
     * @return string
     */
    private function getTmpDirPath(): string
    {
        return LOGGER_ROOT . '/tests/tmp/';
    }

    /**
     * @param string $name
     * @return string
     */
    private function getTmpFilePath(string $name): string
    {
        return $this->getTmpDirPath() . $name . '.log';
    }

    /**
     * @param $testLogFile
     */
    private function removeFile(string $testLogFile): void
    {
        if (file_exists($testLogFile)) {
            @unlink($testLogFile);
        }
    }

    /**
     * @param string $testLogPath
     */
    private function removeTmpDir(string $testLogPath): void
    {
        if (file_exists($testLogPath)) {
            $files = scandir($testLogPath, SORT_ASC);
            foreach ($files as $file) {
                if (in_array($file, ['.', '..'])) {
                    continue;
                }
                return;
            }
            rmdir($testLogPath);
        }
    }
}
