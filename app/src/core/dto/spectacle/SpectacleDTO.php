<?php

namespace nrv\core\dto\spectacle;

use nrv\core\dto\DTO;
use DateTime;

class SpectacleDTO extends DTO {
    protected string $ID;
    protected string $titre;
    protected DateTime $date;
    protected string $image;

    public function __construct(string $ID, string $titre, DateTime $date, string $image)
    {
        $this->ID = $ID;
        $this->titre = $titre;
        $this->date = $date;
        $this->image = $image;
    }
}