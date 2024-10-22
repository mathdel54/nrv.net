<?php

namespace nrv\infrastructure\repositories;

use nrv\core\domain\entities\artiste\Artiste;
use nrv\core\repositoryInterface\NrvRepositoryInterface;
use nrv\core\domain\entities\spectacle\Spectacle;
use nrv\core\domain\entities\soiree\SoireeDTO;
use nrv\core\repositoryInterfaces\RepositoryDatabaseErrorException;
use nrv\core\repositoryInterfaces\RepositoryEntityNotFoundException;


class PDONrvRepository implements NrvRepositoryInterface {

    private $pdoNrv;

    public function __construct($pdoNrv) {
        $this->pdoNrv = $pdoNrv;
    }

    /**
     * Méthode qui retourne la liste des spectacles
     * @throws \nrv\core\repositoryInterfaces\RepositoryEntityNotFoundException
     * @throws \nrv\core\repositoryInterfaces\RepositoryDatabaseErrorException
     * @return array
     */
    public function getSpectacles(): array {
        try{
            $stmt = $this->pdoNrv->prepare("SELECT * FROM spectacle");
            $stmt->execute();
            $spectacles = $stmt->fetchAll();
            if(!$spectacles){
                throw new RepositoryEntityNotFoundException('Aucun spectacle trouvé');
            }
        } catch (\PDOException $e) {
            throw new RepositoryDatabaseErrorException('Erreur lors de la récupération des spectacles', 0, $e);
        }
        $tabSpectacles = [];
        $tabArtistes = [];
        $tabImages = [];
        foreach($spectacles as $spectacle){
            $tabArtistes = $this->getArtistesBySpectacle($spectacle['id']);
            $tabImages = $this->getImagesBySpectacle($spectacle['id']);
            $spec = new Spectacle($spectacle['titre'], $tabArtistes, $spectacle['description'], $tabImages, $spectacle['url_video'], new \DateTime($spectacle['horaire_previsionnel']));
            $spec->setID($spectacle['id']);
            $tabSpectacles[] = $spec;
        }
        return $tabSpectacles;
    }

    /**
     * Méthode qui retourne un spectacle par son ID
     * @param string $id
     * @throws \nrv\core\repositoryInterfaces\RepositoryEntityNotFoundException
     * @throws \nrv\core\repositoryInterfaces\RepositoryDatabaseErrorException
     * @return Spectacle
     */
    public function getSpectacleById(string $id): Spectacle {
        try{
            $stmt = $this->pdoNrv->prepare("SELECT * FROM spectacle WHERE id = :id");
            $stmt->execute(['id' => $id]);
            $spectacle = $stmt->fetch();
            if(!$spectacle){
                throw new RepositoryEntityNotFoundException('Aucun spectacle trouvé');
            }
        } catch (\PDOException $e) {
            throw new RepositoryDatabaseErrorException('Erreur lors de la récupération du spectacle', 0, $e);
        }
        $tabArtistes = $this->getArtistesBySpectacle($spectacle['id']);
        $tabImages = $this->getImagesBySpectacle($spectacle['id']);
        $spec = new Spectacle($spectacle['titre'], $tabArtistes, $spectacle['description'], $tabImages, $spectacle['url_video'], new \DateTime($spectacle['horaire_previsionnel']));
        $spec->setID($spectacle['id']);
        return $spec;
    }

    /**
     * Méthode qui retourne la liste des spectacles par date
     * @param string $date
     * @throws \nrv\core\repositoryInterfaces\RepositoryEntityNotFoundException
     * @throws \nrv\core\repositoryInterfaces\RepositoryDatabaseErrorException
     * @return array
     */
    public function getSpectaclesByDate(string $date): array {
        try{
            $stmt = $this->pdoNrv->prepare("SELECT * FROM spectacle WHERE date = :date");
            $stmt->execute(['date' => $date]);
            $spectacles = $stmt->fetchAll();
            if(!$spectacles){
                throw new RepositoryEntityNotFoundException('Aucun spectacle trouvé');
            }
        } catch (\PDOException $e) {
            throw new RepositoryDatabaseErrorException('Erreur lors de la récupération des spectacles', 0, $e);
        }
        $tabSpectacles = [];
        $tabArtistes = [];
        $tabImages = [];
        foreach($spectacles as $spectacle){
            $tabArtistes = $this->getArtistesBySpectacle($spectacle['id']);
            $tabImages = $this->getImagesBySpectacle($spectacle['id']);
            $spec = new Spectacle($spectacle['titre'], $tabArtistes, $spectacle['description'], $tabImages, $spectacle['url_video'], new \DateTime($spectacle['horaire_previsionnel']));
            $spec->setID($spectacle['id']);
            $tabSpectacles[] = $spec;
        }
        return $tabSpectacles;
    }

    /**
     * Méthode qui retourne la liste des spectacles par style
     * @param string $style
     * @throws \nrv\core\repositoryInterfaces\RepositoryEntityNotFoundException
     * @throws \nrv\core\repositoryInterfaces\RepositoryDatabaseErrorException
     * @return array
     */
    public function getSpectaclesByStyle(string $style): array {
        try{
            $stmt = $this->pdoNrv->prepare("SELECT * FROM spectacle WHERE style = :style");
            $stmt->execute(['style' => $style]);
            $spectacles = $stmt->fetchAll();
            if(!$spectacles){
                throw new RepositoryEntityNotFoundException('Aucun spectacle trouvé');
            }
        } catch (\PDOException $e) {
            throw new RepositoryDatabaseErrorException('Erreur lors de la récupération des spectacles', 0, $e);
        }
        $tabSpectacles = [];
        $tabArtistes = [];
        $tabImages = [];
        foreach($spectacles as $spectacle){
            $tabArtistes = $this->getArtistesBySpectacle($spectacle['id']);
            $tabImages = $this->getImagesBySpectacle($spectacle['id']);
            $spec = new Spectacle($spectacle['titre'], $tabArtistes, $spectacle['description'], $tabImages, $spectacle['url_video'], new \DateTime($spectacle['horaire_previsionnel']));
            $spec->setID($spectacle['id']);
            $tabSpectacles[] = $spec;
        }
        return $tabSpectacles;
    }

    /**
     * Méthode qui retourne la liste des artistes par spectacle
     * @param string $id
     * @throws \nrv\core\repositoryInterfaces\RepositoryEntityNotFoundException
     * @throws \nrv\core\repositoryInterfaces\RepositoryDatabaseErrorException
     * @return array
     */
    public function getArtistesBySpectacle(string $id): array {
        try{
            $stmt = $this->pdoNrv->prepare("SELECT * FROM artiste INNER JOIN artiste_spectacle ON artiste.id = id_artiste INNER JOIN spectacle ON id_spectacle = spectacle.id WHERE spectacle.id = :id");
            $stmt->execute(['id' => $id]);
            $artistes = $stmt->fetchAll();
            if(!$artistes){
                throw new RepositoryEntityNotFoundException('Aucun artiste trouvé');
            }
        } catch (\PDOException $e) {
            throw new RepositoryDatabaseErrorException($e->getMessage(), 0, $e);
        }
        $tabArtistes = [];
        foreach ($artistes as $artiste) {
            $art = new Artiste($artiste['nom']);
            $art->setID($artiste['id']);
            $tabArtistes[] = $art;
        }
        return $tabArtistes;
    }

    /**
     * Méthode qui retourne la liste des images par spectacle
     * @param string $id
     * @throws \nrv\core\repositoryInterfaces\RepositoryEntityNotFoundException
     * @throws \nrv\core\repositoryInterfaces\RepositoryDatabaseErrorException
     * @return array
     */
    public function getImagesBySpectacle(string $id): array {
        try{
            $stmt = $this->pdoNrv->prepare("SELECT lien FROM image_spectacle WHERE spectacle_id = :id");
            $stmt->execute(['id' => $id]);
            $images = $stmt->fetchAll();
        } catch (\PDOException $e) {
            throw new RepositoryDatabaseErrorException('Erreur lors de la récupération des images', 0, $e);
        }
        return $images;
    }
}