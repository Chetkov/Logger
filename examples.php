<?php

use Chetkov\Logger\LoggerService;
use Chetkov\Logger\LoggerServiceFactory;

require_once 'vendor/autoload.php';


// Логирование в монгу
$mongoLogger = LoggerServiceFactory::getInstance()->build('test');

$mongoLogger->debug('Тест уровня логгирования: DEBUG');
$mongoLogger->info('Тест уровня логгирования: INFO');
$mongoLogger->warning('Тест уровня логгирования: WARNING');
$mongoLogger->error('Тест уровня логгирования: ERROR');
$mongoLogger->critical('Тест уровня логгирования: CRITICAL');


//Логирование в файл
$fileLogger = LoggerServiceFactory::getInstance()->build('test', LoggerService::IMPLEMENTATION_FILE);

$fileLogger->debug('Тест уровня логгирования: DEBUG');
$fileLogger->info('Тест уровня логгирования: INFO');
$fileLogger->warning('Тест уровня логгирования: WARNING');
$fileLogger->error('Тест уровня логгирования: ERROR');
$fileLogger->critical('Тест уровня логгирования: CRITICAL');
