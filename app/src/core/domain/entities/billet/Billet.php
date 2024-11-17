<?php

namespace nrv\core\domain\entities\billet;

use DateTime;
use nrv\core\domain\entities\Entity;
use nrv\core\domain\entities\soiree\Soiree;
use nrv\core\dto\billet\BilletDTO;

class Billet extends Entity {

    protected string $user;
    protected string $tarif;
    protected ?DateTime $date;
    protected Soiree $soiree;

    public function __construct(string $user, string $tarif, ?DateTime $date, Soiree $soiree){
        $this->user = $user;
        $this->tarif = $tarif;
        $this->date = $date;
        $this->soiree = $soiree;
    }

    public function toDTO(){
        return new BilletDTO($this->ID, $this->user, $this->tarif, $this->date, $this->soiree);
    }
}