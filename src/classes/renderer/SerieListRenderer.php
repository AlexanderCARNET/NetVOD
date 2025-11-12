<?php

namespace iutnc\netvod\renderer;

use iutnc\netvod\video\lists\EnCours;
use iutnc\netvod\video\lists\MesPreference;
use iutnc\netvod\video\lists\SerieList;

/**
 * Classe pour imprimer les informations de la liste de séries
 */
class SerieListRenderer implements Renderer
{
    //objet de type ListeSérie
    private SerieList $series;

    /**
     * @param SerieList $series
     */
    public function __construct(SerieList $series){
        $this->series=$series;
    }

    /**
     * Méthode qui retourne les informations à afficher à l'écran sur la liste des séries
     *
     * @param int|null $t
     * @return string
     * @throws \iutnc\netvod\exception\InvalidName
     */
    public function render(?int $t): string
    {
        $res="<table>";
        if($this->series instanceof EnCours){
            $res.="<h2>En Cours</h2>";
            $res.="<thead><th>Titre</th><th>Episode en cours</th><th>Episode total</th></thead>";
            foreach ($this->series->__get('series') as $serie){
                $res.="<tr><td>{$serie->__get('titre')}</td><td>{$this->series->getEnCoursSerie($serie)}</td><td>{$serie->__get('nb_episodes')}</td></tr>";
            }
        }
        else if($this->series instanceof MesPreference){
            $res.="<h2>Mes preferences</h2>";
            foreach ($this->series->__get('series') as $serie){
                $renderSerie = new SerieRenderer($serie);
                $res.="<tr>{$renderSerie->render(1)}</tr>";
            }
        }
        else{
            $res.="<h2>Deja Visionnees</h2>";
            foreach ($this->series->__get('series') as $serie){
                $renderSerie = new SerieRenderer($serie);
                $res.="<tr>{$renderSerie->render(1)}</tr>";
            }
        }
        return $res."</table>";
    }
}