<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'vendor/autoload.php';

Predis\Autoloader::register();

if (isset($_GET['cmd']) === true) {
  $host = 'redis-master';
  if (getenv('GET_HOSTS_FROM') == 'env') {
    $host = getenv('REDIS_HOST');
    $pwd = getenv('REDIS_PWD');
    $port = getenv('REDIS_PORT');
  }
  header('Content-Type: application/json');
  if ($_GET['cmd'] == 'set') {
    $client = new Predis\Client([
      'scheme' => 'tcp',
      'host'   => $host,
      'port'   => $port,
      'password'    => $pwd,
      'username'    => 'default',
    ]);

    $client->set($_GET['key'], $_GET['value']);
    print('{"message": "Updated"}');
  } else {
    $host = 'redis-replica';
    if (getenv('GET_HOSTS_FROM') == 'env') {
      $host = getenv('REDIS_HOST');
      $pwd = getenv('REDIS_PWD');
      $port = getenv('REDIS_PORT');
    }
    $client = new Predis\Client([
      'scheme' => 'tcp',
      'host'   => $host,
      'port'   => $port,
      'password'    => $pwd,
      'username'    => 'default',
    ]);

    $value = $client->get($_GET['key']);
    print('{"data": "' . $value . '"}');
  }
} else {
  phpinfo();
} ?>
