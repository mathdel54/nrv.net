<?php

namespace nrv\infrastructure\repositories;

use nrv\core\repositoryInterface\NrvRepositoryInterface;
use nrv\core\domain\entities\spectacle\Spectacle;
use nrv\core\repositoryInterfaces\RepositoryDatabaseErrorException;
use nrv\core\repositoryInterfaces\RepositoryEntityNotFoundException;

class PDONrvRepository implements NrvRepositoryInterface {

    private $pdoSpectacle;

    public function __construct($pdoSpectacle) {
        $this->pdoSpectacle = $pdoSpectacle;
    }

    public function getSpectacles(): array {
        try{
            $stmt = $this->pdoSpectacle->prepare("SELECT * FROM spectacle");
            $stmt->execute();
            $spectacles = $stmt->fetchAll();
            if(!$spectacles){
                throw new RepositoryEntityNotFoundException('Aucun spectacle trouvé');
            }
        } catch (\PDOException $e) {
            throw new RepositoryDatabaseErrorException('Erreur lors de la récupération des spectacles', 0, $e);
        }
        $tabSpectacles = [];
        foreach($spectacles as $spectacle){
            $spec = new Spectacle($spectacle['titre'], $spectacle['description'], $spectacle['url_video'], $spectacle['horaire_previsionnel'], $spectacle['soiree_id'], $spectacle['style']);
            $spec->setID($spectacle['id']);
            $tabSpectacles[] = $spec;
        }
        return $tabSpectacles;
    }

    public function getSpectacleById(string $id): Spectacle {
        $stmt = $this->pdoSpectacle->prepare("SELECT * FROM spectacle WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function getSpectaclesByDate(string $date): array {
        $stmt = $this->pdoSpectacle->prepare("SELECT * FROM spectacle WHERE date = :date");
        $stmt->execute(['date' => $date]);
        return $stmt->fetchAll();
    }

    public function getSpectaclesByStyle(string $style): array {
        $stmt = $this->pdoSpectacle->prepare("SELECT * FROM spectacle WHERE style = :style");
        $stmt->execute(['style' => $style]);
        return $stmt->fetchAll();
    }
}