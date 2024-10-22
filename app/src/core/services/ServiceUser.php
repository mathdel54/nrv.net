<?php

namespace nrv\core\services;

use nrv\core\repositoryInterface\NrvRepositoryInterface;
use nrv\core\dto\spectacle\SpectacleDTO;

class ServiceUser implements ServiceUserInterface {

    private NrvRepositoryInterface $_spectacleRepository;

    public function __construct(NrvRepositoryInterface $spectacleRepository) {
        $this->_spectacleRepository = $spectacleRepository;
    }

    /**
     * Méthode qui retourne la liste des spectacles
     * @return array liste des spectacles en DTO
     */
    public function getSpectacles(): array {
        $spectacles = $this->_spectacleRepository->getSpectacles();
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
        $spectacle = $this->_spectacleRepository->getSpectacleById($id);
        return $spectacle->toDTO();
    }

    /**
     * Méthode qui retourne la liste des spectacles par date
     * @param string $date
     * @return array liste des spectacles en DTO
     */
    public function getSpectaclesByDate(string $date): array {
        $spectacles = $this->_spectacleRepository->getSpectaclesByDate($date);
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
        $spectacles = $this->_spectacleRepository->getSpectaclesByStyle($style);
        $spectaclesDTO = [];
        foreach($spectacles as $spectacle){
            $spectaclesDTO[] = $spectacle->toDTO();
        }
        return $spectaclesDTO;
    }
}