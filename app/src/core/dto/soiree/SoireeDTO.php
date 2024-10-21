<?php

namespace nrv\core\dto\soiree;

use nrv\core\dto\DTO;
use DateTime;
use nrv\core\dto\spectacle\LieuxSpectacleDTO;

class SoireeDTO extends DTO {

    protected string $ID;
    protected string $nom;
    protected string $theme;
    protected DateTime $horaire;
    protected LieuxSpectacleDTO $lieu;
    protected array $spectacles;

    public function __construct(string $ID, string $nom, string $theme, DateTime $horaire, LieuxSpectacleDTO $lieu, array $spectacles) {
        $this->ID = $ID;
        $this->nom = $nom;
        $this->theme = $theme;
        $this->horaire = $horaire;
        $this->lieu = $lieu;
        $this->spectacles = $spectacles;
    }
}