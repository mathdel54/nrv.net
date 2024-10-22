<?php

use nrv\core\repositoryInterfaces\ServiceSpectacleInterface;
use Psr\Container\ContainerInterface;
use nrv\core\services\spectacle\ServiceSpectacle;
use nrv\core\repositoryInterfaces\SpectacleRepositoryInterface;

return [

    'artiste.pdo' => function (ContainerInterface $c) {
        $config = parse_ini_file(__DIR__ . '/artiste.db.ini');
        $dsn = "{$config['driver']}:host={$config['host']};dbname={$config['database']}";
        $user = $config['username'];
        $password = $config['password'];
        return new PDO($dsn, $user, $password);
    },

    'billet.pdo' => function (ContainerInterface $c) {
        $config = parse_ini_file(__DIR__ . '/billet.db.ini');
        $dsn = "{$config['driver']}:host={$config['host']};dbname={$config['database']}";
        $user = $config['username'];
        $password = $config['password'];
        return new PDO($dsn, $user, $password);
    },

    'spectacle.pdo' => function (ContainerInterface $c) {
        $config = parse_ini_file(__DIR__ . '/spectacle.db.ini');
        $dsn = "{$config['driver']}:host={$config['host']};dbname={$config['database']}";
        $user = $config['username'];
        $password = $config['password'];
        return new PDO($dsn, $user, $password);
    },

    'lieu.pdo' => function (ContainerInterface $c) {
        $config = parse_ini_file(__DIR__ . '/lieu.db.ini');
        $dsn = "{$config['driver']}:host={$config['host']};dbname={$config['database']}";
        $user = $config['username'];
        $password = $config['password'];
        return new PDO($dsn, $user, $password);
    },

    'utilisateur.pdo' => function (ContainerInterface $c) {
        $config = parse_ini_file(__DIR__ . '/utilisateur.db.ini');
        $dsn = "{$config['driver']}:host={$config['host']};dbname={$config['database']}";
        $user = $config['username'];
        $password = $config['password'];
        return new PDO($dsn, $user, $password);
    },
    
    ServiceSpectacleInterface::class => function(ContainerInterface $c) {
        return new ServiceSpectacle($c->get(SpectacleRepositoryInterface::class));
    }
];