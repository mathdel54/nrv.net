<?php

namespace nrv\core\repositoryInterface;

use nrv\core\domain\entities\spectacle\Spectacle;

interface NrvRepositoryInterface
{

    public function getSpectacles(): array;
    public function getSpectacleById(string $id): Spectacle;
    public function getSpectaclesByDate(string $date): array;
    public function getSpectaclesByStyle(string $style): array;
    public function getArtistesBySpectacle(string $id): array;
    public function getImagesBySpectacle(string $id): array;
}