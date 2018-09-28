# logger

```php
$logger = LoggerServiceFactory::getInstance()->build('test');

$logger->debug('Тест уровня логгирования: DEBUG');
```
Метод **build** принимает:
 - name (обязательный)
 - implementation (FILE/MONGO, по умолчанию: MONGO)
 - config (по умолчанию подхватится конфиг из /config)
 
 ## MongoLogger
 Конфиг по умолчанию:
 ```php
<?php

return [
    // Входные параметры для MongoDB\Client
    'uri' => 'mongodb://127.0.0.1/',
    'uri_options' => [],
    'driver_options' => [],

    // Входные параметры Implementation\Mongo\MongoLogger
    'database' => 'logs',
    'date_format_for_grouping' => 'Y-m',
];
```
 
 ## FileLogger
 Конфиг по умолчанию:
 ```php
<?php

return [
    'path' => LOGGER_ROOT . '/logs',
    'date_format_for_grouping' => 'Y-m',
];
```