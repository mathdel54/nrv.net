<?php 

namespace nrv\core\services\user;

use nrv\core\dto\spectacle\LieuxSpectacleDTO;
use nrv\core\dto\spectacle\SpectacleDTO;
use nrv\core\dto\soiree\SoireeDTO;

interface ServiceUserInterface
{
    public function getSpectacles(): array;
    public function getSpectacleById(string $id): SpectacleDTO;
    public function getSpectaclesByDate(string $date): array;
    public function getSpectaclesByStyle(string $style): array;
    public function getArtistesBySpectacle(string $id): array;
    public function getImagesBySpectacle(string $id): array;
    public function getSoireeById(string $id): SoireeDTO;
    public function getLieuById(string $id): LieuxSpectacleDTO;
    public function getImagesByLieu(string $id): array;
    public function getSpectaclesBySoireeId(string $id): array;
}