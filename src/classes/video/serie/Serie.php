<?php

namespace iutnc\netvod\video\serie;

use DateTime;
use DateTimeZone;
use iutnc\netvod\exception\ExceptionPasNote;
use iutnc\netvod\video\episode\Episode;
use iutnc\netvod\repository\Repository;

class Serie {
    private string $titre;
    private int $annee;
    private DateTime $dateAjout;
    private array $genre;
    private array $typePublic;
    private String $descriptif; 
    private int $nbEpisode;
    private array $liste;
    private string $cheminImage;
    private int $id;

    public function __construct(string $titre,  string $descriptif, int $annee, DateTime $dateAjout, string $cheminImage, $id = null) {
        $this->titre = $titre;
        $this->genre = [];
        $this->typePublic = [];
        $this->descriptif = $descriptif;
        $this->annee = $annee;
        $this->dateAjout = $dateAjout;
        $this->nbEpisode = 0;
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

    public function setGenres(array $genres): void {
        $this->genre = $genres;
    }

    public function setTypePublic(array $typePublic): void {
        $this->typePublic = $typePublic;
    }

    public function getNoteMoyenne():float{
        //recupération de la note moyenne de la serie dans la bd
        $instance = Repository::getInstance();
        $prepare = $instance->getPDO()->prepare("SELECT ROUND(AVG(note),2) as moy FROM avisserie WHERE serie_id=?");
        $prepare->bindValue(1,$this->id);
        $prepare->execute();
        $res = $prepare->fetch();
        if(is_null($res['moy'])){
            throw new ExceptionPasNote();
        }
        return $res['moy'];
    }


    // date("Y-m-d H:i:s");
}