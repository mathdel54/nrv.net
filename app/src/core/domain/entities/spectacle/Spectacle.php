<?php

namespace nrv\core\domain\entities\spectacle;

use DateTime;
use nrv\core\domain\entities\artiste\Artiste;
use nrv\core\domain\entities\Entity;
use nrv\core\dto\spectacle\SpectacleDTO;

class Spectacle extends Entity
{

    protected string $titre;
    protected array $artistes;
    protected string $description;
    protected array $images;
    protected string $video;
    protected DateTime $horaire;

    public function __construct(string $titre, array $artistes, string $description, array $images, string $video, DateTime $horaire)
    {
        $this->titre = $titre;
        $this->artistes = $artistes;
        $this->description = $description;
        $this->images = $images;
        $this->video = $video;
        $this->horaire = $horaire;
    }

    public function toDTO(): SpectacleDTO
    {
        return new SpectacleDTO($this->ID, $this->titre, Artiste::arrayArtisteToDTO($this->artistes), $this->description, $this->images, $this->video, $this->horaire);
    }

    public static function arraySpectacleToDTO(array $spectacles): array
    {
        $spectaclesDTO = [];
        foreach ($spectacles as $spectacle) {
            $spectaclesDTO[] = $spectacle->toDTO();
        }
        return $spectaclesDTO;
    }
}
