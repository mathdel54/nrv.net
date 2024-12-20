<?php

namespace nrv\core\services\user;

use DateTime;
use nrv\core\dto\billet\InputBilletDTO;
use nrv\core\dto\spectacle\LieuxSpectacleDTO;
use nrv\core\repositoryInterface\NrvRepositoryInterface;
use nrv\core\dto\spectacle\SpectacleDTO;
use nrv\core\dto\soiree\SoireeDTO;
use nrv\core\dto\billet\BilletDTO;

class ServiceUser implements ServiceUserInterface
{

    private NrvRepositoryInterface $_nrvRepository;

    public function __construct(NrvRepositoryInterface $nrvRepository)
    {
        $this->_nrvRepository = $nrvRepository;
    }

    /**
     * Méthode qui retourne la liste des spectacles
     * @return array liste des spectacles en DTO
     */
    public function getSpectacles(): array
    {
        $spectacles = $this->_nrvRepository->getSpectacles();
        $spectaclesDTO = [];
        foreach ($spectacles as $spectacle) {
            $spectaclesDTO[] = $spectacle->toDTO();
        }
        return $spectaclesDTO;
    }

    /**
     * Méthode qui retourne la liste des artistes
     * @return array liste des artistes
     */
    public function getLieux(): array
    {
        $lieus = $this->_nrvRepository->getLieux();
        $lieusDTO = [];
        foreach ($lieus as $lieu) {
            $lieusDTO[] = $lieu->toDTO();
        }
        return $lieusDTO;
    }

    /**
     * Méthode qui retourne un spectacle par son ID
     * @param string $id du spectacle
     * @return SpectacleDTO le spectacle en DTO
     */
    public function getSpectacleById(string $id): SpectacleDTO
    {
        $spectacle = $this->_nrvRepository->getSpectacleById($id);
        return $spectacle->toDTO();
    }

    /**
     * Méthode qui retourne la liste des spectacles par date
     * @param string $date
     * @return array liste des spectacles en DTO
     */
    public function getSpectaclesByDate(string $date): array
    {
        $spectacles = $this->_nrvRepository->getSpectaclesByDate($date);
        $spectaclesDTO = [];
        foreach ($spectacles as $spectacle) {
            $spectaclesDTO[] = $spectacle->toDTO();
        }
        return $spectaclesDTO;
    }

    /**
     * Méthode qui retourne la liste des spectacles par style
     * @param string $style
     * @return array liste des spectacles en DTO
     */
    public function getSpectaclesByStyle(string $style): array
    {
        $spectacles = $this->_nrvRepository->getSpectaclesByStyle($style);
        $spectaclesDTO = [];
        foreach ($spectacles as $spectacle) {
            $spectaclesDTO[] = $spectacle->toDTO();
        }
        return $spectaclesDTO;
    }

    /**
     * Méthode qui retourne la liste des artistes par spectacle
     * @param string $id du spectacle
     * @return array liste des artistes
     */
    public function getArtistesBySpectacle(string $id): array
    {
        return $this->_nrvRepository->getArtistesBySpectacle($id);
    }

    /**
     * Méthode qui retourne la liste des images par spectacle
     * @param string $id du spectacle
     * @return array liste des images
     */
    public function getImagesBySpectacle(string $id): array
    {
        return $this->_nrvRepository->getImagesBySpectacle($id);
    }

    /**
     * Méthode qui retourne une soirée par son ID
     * @param string $id de la soirée
     * @return SoireeDTO la soirée en DTO
     */
    public function getSoireeById(string $id): SoireeDTO
    {
        $soiree = $this->_nrvRepository->getSoireeById($id);
        return $soiree->toDTO();
    }

    /**
     * Méthode qui retourne un lieu par son ID
     * @param string $id du lieu
     * @return array le lieu en DTO
     */
    public function getLieuById(string $id): LieuxSpectacleDTO
    {
        $lieu = $this->_nrvRepository->getLieuById($id);
        return $lieu->toDTO();
    }

    /**
     * Méthode qui retourne la liste des images par lieu
     * @param string $id du lieu
     * @return array liste des images
     */
    public function getImagesByLieu(string $id): array
    {
        return $this->_nrvRepository->getImagesByLieu($id);
    }

    /**
     * Méthode qui retourne la liste des spectacles par soirée
     * @param string $id de la soirée
     * @return array liste des spectacles en DTO
     */
    public function getSpectaclesBySoireeId(string $id): array
    {
        $spectacles = $this->_nrvRepository->getSpectaclesBySoireeId($id);
        $spectaclesDTO = [];
        foreach ($spectacles as $spectacle) {
            $spectaclesDTO[] = $spectacle->toDTO();
        }
        return $spectaclesDTO;
    }

    /**
     * Méthode qui retourne une soirée par son ID de spectacle
     * @param string $id du spectacle
     * @return SoireeDTO la soirée en DTO
     */
    public function getSoireeBySpectacleId(string $id): SoireeDTO
    {
        $soiree = $this->_nrvRepository->getSoireeBySpectacleId($id);
        return $soiree->toDTO();
    }

    /**
     * Méthode qui retourne la liste des spectacles par lieu
     * @param string $id
     * @return array
     */
    public function getSpectaclesByLieu(string $id): array
    {
        $spectacles = $this->_nrvRepository->getSpectaclesByLieu($id);
        $spectaclesDTO = [];
        foreach ($spectacles as $spectacle) {
            $spectaclesDTO[] = $spectacle->toDTO();
        }
        return $spectaclesDTO;
    }

    /**
     * Méthode qui retourne la liste des spectacles par style
     * @param string $style
     * @return array liste des spectacles en DTO
     */
    public function getSpectacleByStyle(string $style): array
    {
        $spectacles = $this->_nrvRepository->getSpectacleByStyle($style);
        $spectaclesDTO = [];
        foreach ($spectacles as $spectacle) {
            $spectaclesDTO[] = $spectacle->toDTO();
        }
        return $spectaclesDTO;
    }

    /**
     * Méthode qui retourne la liste des billets par utilisateur
     * @param string $id
     * @return array liste des billets en DTO
     */
    public function getBilletsByUser(string $id): array {
        $billets = $this->_nrvRepository->getBilletsByUser($id);
        $billetsDTO = [];
        foreach ($billets as $billet) {
            $billetsDTO[] = $billet->toDTO();
        }
        return $billetsDTO;
    }

    /**
     * Méthode qui permet d'acheter un billet
     * @param InputBilletDTO $inputBilletDTO
     * @return BilletDTO le billet en DTO
     */
    public function acheterBillet(InputBilletDTO $inputBilletDTO): BilletDTO {
        $billetDTO = $this->_nrvRepository->creerBillet($inputBilletDTO->user, $inputBilletDTO->tarif, $inputBilletDTO->soiree);
        return $billetDTO->toDTO();
    }

    /**
     * Méthode qui permet de mettre à jour un billet
     * @param string $id
     * @return BilletDTO le billet en DTO
     */
    public function updateBillet(string $id): BilletDTO {
        $billetDTO = $this->_nrvRepository->achatBillet($id);
        return $billetDTO->toDTO();
    }
}
