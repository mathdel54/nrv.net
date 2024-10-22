<?php
declare(strict_types=1);

use nrv\application\middlewares\Cors;

return function(\Slim\App $app):\Slim\App {

    $app->get('/', callable: nrv\application\actions\HomeAction::class)->setName('home');

    $app->get('/spectacles', callable: nrv\application\actions\ListeSpectacleAction::class)->setName('spectacles')
        ->add(new Cors());

    return $app;
};