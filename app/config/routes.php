<?php

declare(strict_types=1);

use Slim\Routing\RouteCollectorProxy;
use Slim\App;
use nrv\application\middlewares\AuthMiddleware;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

return function (App $app): App {

    // Routes publiques
    $app->get('/', callable: nrv\application\actions\HomeAction::class);
    $app->post('/inscription', callable: nrv\application\actions\CreerCompteAction::class);
    $app->post('/connexion', callable: nrv\application\actions\ConnexionAction::class);
    $app->get('/lieux', callable: nrv\application\actions\ListeLieuAction::class);
    $app->get('/spectacles', callable: nrv\application\actions\ListeSpectacleAction::class);
    $app->get('/spectacles/{ID_Spectacle}/artistes', callable: nrv\application\actions\ArtistesBySpectacleAction::class);
    $app->get('/soiree/{id}', callable: nrv\application\actions\DetailSoireeAction::class);
    $app->get('/soirees/{id}/spectacles', callable: nrv\application\actions\ListeSpectacleSoireeAction::class);
    $app->get('/spectacles/{ID_Spectacle}/soiree', callable: nrv\application\actions\SoireeBySpectacleAction::class);
    $app->get('/lieux/{ID_Lieu}/spectacles', callable: nrv\application\actions\ListeSpectacleByLieuAction::class);

    
    $app->group('', function (RouteCollectorProxy $group) {

        $group->get('/users/{id_user}/billets', callable: nrv\application\actions\ListeBilletUser::class);
        $group->post('/billets', callable: nrv\application\actions\AchatBilletAction::class);
        $group->patch('/billets/{id}', callable: nrv\application\actions\UpdateBilletAction::class);
    })->add(AuthMiddleware::class);


    $app->options('/{routes:.+}',
    function( ServerRequestInterface $rq, ResponseInterface $rs, array $args) : ResponseInterface 
                {
                    return $rs;
                });



    return $app;
};
