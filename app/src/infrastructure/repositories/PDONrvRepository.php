<?php

namespace nrv\infrastructure\repositories;

use DateTime;
use Ramsey\Uuid\Uuid;
use nrv\core\domain\entities\artiste\Artiste;
use nrv\core\domain\entities\lieu\Lieu;
use nrv\core\repositoryInterface\NrvRepositoryInterface;
use nrv\core\domain\entities\spectacle\Spectacle;
use nrv\core\repositoryInterface\RepositoryDatabaseErrorException;
use nrv\core\repositoryInterface\RepositoryEntityNotFoundException;
use nrv\core\domain\entities\soiree\Soiree;
use nrv\core\domain\entities\billet\Billet;
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
     * Méthode qui retourne la liste des lieux
     * @return array
     * @throws RepositoryDatabaseErrorException
     * @throws RepositoryEntityNotFoundException
     */
    public function getLieux(): array
    {
        try {
            $stmt = $this->pdoNrv->prepare("SELECT * FROM lieu");
            $stmt->execute();
            $lieus = $stmt->fetchAll();
            if (!$lieus) {
                throw new RepositoryEntityNotFoundException('Aucun lieu trouvé');
            }
        } catch (\PDOException $e) {
            throw new RepositoryDatabaseErrorException('Erreur lors de la récupération des lieus', 0, $e);
        }
        $tabLieus = [];
        foreach ($lieus as $lieu) {
            $lieuObj = new Lieu($lieu['ville'], $lieu['adresse'], $lieu['nom'], $lieu['nb_places_assises'], $lieu['nb_places_debout']);
            $lieuObj->setID($lieu['id']);
            $tabLieus[] = $lieuObj;
        }
        return $tabLieus;
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
    public function getSpectaclesByDate(string $date): array
    {
        try {
            $stmt = $this->pdoNrv->prepare("SELECT * FROM spectacle WHERE horaire_previsionnel::date = :date");
            $stmt->execute(['date' => $date]);
            $spectacles = $stmt->fetchAll();
            if (!$spectacles) {
                throw new RepositoryEntityNotFoundException('Aucun spectacle trouvé à la date du ' . $date);
            }
        } catch (\PDOException $e) {
            throw new RepositoryDatabaseErrorException('Erreur lors de la récupération des spectacles: ' . $e->getMessage());
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
            if (!$spectacles) {
                throw new RepositoryEntityNotFoundException('Aucun spectacle trouvé');
            }
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
        $soireeObj = new Soiree($soiree['nom'], $soiree['thematique'], new DateTime($soiree['date_heure']), $this->getLieuById($soiree['lieu_id']), $this->getSpectaclesBySoireeId($soiree['soiree_id']), $soiree['tarif_normal'], $soiree['tarif_reduit']);
        $soireeObj->setID($soiree['soiree_id']);
        return $soireeObj;
    }

    /**
     * Méthode qui retourne la liste des spectacles par style
     * @param string $style
     * @return array
     * @throws \nrv\core\repositoryInterface\RepositoryDatabaseErrorException
     * @throws \nrv\core\repositoryInterface\RepositoryEntityNotFoundException
     */
    public function getSpectacleByStyle(string $style): array
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
            $spec = new Spectacle($spectacle['titre'], $tabArtistes, $spectacle['description'], $tabImages, $spectacle['url_video'], new \DateTime($spectacle['horaire_previsionnel']), $spectacle['style']);
            $spec->setID($spectacle['id']);
            $tabSpectacles[] = $spec;
        }
        return $tabSpectacles;
    }

    /**
     * Méthode qui retourne la liste des spectacles par lieu
     * @param string $id
     * @throws \nrv\core\repositoryInterface\RepositoryEntityNotFoundException
     * @throws \nrv\core\repositoryInterface\RepositoryDatabaseErrorException
     * @return array
     */
    public function getSpectaclesByLieu(string $id): array
    {
        try {
            $stmt = $this->pdoNrv->prepare("SELECT * FROM spectacle INNER JOIN soiree ON soiree_id = soiree.id INNER JOIN lieu ON lieu_id = lieu.id WHERE lieu.id = :id");
            $stmt->execute(['id' => $id]);
            $spectacles = $stmt->fetchAll();
            if (!$spectacles) {
                throw new RepositoryEntityNotFoundException('Aucun spectacle trouvé');
            }
        } catch (\PDOException $e) {
            throw new RepositoryDatabaseErrorException($e->getMessage(), 0, $e);
        }
        $tabSpectacles = [];
        $tabArtistes = [];
        $tabImages = [];
        foreach ($spectacles as $spectacle) {
            $tabArtistes = $this->getArtistesBySpectacle($spectacle[0]);
            $tabImages = $this->getImagesBySpectacle($spectacle[0]);
            $spec = new Spectacle($spectacle['titre'], $tabArtistes, $spectacle['description'], $tabImages, $spectacle['url_video'], new \DateTime($spectacle['horaire_previsionnel']), $spectacle['style']);
            $spec->setID($spectacle[0]);
            $tabSpectacles[] = $spec;
        }
        return $tabSpectacles;
    }

    /**
     * Méthode qui retourne la liste des billets d'un utilisateur
     * @param string $id_user
     * @return array
     */
    public function getBilletsByUser(string $id_user): array {
        try {
            $stmt = $this->pdoNrv->prepare("SELECT * FROM billet WHERE utilisateur_id = :id_user");
            $stmt->execute(['id_user' => $id_user]);
            $billets = $stmt->fetchAll();
            if (!$billets) {
                throw new RepositoryEntityNotFoundException('Aucun billet trouvé pour cet utilisateur');
            }
        } catch (\PDOException $e) {
            throw new RepositoryDatabaseErrorException($e->getMessage(), 0, $e);
        }
        $tabBillets = [];
        foreach($billets as $billet){
            $b = new Billet($billet['utilisateur_id'], $billet['tarif'], new DateTime($billet['date_achat']), $billet['soiree_id']);
            $b->setID($billet['id']);
            $tabBillets[] = $b;
        }
        return $tabBillets;
    }

    /**
     * Méthode qui permet de créer un billet
     * @param string $user
     * @param string $tarif
     * @param DateTime $date
     * @param string $soiree
     * @return Billet
     */
    public function creerBillet(string $user, string $tarif, DateTime $date, string $soiree): Billet {
        try {
            $billet = new Billet($user, $tarif, $date, $soiree);
            $billet->setID(Uuid::uuid4()->toString());
            $stmt = $this->pdoNrv->prepare("INSERT INTO billet (id, utilisateur_id, tarif, date_achat, soiree_id) VALUES (:id, :user, :tarif, :date, :soiree)");
            $stmt->execute(['id' => $billet->ID ,'user' => $billet->user, 'tarif' => $billet->tarif, 'date' => $billet->date->format('Y-m-d H:i:s'), 'soiree' => $billet->soiree]);
        } catch (\PDOException $e) {
            throw new RepositoryDatabaseErrorException($e->getMessage(), 0, $e);
        }
        return $billet;
    }
}
