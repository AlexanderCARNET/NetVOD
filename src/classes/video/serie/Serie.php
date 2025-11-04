<?php

namespace iutnc\netvod\video\serie;

class Serie {
    private String $genre;
    private String $typePublic;
    private Array $liste;
    private String $titre;
    private String $descriptif; 
    private int $annee;
    private String $dateAjout;
    private int $nbEpisode;
    private String $cheminImage;

    public function __construct(String $genre, String $typePublic, Array $liste, String $titre, String $descriptif, int $annee, String $dateAjout, int $nbEpisode, String $cheminImage) {
        $this->genre = $genre;
        $this->typePublic = $typePublic;
        $this->liste = $liste;
        $this->titre = $titre;
        $this->descriptif = $descriptif;
        $this->annee = $annee;
        $this->dateAjout = $dateAjout;
        $this->nbEpisode = $nbEpisode;
        $this->cheminImage = $cheminImage;
    }

    public function __get($property) {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
        throw new \Exception("Propriété inexistante: " . $property);
    }

    public function addEpisode($episode) {
        $this->liste[] = $episode;
        $this->nbEpisode = count($this->liste);
    }

}