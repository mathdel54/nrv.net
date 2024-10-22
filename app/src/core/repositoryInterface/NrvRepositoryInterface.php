<?php

namespace nrv\core\repositoryInterface;

use nrv\core\domain\entities\spectacle\Spectacle;
use nrv\core\domain\entities\soiree\Soiree;
use nrv\core\domain\entities\spectacle\LieuxSpectacle;

interface NrvRepositoryInterface
{

    public function getSpectacles(): array;
    public function getSpectacleById(string $id): Spectacle;
    public function getSpectaclesByDate(string $date): array;
    public function getSpectaclesByStyle(string $style): array;
    public function getArtistesBySpectacle(string $id): array;
    public function getImagesBySpectacle(string $id): array;
    public function getSoireeById(string $id): Soiree;
    public function getLieuById(string $id): LieuxSpectacle;
    public function getImagesByLieu(string $id): array;
    public function getSpectaclesBySoireeId(string $id): array;
    public function getSoireeBySpectacleId(string $id): Soiree;
}
