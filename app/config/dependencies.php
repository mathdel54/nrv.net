<?php

use nrv\application\actions\DetailSoireeAction;
use nrv\application\actions\ListeSpectacleAction;
use nrv\application\actions\ListeSpectacleSoireeAction;
use nrv\application\actions\SpectacleByStyleAction;
use nrv\core\services\user\ServiceUserInterface;
use Psr\Container\ContainerInterface;
use nrv\core\services\user\ServiceUser;
use nrv\core\repositoryInterface\NrvRepositoryInterface;
use nrv\infrastructure\repositories\PDONrvRepository;

return [

    'nrv.pdo' => function (ContainerInterface $c) {
        $config = parse_ini_file(__DIR__ . '/nrv.db.ini');
        $dsn = "{$config['driver']}:host={$config['host']};dbname={$config['database']}";
        $user = $config['username'];
        $password = $config['password'];
        return new PDO($dsn, $user, $password);
    },
    
    ServiceUserInterface::class => function(ContainerInterface $c) {
        return new ServiceUser($c->get(NrvRepositoryInterface::class));
    },

    ListeSpectacleAction::class => function (ContainerInterface $c) {
        return new ListeSpectacleAction($c->get(ServiceUserInterface::class));
    },

    DetailSoireeAction::class => function (ContainerInterface $c) {
        return new DetailSoireeAction($c->get(ServiceUserInterface::class));
    },

    NrvRepositoryInterface::class => function (ContainerInterface $c) {
        return new PDONrvRepository($c->get('nrv.pdo'));
    },

    ListeSpectacleSoireeAction::class => function (ContainerInterface $c) {
        return new ListeSpectacleSoireeAction($c->get(ServiceUserInterface::class));
    },
];