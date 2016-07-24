<?php
require __DIR__ . '/../vendor/autoload.php';

use VP\Application;
use VP\Router;

ini_set('display_errors', 1);

$router = new Router();
parse_str($_SERVER['QUERY_STRING'], $parameters);

$router->add('/', function () {
    header('Location: http://localhost/places/search?query=burritos+in+Berlin');
});

$router->add('/places/search', function () use ($parameters) {
    return ['parameters' => $parameters];
});

$application = new Application($router);
$application->run();
