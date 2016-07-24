<?php
require __DIR__ . '/../vendor/autoload.php';

use VP\Application;
use VP\GooglePlaces\ApiClient;
use VP\HTTP\Client;
use VP\HTTP\Curl;
use VP\Model\Place;
use VP\Router;

ini_set('display_errors', 1);

$router = new Router();

$router->add('/', function () {
    header('Location: http://localhost/places/search?query=burritos+in+Berlin');
});

$router->add('/places/search', function (array $parameters) {
    $placesClient = new ApiClient(new Client(new Curl(), 30));
    $foundPlaces  = $placesClient->textSearch($parameters);

    foreach ($foundPlaces as &$place) {
        $place = new Place($place);
    }

    return $foundPlaces;
});

$application = new Application($router);
$application->run();
