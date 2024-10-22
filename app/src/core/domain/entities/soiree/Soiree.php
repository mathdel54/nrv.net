<?php 

namespace nrv\core\domain\entities\soiree;

use DateTime;
use nrv\core\domain\entities\Entity;
use nrv\core\domain\entities\spectacle\LieuxSpectacle;
use nrv\core\dto\soiree\SoireeDTO;
use nrv\core\domain\entities\spectacle\Spectacle;

class Soiree extends Entity {

    protected string $nom;
    protected string $theme;
    protected DateTime $horaire;
    protected LieuxSpectacle $lieu;
    protected array $spectacles;

    public function __construct(string $nom, string $theme, DateTime $horaire, LieuxSpectacle $lieu, array $spectacles) {
        $this->nom = $nom;
        $this->theme = $theme;
        $this->horaire = $horaire;
        $this->lieu = $lieu;
        $this->spectacles = $spectacles;
    }

    public function toDTO(): SoireeDTO {
        return new SoireeDTO($this->ID, $this->nom, $this->theme, $this->horaire, $this->lieu->toDTO());
    }
}