<?php


 error_reporting(E_ALL);
 ini_set('display_errors', 1);



require_once __DIR__ . '/../vendor/autoload.php';

use Activiti\Client\ModelFactory;
use Activiti\Client\ObjectSerializer;
use Activiti\Client\ServiceFactory;
use Activiti\Client\Model\User\UserQuery;
use GuzzleHttp\Client;


$client = new Client([
    'base_uri' => 'http://119.254.119.57:8111/activiti-rest/service/',
    'auth' => [
        'admin', 'test',
    ],
]);




$serviceFactory = new ServiceFactory($client, new ModelFactory(), new ObjectSerializer());




$service = $serviceFactory->createUserService();


$query = new UserQuery();
$query->setSize(10);

do {
    $users = $service->getUsersList($query);

    foreach ($users as $i => $user) {
        vprintf("%d. %s %s (%s) <%s>\n", [
            $query->getStart() + $i + 1,
            $user->getFirstName(),
            $user->getLastName(),
            $user->getId(),
            $user->getEmail(),
        ]);
    }

    $query->setStart($query->getStart() + $query->getSize());
} while ($users->getTotal() > $query->getStart());

echo 111;
die;
