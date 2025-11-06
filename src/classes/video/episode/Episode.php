<?php
namespace iutnc\netvod\video\episode;


class Episode {
    private int $numero;
    private string $titre;
    private int $duree;
    private string $fileNameImage;
    private string $fileNameVideo;
    private string $resume;

    public function __construct(int $numero, string $titre, int $duree, string $fileNameImage, string $fileNameVideo, string $resume) {
        $this->numero = $numero;
        $this->titre = $titre;
        $this->duree = $duree;
        $this->fileNameImage = $fileNameImage;
        $this->fileNameVideo = $fileNameVideo;
        $this->resume = $resume;
    }

    public function __get($property) {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
        throw new \Exception("Propriété inexistante: " . $property);
    }
}