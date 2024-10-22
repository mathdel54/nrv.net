<?php 

namespace nrv\core\services;

use nrv\core\dto\spectacle\SpectacleDTO;

interface ServiceUserInterface
{
    public function getSpectacles(): array;
    public function getSpectacleById(string $id): SpectacleDTO;
    public function getSpectaclesByDate(string $date): array;
    public function getSpectaclesByStyle(string $style): array;
}