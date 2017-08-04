<?php

use Phalcon\Loader;

$loader = new Loader();
$loader->registerNamespaces(['Uncle' => realpath('../app').'/']);

$loader->register();

$api = new Uncle\Api();
$api->execute();
