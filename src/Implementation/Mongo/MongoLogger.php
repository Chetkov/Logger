<?php

namespace Chetkov\Logger\Implementation\Mongo;

use MongoDB\Client;
use Chetkov\Logger\Implementation\LoggerImplementation;

/**
 * Class MongoLogger
 * @package Chetkov\Logger\Implementation\Mongo
 */
class MongoLogger implements LoggerImplementation
{
    /**
     * @var Client
     */
    private $mongoClient;

    /**
     * @var string
     */
    private $collectionName;

    /**
     * @var string
     */
    private $dateBase;

    /**
     * @var string
     */
    private $dateFormatForGrouping;

    /**
     * MongoLogger constructor.
     * @param Client $mongoClient
     * @param string $dataBase
     * @param string $collectionName
     * @param string $dateFormatFprGrouping
     */
    public function __construct(Client $mongoClient, string $dataBase = 'logs', string $collectionName = 'default', string $dateFormatFprGrouping = '')
    {
        $this->mongoClient = $mongoClient;
        $this->dateBase = $dataBase;
        $this->collectionName = $collectionName;
        $this->dateFormatForGrouping = $dateFormatFprGrouping;
    }

    /**
     * @param string $message
     * @param string $level
     * @param array $data
     */
    public function log(string $message, string $level, array $data = []): void
    {
        $collectionName = $this->collectionName;
        if ($this->dateFormatForGrouping) {
            $currentDate = new \DateTime();
            $collectionName .= "_{$currentDate->format($this->dateFormatForGrouping)}";
        }

        $this->mongoClient->selectCollection($this->dateBase, $collectionName)->insertOne([
            'level' => $level,
            'message' => $message,
            'data' => $data,
        ]);
    }
}
