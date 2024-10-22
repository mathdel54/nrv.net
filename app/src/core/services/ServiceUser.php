<?php

namespace nrv\core\services;

use nrv\core\repositoryInterface\NrvRepositoryInterface;
use nrv\core\dto\spectacle\SpectacleDTO;
use nrv\core\dto\soiree\SoireeDTO;

class ServiceUser implements ServiceUserInterface {

    private NrvRepositoryInterface $_nrvRepository;

    public function __construct(NrvRepositoryInterface $nrvRepository) {
        $this->_nrvRepository = $nrvRepository;
    }

    /**
     * Méthode qui retourne la liste des spectacles
     * @return array liste des spectacles en DTO
     */
    public function getSpectacles(): array {
        $spectacles = $this->_nrvRepository->getSpectacles();
        $spectaclesDTO = [];
        foreach($spectacles as $spectacle){
            $spectaclesDTO[] = $spectacle->toDTO();
        }
        return $spectaclesDTO;
    }

    /**
     * Méthode qui retourne un spectacle par son ID
     * @param string $id du spectacle
     * @return SpectacleDTO le spectacle en DTO
     */
    public function getSpectacleById(string $id): SpectacleDTO {
        $spectacle = $this->_nrvRepository->getSpectacleById($id);
        return $spectacle->toDTO();
    }

    /**
     * Méthode qui retourne la liste des spectacles par date
     * @param string $date
     * @return array liste des spectacles en DTO
     */
    public function getSpectaclesByDate(string $date): array {
        $spectacles = $this->_nrvRepository->getSpectaclesByDate($date);
        $spectaclesDTO = [];
        foreach($spectacles as $spectacle){
            $spectaclesDTO[] = $spectacle->toDTO();
        }
        return $spectaclesDTO;
    }

    /**
     * Méthode qui retourne la liste des spectacles par style
     * @param string $style
     * @return array liste des spectacles en DTO
     */
    public function getSpectaclesByStyle(string $style): array {
        $spectacles = $this->_nrvRepository->getSpectaclesByStyle($style);
        $spectaclesDTO = [];
        foreach($spectacles as $spectacle){
            $spectaclesDTO[] = $spectacle->toDTO();
        }
        return $spectaclesDTO;
    }

    /**
     * Méthode qui retourne la liste des artistes par spectacle
     * @param string $id du spectacle
     * @return array liste des artistes
     */
    public function getArtistesBySpectacle(string $id): array {
        return $this->_nrvRepository->getArtistesBySpectacle($id);
    }

    /**
     * Méthode qui retourne la liste des images par spectacle
     * @param string $id du spectacle
     * @return array liste des images
     */
    public function getImagesBySpectacle(string $id): array {
        return $this->_nrvRepository->getImagesBySpectacle($id);
    }
}