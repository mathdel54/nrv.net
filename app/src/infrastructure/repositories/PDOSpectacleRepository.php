<?php

namespace nrv\infrastructure\repositories;

use nrv\core\repositoryInterfaces\SpectacleRepositoryInterface;
use nrv\core\domain\entities\spectacle\Spectacle;

class PDOSpectacleRepository implements SpectacleRepositoryInterface {

    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getSpectacles(): array {
        $stmt = $this->pdo->prepare("SELECT * FROM spectacle");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getSpectacleById(string $id): Spectacle {
        $stmt = $this->pdo->prepare("SELECT * FROM spectacle WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function getSpectaclesByDate(string $date): array {
        $stmt = $this->pdo->prepare("SELECT * FROM spectacle WHERE date = :date");
        $stmt->execute(['date' => $date]);
        return $stmt->fetchAll();
    }

    public function getSpectaclesByStyle(string $style): array {
        $stmt = $this->pdo->prepare("SELECT * FROM spectacle WHERE style = :style");
        $stmt->execute(['style' => $style]);
        return $stmt->fetchAll();
    }
}