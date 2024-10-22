<?php

declare(strict_types=1);

use nrv\application\middlewares\Cors;

return function(\Slim\App $app):\Slim\App {

    $app->get('/', callable: nrv\application\actions\HomeAction::class)->setName('home');

    $app->get('/spectacles', callable: nrv\application\actions\ListeSpectacleAction::class)->setName('spectacles')
        ->add(new Cors());

    $app->get('/spectacles/{ID_Spectacle}/artistes', callable: nrv\application\actions\ArtistesBySpectacleAction::class)
        ->setName('artistesBySpectacles')
        ->add(new Cors());

    $app->get('/soiree/{id}', callable: nrv\application\actions\DetailSoireeAction::class)
        ->setName('soiree')
        ->add(new Cors());

    $app->get('/soirees/{id}/spectacles', callable: nrv\application\actions\ListeSpectacleSoireeAction::class)
        ->setName('spectaclesSoiree')
        ->add(new Cors());

    $app->get('/spectacles/{ID_Spectacle}/soiree', callable: nrv\application\actions\SoireeBySpectacleAction::class)
        ->setName('soireeBySpectacle')
        ->add(new Cors());

    return $app;
};
