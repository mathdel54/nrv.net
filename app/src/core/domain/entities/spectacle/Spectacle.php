<?php

namespace nrv\core\domain\entities\spectacle;

use DateTime;
use nrv\core\domain\entities\Entity;
use nrv\core\dto\spectacle\SpectacleDTO;

class Spectacle extends Entity {

    protected string $titre;
    protected DateTime $date;
    protected string $image;

    public function __construct(string $titre, DateTime $date, string $image) {
        $this->titre = $titre;
        $this->date = $date;
        $this->image = $image;
    }

    public function toDTO() : SpectacleDTO {
        return new SpectacleDTO($this->ID, $this->titre, $this->date, $this->image);
    }
}