<?php

declare(strict_types=1);

use Slim\App;

return function (App $app): App {

    $app->get('/', callable: nrv\application\actions\HomeAction::class);

    $app->get('/spectacles', callable: nrv\application\actions\ListeSpectacleAction::class);

    $app->get('/spectacles/{ID_Spectacle}/artistes', callable: nrv\application\actions\ArtistesBySpectacleAction::class);

    $app->get('/soiree/{id}', callable: nrv\application\actions\DetailSoireeAction::class);

    $app->get('/soirees/{id}/spectacles', callable: nrv\application\actions\ListeSpectacleSoireeAction::class);

    $app->get('/spectacles/{ID_Spectacle}/soiree', callable: nrv\application\actions\SoireeBySpectacleAction::class);

    $app->get('/lieux/{ID_Lieu}/spectacles', callable: nrv\application\actions\ListeSpectacleByLieuAction::class);

    $app->get('/users/{id_user}/billets', callable: nrv\application\actions\ListeBilletUser::class);

    $app->get('/lieux', callable: nrv\application\actions\ListeLieuAction::class);

    $app->post('/billets', callable: nrv\application\actions\AchatBilletAction::class);
    
    $app->patch('/billets/{id}', callable: nrv\application\actions\UpdateBilletAction::class);

    $app->post('/inscription', callable: nrv\application\actions\CreerCompteAction::class);

    $app->post('/connexion', callable: nrv\application\actions\ConnexionAction::class)
    ->setName('connexion');


    return $app;
};
