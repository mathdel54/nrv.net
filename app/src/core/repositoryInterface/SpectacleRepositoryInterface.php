<?php

namespace nrv\core\repositoryInterfaces;

use nrv\core\domain\entities\spectacle\Spectacle;

interface SpectacleRepositoryInterface
{

    public function getSpectacles(): array;
    public function getSpectacleById(string $id): Spectacle;
    public function getSpectaclesByDate(string $date): array;
    public function getSpectaclesByStyle(string $style): array;
}