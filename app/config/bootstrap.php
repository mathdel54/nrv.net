<?php

use DI\ContainerBuilder;
use Slim\Factory\AppFactory;
use nrv\application\middlewares\Cors;

$builder = new ContainerBuilder();
$builder->addDefinitions(__DIR__ . '/settings.php' );
$builder->addDefinitions(__DIR__ . '/dependencies.php');

$c=$builder->build();
$app = AppFactory::createFromContainer($c);

$app->add(new Cors());

$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();
$app->addErrorMiddleware($c->get('displayErrorDetails'), false, false);


//    ->getDefaultErrorHandler()
//    ->forceContentType('application/json')
;


$app = (require_once __DIR__ . '/routes.php')($app);
$routeParser = $app->getRouteCollector()->getRouteParser();


return $app;