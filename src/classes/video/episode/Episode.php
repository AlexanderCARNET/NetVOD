<?php
namespace iutnc\netvod\video\episode;


class Episode {
    private int $numero;
    private string $titre;
    private int $duree;
    private string $fileNameImage;
    private string $fileNameVideo;
    private string $resume;
    private array $genres;
    private array $typePublic;

    public function __construct(int $numero, string $titre, int $duree, string $fileNameImage, string $fileNameVideo, string $resume) {
        $this->numero = $numero;
        $this->titre = $titre;
        $this->duree = $duree;
        $this->fileNameImage = $fileNameImage;
        $this->fileNameVideo = $fileNameVideo;
        $this->resume = $resume;
        $this->genres = [];
        $this->typePublic = [];
    }

    public function __get($property) {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
        throw new \Exception("Propriété inexistante: " . $property);
    }

    public function setGenres(array $genres): void {
        $this->genres = $genres;
    }

    public function setTypePublic(array $typePublic): void {
        $this->typePublic = $typePublic;
    }
}