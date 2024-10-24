<?php

namespace nrv\core\dto\lieu;

use nrv\core\dto\DTO;

class LieuDTO extends DTO
{

    protected string $ID;
    protected string $nom;
    protected string $adresse;
    protected string $ville;
    protected string $nb_places_assises;
    protected string $nb_places_debout;

    public function __construct(string $id, string $nom, string $adresse, string $ville, string $nb_places_assises, string $nb_places_debout)
    {
        $this->ID = $id;
        $this->nom = $nom;
        $this->adresse = $adresse;
        $this->ville = $ville;
        $this->nb_places_assises = $nb_places_assises;
        $this->nb_places_debout = $nb_places_debout;
    }
}