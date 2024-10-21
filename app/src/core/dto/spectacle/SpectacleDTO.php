<?php

namespace nrv\core\dto\spectacle;

use nrv\core\dto\DTO;
use DateTime;

class SpectacleDTO extends DTO {
    protected string $ID;
    protected string $titre;
    protected array $artistes;
    protected string $description;
    protected array $images;
    protected string $video;
    protected DateTime $horaire;

    public function __construct(string $ID, string $titre, array $artistes, string $description, array $images, string $video, DateTime $horaire) {
        $this->ID = $ID;
        $this->titre = $titre;
        $this->artistes = $artistes;
        $this->description = $description;
        $this->images = $images;
        $this->video = $video;
        $this->horaire = $horaire;
    }
}