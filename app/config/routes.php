<?php

declare(strict_types=1);

use nrv\application\actions\ListeSpectacleByLieuAction;
use Slim\App;

return function (App $app): App {

    $app->get('/', callable: nrv\application\actions\HomeAction::class)->setName('home');

    $app->get('/spectacles', callable: nrv\application\actions\ListeSpectacleAction::class)->setName('spectacles');

    $app->get('/spectacles/{ID_Spectacle}/artistes', callable: nrv\application\actions\ArtistesBySpectacleAction::class)
        ->setName('artistesBySpectacles');

    $app->get('/soiree/{id}', callable: nrv\application\actions\DetailSoireeAction::class)
        ->setName('soiree');

    $app->get('/soirees/{id}/spectacles', callable: nrv\application\actions\ListeSpectacleSoireeAction::class)
        ->setName('spectaclesSoiree');

    $app->get('/spectacles/{ID_Spectacle}/soiree', callable: nrv\application\actions\SoireeBySpectacleAction::class)
        ->setName('soireeBySpectacle');

    $app->get('/lieu/{ID_Lieu}/spectacles', callable: ListeSpectacleByLieuAction::class)
        ->setName('spectaclesByLieu');

    $app->get('/users/{id_user}/billets', callable: nrv\application\actions\ListeBilletUser::class)
        ->setName('billetsUser');

    return $app;
};
