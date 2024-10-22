<?php

use nrv\application\actions\ListeSpectacleAction;
use nrv\core\services\ServiceUserInterface;
use Psr\Container\ContainerInterface;
use nrv\core\services\ServiceUser;
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

    NrvRepositoryInterface::class => function (ContainerInterface $c) {
        return new PDONrvRepository($c->get('nrv.pdo'));
    },
];