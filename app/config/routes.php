<?php

declare(strict_types=1);

return function (\Slim\App $app): \Slim\App {

    $app->get('/', callable: nrv\application\actions\HomeAction::class)->setName('home');

    $app->get('/spectacles', callable: nrv\application\actions\ListeSpectacleAction::class)->setName('spectacles');

    $app->get('/spectacles/{ID_Spectacle}/artistes', callable: nrv\application\actions\ArtistesBySpectacleAction::class)->setName('artistesBySpectacles');

    $app->get('/soirees/{id}', callable: nrv\application\actions\DetailSoireeAction::class)->setName('soiree');

    $app->get('/soirees/{id}/spectacles', callable: nrv\application\actions\ListeSpectacleSoireeAction::class)->setName('spectaclesSoiree');

    $app->get('/spectacles/{ID_Spectacle}/soirees', callable: nrv\application\actions\SoireeBySpectacleAction::class)->setName('soireeBySpectacle');

    return $app;
};
