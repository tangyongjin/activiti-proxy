<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Activiti\Client\ModelFactory;
use Activiti\Client\ObjectSerializer;
use Activiti\Client\ServiceFactory;
use GuzzleHttp\Client;

$client = new Client([
    'base_uri' => 'http://119.254.119.57:8111/activiti-rest/service/',
    'auth' => [
        'kermit', 'kermit',
    ],
]);

$serviceFactory = new ServiceFactory($client, new ModelFactory(), new ObjectSerializer());
$service = $serviceFactory->createProcessDefinitionService();



echo "<pre>";

print_r ($service->getProcessDefinition($argv[1]));

echo "</pre>";
