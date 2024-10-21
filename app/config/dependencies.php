<?php

use Psr\Container\ContainerInterface;
use nrv\core\services\spectacle\ServiceSpectacle;
use nrv\core\repositoryInterfaces\SpectacleRepositoryInterface;

return [
    
    ServiceSpectacle::class => function(ContainerInterface $c) {
        return new ServiceSpectacle($c->get(SpectacleRepositoryInterface::class));
    }
];