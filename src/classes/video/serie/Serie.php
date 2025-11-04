<?php

namespace iutnc\netvod\video\serie;

use DateTime;
use DateTimeZone;
use iutnc\netvod\video\episode\Episode;

class Serie {
    private String $genre;
    private String $typePublic;
    private array $liste;
    private String $titre;
    private String $descriptif; 
    private int $annee;
    private DateTime $dateAjout;
    private int $nbEpisode;
    private String $cheminImage;
    private $id;

    public function __construct(String $genre, String $typePublic, String $titre, String $descriptif, int $annee, int $nbEpisode, String $cheminImage, $id = null) {
        $this->genre = $genre;
        $this->typePublic = $typePublic;
        // la liste d'épisode est vide par def
        $this->liste = [];
        $this->titre = $titre;
        $this->descriptif = $descriptif;
        $this->annee = $annee;
        $this->dateAjout = new DateTime("now", new DateTimeZone('Europe/Paris'));
        $this->nbEpisode = $nbEpisode;
        $this->cheminImage = $cheminImage;
        $this->id = $id;
    }

    public function __get($property) {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
        throw new \Exception("Propriété inexistante: " . $property);
    }

    public function addEpisode(Episode $episode) {
        if (!($episode instanceof Episode)) {
            throw new \Exception("L'objet fourni n'est pas une instance de Episode.");
        }
        $this->liste[] = $episode;
        $this->nbEpisode = count($this->liste);
    }

    public function setId($id): void {
        $this->id = $id;
    }


    // date("Y-m-d H:i:s");
}