<?php 

namespace nrv\core\domain\entities\artiste;

use nrv\core\domain\entities\Entity;
use nrv\core\dto\artiste\ArtisteDTO;

class Artiste extends Entity {

    protected string $nom;

    public function __construct(string $nom) {
        $this->nom = $nom;
    }

    public function toDTO(): ArtisteDTO {
        return new ArtisteDTO($this->ID, $this->nom);
    }

    public static function arrayArtisteToDTO(array $artistes): array {
        $artistesDTO = [];
        foreach ($artistes as $artiste) {
            $artistesDTO[] = $artiste->toDTO();
        }
        return $artistesDTO;
    }
}