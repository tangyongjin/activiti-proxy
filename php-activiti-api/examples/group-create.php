<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Activiti\Client\ModelFactory;
use Activiti\Client\ObjectSerializer;
use Activiti\Client\ServiceFactory;
use GuzzleHttp\Client;

$client = new Client([
    'base_uri' => 'http://localhost:8080/activiti-rest/service/',
    'auth' => [
        'kermit', 'kermit',
    ],
]);

$group = (new ServiceFactory($client, new ModelFactory(), new ObjectSerializer()))
    ->createGroupService()
    ->createGroup('Group A', 'Type', 'group-a');

var_dump($group);
