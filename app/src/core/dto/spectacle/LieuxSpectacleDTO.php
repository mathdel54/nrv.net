<?php

namespace nrv\core\dto\spectacle;

use nrv\core\dto\DTO;

class LieuxSpectacleDTO extends DTO {
    protected string $ID;
    protected string $nom;
    protected string $adresse;
    protected int $placesAssises;
    protected int $placesDebout;
    protected array $images;

    public function __construct(string $ID, string $nom, string $adresse, int $placesAssises, int $placesDebout, array $images) {
        $this->ID = $ID;
        $this->nom = $nom;
        $this->adresse = $adresse;
        $this->placesAssises = $placesAssises;
        $this->placesDebout = $placesDebout;
        $this->images = $images;
    }
}