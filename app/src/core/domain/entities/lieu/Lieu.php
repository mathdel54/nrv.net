<?php

namespace nrv\core\domain\entities\lieu;

use nrv\core\domain\entities\Entity;
use nrv\core\dto\lieu\LieuDTO;

class Lieu extends Entity
{

    protected string $nom;
    protected string $adresse;
    protected string $ville;
    protected string $nb_places_assises;
    protected string $nb_places_debout;

    /**
     * @param string $ville
     * @param string $adresse
     * @param string $nom
     * @param string $nb_places_debout
     * @param string $nb_places_assises
     */
    public function __construct(string $ville, string $adresse, string $nom, string $nb_places_debout, string $nb_places_assises)
    {
        $this->ville = $ville;
        $this->adresse = $adresse;
        $this->nom = $nom;
        $this->nb_places_debout = $nb_places_debout;
        $this->nb_places_assises = $nb_places_assises;
    }

    public function toDTO(): LieuDTO
    {
        return new LieuDTO($this->ID, $this->nom, $this->adresse, $this->ville, $this->nb_places_assises, $this->nb_places_debout);
    }

}