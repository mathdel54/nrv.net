<?php 

namespace nrv\core\repositoryInterfaces;

use nrv\core\dto\spectacle\SpectacleDTO;

interface ServiceSpectacleInterface
{
    public function getSpectacles(): array;
    public function getSpectacleById(string $id): SpectacleDTO;
    public function getSpectaclesByDate(string $date): array;
    public function getSpectaclesByStyle(string $style): array;
}