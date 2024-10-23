<?php

namespace nrv\infrastructure\repositories;

use DateTime;
use nrv\core\domain\entities\artiste\Artiste;
use nrv\core\repositoryInterface\NrvRepositoryInterface;
use nrv\core\domain\entities\spectacle\Spectacle;
use nrv\core\repositoryInterface\RepositoryDatabaseErrorException;
use nrv\core\repositoryInterface\RepositoryEntityNotFoundException;
use nrv\core\domain\entities\soiree\Soiree;
use nrv\core\domain\entities\spectacle\LieuxSpectacle;

class PDONrvRepository implements NrvRepositoryInterface
{

    private $pdoNrv;

    public function __construct($pdoNrv)
    {
        $this->pdoNrv = $pdoNrv;
    }

    /**
     * Méthode qui retourne la liste des spectacles
     * @throws \nrv\core\repositoryInterface\RepositoryEntityNotFoundException
     * @throws \nrv\core\repositoryInterface\RepositoryDatabaseErrorException
     * @return array
     * @throws \nrv\core\repositoryInterface\RepositoryDatabaseErrorException
     * @throws \nrv\core\repositoryInterface\RepositoryEntityNotFoundException
     */
    public function getSpectacles(): array
    {
        try {
            $stmt = $this->pdoNrv->prepare("SELECT * FROM spectacle");
            $stmt->execute();
            $spectacles = $stmt->fetchAll();
            if (!$spectacles) {
                throw new RepositoryEntityNotFoundException('Aucun spectacle trouvé');
            }
        } catch (\PDOException $e) {
            throw new RepositoryDatabaseErrorException('Erreur lors de la récupération des spectacles', 0, $e);
        }
        $tabSpectacles = [];
        $tabArtistes = [];
        $tabImages = [];
        foreach ($spectacles as $spectacle) {
            $tabArtistes = $this->getArtistesBySpectacle($spectacle['id']);
            $tabImages = $this->getImagesBySpectacle($spectacle['id']);
            $spec = new Spectacle($spectacle['titre'], $tabArtistes, $spectacle['description'], $tabImages, $spectacle['url_video'], new DateTime($spectacle['horaire_previsionnel']), $spectacle['style']);
            $spec->setID($spectacle['id']);
            $tabSpectacles[] = $spec;
        }
        return $tabSpectacles;
    }

    /**
     * Méthode qui retourne un spectacle par son ID
     * @param string $id
     * @return Spectacle
     * @throws \nrv\core\repositoryInterface\RepositoryDatabaseErrorException
     * @throws \nrv\core\repositoryInterface\RepositoryEntityNotFoundException
     */
    public function getSpectacleById(string $id): Spectacle
    {
        try {
            $stmt = $this->pdoNrv->prepare("SELECT * FROM spectacle WHERE id = :id");
            $stmt->execute(['id' => $id]);
            $spectacle = $stmt->fetch();
            if (!$spectacle) {
                throw new RepositoryEntityNotFoundException('Aucun spectacle trouvé');
            }
        } catch (\PDOException $e) {
            throw new RepositoryDatabaseErrorException('Erreur lors de la récupération du spectacle', 0, $e);
        }
        $tabArtistes = $this->getArtistesBySpectacle($spectacle['id']);
        $tabImages = $this->getImagesBySpectacle($spectacle['id']);
        $spec = new Spectacle($spectacle['titre'], $tabArtistes, $spectacle['description'], $tabImages, $spectacle['url_video'], new DateTime($spectacle['horaire_previsionnel']), $spectacle['style']);
        $spec->setID($spectacle['id']);
        return $spec;
    }

    /**
     * Méthode qui retourne la liste des spectacles par date
     * @param string $date
     * @throws \nrv\core\repositoryInterface\RepositoryEntityNotFoundException
     * @throws \nrv\core\repositoryInterface\RepositoryDatabaseErrorException
     * @return array
     */
    public function getSpectaclesByDate(DateTime $date): array
    {
        try {
            print_r($date);
            $stmt = $this->pdoNrv->prepare("SELECT * FROM spectacle WHERE horaire_previsonnel = :date");
            $stmt->execute(['date' => $date]);
            $spectacles = $stmt->fetchAll();
            if (!$spectacles) {
                throw new RepositoryEntityNotFoundException('Aucun spectacle trouvé');
            }
        } catch (\PDOException $e) {
            throw new RepositoryDatabaseErrorException('Erreur lors de la récupération des spectacles', 0, $e);
        }
        $tabSpectacles = [];
        $tabArtistes = [];
        $tabImages = [];
        foreach ($spectacles as $spectacle) {
            $tabArtistes = $this->getArtistesBySpectacle($spectacle['id']);
            $tabImages = $this->getImagesBySpectacle($spectacle['id']);
            $spec = new Spectacle($spectacle['titre'], $tabArtistes, $spectacle['description'], $tabImages, $spectacle['url_video'], new DateTime($spectacle['horaire_previsionnel']), $spectacle['style']);
            $spec->setID($spectacle['id']);
            $tabSpectacles[] = $spec;
        }
        return $tabSpectacles;
    }

    /**
     * Méthode qui retourne la liste des spectacles par style
     * @param string $style
     * @return array
     * @throws \nrv\core\repositoryInterface\RepositoryDatabaseErrorException
     * @throws \nrv\core\repositoryInterface\RepositoryEntityNotFoundException
     */
    public function getSpectaclesByStyle(string $style): array
    {
        try {
            $stmt = $this->pdoNrv->prepare("SELECT * FROM spectacle WHERE style = :style");
            $stmt->execute(['style' => $style]);
            $spectacles = $stmt->fetchAll();
            if (!$spectacles) {
                throw new RepositoryEntityNotFoundException('Aucun spectacle trouvé');
            }
        } catch (\PDOException $e) {
            throw new RepositoryDatabaseErrorException('Erreur lors de la récupération des spectacles', 0, $e);
        }
        $tabSpectacles = [];
        $tabArtistes = [];
        $tabImages = [];
        foreach ($spectacles as $spectacle) {
            $tabArtistes = $this->getArtistesBySpectacle($spectacle['id']);
            $tabImages = $this->getImagesBySpectacle($spectacle['id']);
            $spec = new Spectacle($spectacle['titre'], $tabArtistes, $spectacle['description'], $tabImages, $spectacle['url_video'], new DateTime($spectacle['horaire_previsionnel']), $spectacle['style']);
            $spec->setID($spectacle['id']);
            $tabSpectacles[] = $spec;
        }
        return $tabSpectacles;
    }

    /**
     * Méthode qui retourne la liste des artistes par spectacle
     * @param string $id
     * @return array
     * @throws \nrv\core\repositoryInterface\RepositoryDatabaseErrorException
     * @throws \nrv\core\repositoryInterface\RepositoryEntityNotFoundException
     */
    public function getArtistesBySpectacle(string $id): array
    {
        try {
            $stmt = $this->pdoNrv->prepare("SELECT * FROM artiste INNER JOIN artiste_spectacle ON artiste.id = id_artiste INNER JOIN spectacle ON id_spectacle = spectacle.id WHERE spectacle.id = :id");
            $stmt->execute(['id' => $id]);
            $artistes = $stmt->fetchAll();
            if (!$artistes) {
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
     * @throws \nrv\core\repositoryInterface\RepositoryEntityNotFoundException
     * @throws \nrv\core\repositoryInterface\RepositoryDatabaseErrorException
     * @return array
     */
    public function getImagesBySpectacle(string $id): array
    {
        try {
            $stmt = $this->pdoNrv->prepare("SELECT lien FROM image_spectacle WHERE spectacle_id = :id");
            $stmt->execute(['id' => $id]);
            $images = $stmt->fetchAll();
        } catch (\PDOException $e) {
            throw new RepositoryDatabaseErrorException('Erreur lors de la récupération des images', 0, $e);
        }
        return $images;
    }

    /**
     * Méthode qui retourne une soirée par son ID
     * @param string $id
     * @throws \nrv\core\repositoryInterface\RepositoryEntityNotFoundException
     * @throws \nrv\core\repositoryInterface\RepositoryDatabaseErrorException
     * @return Soiree
     */
    public function getSoireeById(string $id): Soiree
    {
        try {
            $stmt = $this->pdoNrv->prepare("SELECT * FROM soiree WHERE id = :id");
            $stmt->execute(['id' => $id]);
            $soiree = $stmt->fetch();
            if (!$soiree) {
                throw new RepositoryEntityNotFoundException('Aucune soirée trouvée');
            }
        } catch (\PDOException $e) {
            throw new RepositoryDatabaseErrorException('Erreur lors de la récupération de la soirée', 0, $e);
        }
        $soireeObj = new Soiree($soiree['nom'], $soiree['thematique'], new DateTime($soiree['date_heure']), $this->getLieuById($soiree['lieu_id']), $this->getSpectaclesBySoireeId($soiree['id']), $soiree['tarif_normal'], $soiree['tarif_reduit']);
        $soireeObj->setID($soiree['id']);
        return $soireeObj;
    }

    /**
     * Méthode qui retourne le lieu de la soirée par son ID
     * @throws \nrv\core\repositoryInterface\RepositoryEntityNotFoundException
     * @throws \nrv\core\repositoryInterface\RepositoryDatabaseErrorException
     * @return LieuxSpectacle
     */
    public function getLieuById(string $id): LieuxSpectacle
    {
        try {
            $stmt = $this->pdoNrv->prepare("SELECT * FROM lieu WHERE id = :id");
            $stmt->execute(['id' => $id]);
            $lieu = $stmt->fetch();
            if (!$lieu) {
                throw new RepositoryEntityNotFoundException('Aucun lieu trouvé');
            }
        } catch (\PDOException $e) {
            throw new RepositoryDatabaseErrorException('Erreur lors de la récupération du lieu', 0, $e);
        }

        $lieuObj = new LieuxSpectacle($lieu['nom'], $lieu['adresse'], $lieu['nb_places_assises'], $lieu['nb_places_debout'], $this->getImagesByLieu($lieu['id']));
        $lieuObj->setID($lieu['id']);
        return $lieuObj;
    }

    /**
     * Méthode qui retourne la liste des images par lieu
     * @param string $id
     * @throws \nrv\core\repositoryInterface\RepositoryDatabaseErrorException
     * @return array
     */
    public function getImagesByLieu(string $id): array
    {
        try {
            $stmt = $this->pdoNrv->prepare("SELECT lien FROM image_lieu WHERE lieu_id = :id");
            $stmt->execute(['id' => $id]);
            $images = $stmt->fetchAll();
        } catch (\PDOException $e) {
            throw new RepositoryDatabaseErrorException('Erreur lors de la récupération des images', 0, $e);
        }
        return $images;
    }

    /**
     * Méthode qui retourne la liste des spectacles par soirée
     * @param string $id
     * @throws \nrv\core\repositoryInterface\RepositoryEntityNotFoundException
     * @throws \nrv\core\repositoryInterface\RepositoryDatabaseErrorException
     * @return array
     */
    public function getSpectaclesBySoireeId(string $id): array
    {
        try {
            $stmt = $this->pdoNrv->prepare("SELECT * FROM spectacle WHERE soiree_id = :id");
            $stmt->execute(['id' => $id]);
            $spectacles = $stmt->fetchAll();
        } catch (\PDOException $e) {
            throw new RepositoryDatabaseErrorException($e->getMessage(), 0, $e);
        }
        $tabSpectacles = [];
        $tabArtistes = [];
        $tabImages = [];
        foreach ($spectacles as $spectacle) {
            $tabArtistes = $this->getArtistesBySpectacle($spectacle['id']);
            $tabImages = $this->getImagesBySpectacle($spectacle['id']);
            $spec = new Spectacle($spectacle['titre'], $tabArtistes, $spectacle['description'], $tabImages, $spectacle['url_video'], new DateTime($spectacle['horaire_previsionnel']), $spectacle['style']);
            $spec->setID($spectacle['id']);
            $tabSpectacles[] = $spec;
        }
        return $tabSpectacles;
    }

    /**
     * Méthode qui retourne la soirée par spectacle
     * @param string $id
     * @throws \nrv\core\repositoryInterface\RepositoryEntityNotFoundException
     * @throws \nrv\core\repositoryInterface\RepositoryDatabaseErrorException
     * @return Soiree
     */
    public function getSoireeBySpectacleId(string $id): Soiree
    {
        try {
            $stmt = $this->pdoNrv->prepare("SELECT * FROM soiree INNER JOIN spectacle ON soiree.id = spectacle.soiree_id WHERE spectacle.id = :id");
            $stmt->execute(['id' => $id]);
            $soiree = $stmt->fetch();
            if (!$soiree) {
                throw new RepositoryEntityNotFoundException('Aucune soirée trouvée');
            }
        } catch (\PDOException $e) {
            throw new RepositoryDatabaseErrorException('Erreur lors de la récupération de la soirée', 0, $e);
        }
        $soireeObj = new Soiree($soiree['nom'], $soiree['thematique'], new DateTime($soiree['date_heure']), $this->getLieuById($soiree['lieu_id']), $this->getSpectaclesBySoireeId($soiree['id']), $soiree['tarif_normal'], $soiree['tarif_reduit']);
        $soireeObj->setID($soiree['soiree_id']);
        return $soireeObj;
    }
}
