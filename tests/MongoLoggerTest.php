<?php

namespace Tests\Chetkov\Logger;

use MongoDB\Client;
use Chetkov\Logger\Implementation\Mongo\MongoLogger;
use PHPUnit\Framework\TestCase;
use Psr\Log\LogLevel;

/**
 * Class MongoLoggerTest
 * @package Tests\Chetkov\Logger
 */
class MongoLoggerTest extends TestCase
{
    /**
     * @todo: Возможно не стоит завязываться на реальную базу..
     */
    public function testLog(): void
    {
        $mongoClient = new Client();

        $dataBase = 'temp_db_for_testing';
        $collectionName = 'logs';
        $dateFormatForGrouping = 'Ym';
        $mongoLogger = new MongoLogger($mongoClient, $dataBase, $collectionName, $dateFormatForGrouping);
        $collectionName .= '_' . (new \DateTime())->format($dateFormatForGrouping);

        $message = 'Тестовое сообщение';
        $level = strtoupper(LogLevel::INFO);
        $data = ['test' => 'test'];
        $mongoLogger->log($message, $level, $data);

        $countDocumentsInCollection = $mongoClient->selectCollection($dataBase, $collectionName)->countDocuments();
        $this->assertGreaterThan(0, $countDocumentsInCollection);

        $mongoClient->dropDatabase($dataBase);
    }
}
