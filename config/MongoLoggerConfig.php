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
