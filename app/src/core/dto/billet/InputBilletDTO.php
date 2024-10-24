<?php

namespace nrv\core\dto\billet;

use nrv\core\dto\DTO;
use InvalidArgumentException;

class InputBilletDTO extends DTO {
    
        protected string $user;
        protected string $tarif;
        protected string $soiree;
    
        public function __construct(string $user, string $tarif, string $soiree){
            if (!is_string($user)) {
                throw new InvalidArgumentException("L'user doit être un UUID valide.");
            }

            if (!is_string($tarif) || !ctype_alnum($tarif)) {
                throw new InvalidArgumentException("Le tarif doit être une chaîne alphanumérique.");
            }

            if (!is_string($soiree)) {
                throw new InvalidArgumentException("L'id de la soirée doit être un UUID valide.");
            }

            $this->user = htmlspecialchars($user, ENT_QUOTES, 'UTF-8');
            $this->tarif = htmlspecialchars($tarif, ENT_QUOTES, 'UTF-8');
            $this->soiree = htmlspecialchars($soiree, ENT_QUOTES, 'UTF-8');
        }
}