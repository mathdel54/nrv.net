<?php

use DI\ContainerBuilder;
use Slim\Factory\AppFactory;
use nrv\application\middlewares\Cors;
use Dotenv\Dotenv;
use nrv\application\middlewares\AuthMiddleware;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../'); 
$dotenv->load();


$builder = new ContainerBuilder();
$builder->addDefinitions(__DIR__ . '/settings.php' );
$builder->addDefinitions(__DIR__ . '/dependencies.php');

$c=$builder->build();
$app = AppFactory::createFromContainer($c);

$jwtSecret = $_ENV['JWT_SECRET'] ?? null;


$app->add(new Cors());
//$app->add(new AuthMiddleware($jwtSecret));


$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();
$app->addErrorMiddleware($c->get('displayErrorDetails'), false, false);


//    ->getDefaultErrorHandler()
//    ->forceContentType('application/json')
;


$app = (require_once __DIR__ . '/routes.php')($app);
$routeParser = $app->getRouteCollector()->getRouteParser();


return $app;