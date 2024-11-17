<?php

namespace nrv\core\dto\billet;

use nrv\core\domain\entities\soiree\Soiree;
use nrv\core\dto\DTO;
use DateTime;

class BilletDTO extends DTO {

    protected string $ID;
    protected string $user;
    protected string $tarif;
    protected ?DateTime $date;
    protected Soiree $soiree;

    public function __construct(string $ID, string $user, string $tarif, ?DateTime $date, Soiree $soiree){
        $this->ID = $ID;
        $this->user = $user;
        $this->tarif = $tarif;
        $this->date = $date;
        $this->soiree = $soiree;
    }
}