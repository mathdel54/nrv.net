<?php

namespace nrv\core\dto\artiste;

use nrv\core\dto\DTO;

class ArtisteDTO extends DTO {

    protected string $ID;
    protected string $nom;

    public function __construct(string $ID, string $nom) {
        $this->ID = $ID;
        $this->nom = $nom;
    }
}