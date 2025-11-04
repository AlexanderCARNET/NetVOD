<?php
namespace iutnc\netvod\video\episode;


class Episode {
    private int $numero;
    private string $titre;
    private int $duree;
    private string $fileNameImage;

    public function __construct(int $numero, string $titre, int $duree, string $fileNameImage) {
        $this->numero = $numero;
        $this->titre = $titre;
        $this->duree = $duree;
        $this->fileNameImage = $fileNameImage;
    }

    public function __get($property) {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
        throw new \Exception("Propriété inexistante: " . $property);
    }
}