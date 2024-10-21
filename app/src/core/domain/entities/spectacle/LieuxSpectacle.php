<?php

namespace nrv\core\domain\entities\spectacle;

use nrv\core\domain\entities\Entity;
use nrv\core\dto\spectacle\LieuxSpectacleDTO;

class LieuxSpectacle extends Entity {
    
    protected string $nom;
    protected string $adresse;
    protected int $placesAssises;
    protected int $placesDebout;
    protected array $images;

    public function __construct(string $nom, string $adresse, int $placesAssises, int $placesDebout, array $images) {
        $this->nom = $nom;
        $this->adresse = $adresse;
        $this->placesAssises = $placesAssises;
        $this->placesDebout = $placesDebout;
        $this->images = $images;
    }

    public function toDTO(){
        return new LieuxSpectacleDTO($this->ID, $this->nom, $this->adresse, $this->placesAssises, $this->placesDebout, $this->images);
    }
}