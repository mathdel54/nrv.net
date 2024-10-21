<?php
declare(strict_types=1);

return function( \Slim\App $app):\Slim\App {

    $app->get('/', callable: nrv\application\actions\HomeAction::class)->setName('home');

    return $app;
};