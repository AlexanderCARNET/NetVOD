<?php
namespace iutnc\netvod\video\lists;

use iutnc\netvod\exception\InvalidName;
use iutnc\netvod\video\serie\Serie;

/**
 * Classe per le serie che sono in corso
 */
class EnCours extends SerieList
{
    //tableau qui enregistre l'épisode auquel nous sommes arrivés dans les séries
    private array $enCours=[];

    /**
     * Constructeur qui appelle le constructeur de la classe parente et prend comme paramètre
     * deux tableaux, un pour les séries et un pour le numéro de l'épisode en cours
     *
     * @param array $lists
     * @param array $enCours
     */
    public function __construct(array $lists, array $enCours){
        parent::__construct($lists);
        foreach ($lists as $serie){
            $titre = $serie->__get('titre');
            //Je vérifie que l'information se trouve dans le tableau de l'épisode auquel nous sommes de la série
            if(isset($enCours[$titre])){
                $this->enCours[$titre] = $enCours[$titre];
            }
            else{
                $this->enCours[$titre] = 1;
            }
        }
    }

    /**
     * Méthode pour insérer/mettre à jour l'information de l'épisode dans lequel on se trouve dans la série passée en paramètre,
     * toujours si elle est présente dans la liste des séries au cas où elle l'ajoute
     *
     * @param Serie $serie
     * @param int $n
     * @return void
     */
    public function setEnCoursSerie(Serie $serie, int $n):void{
        foreach ($this->series as $s){
            if($s==$serie){
                $titre = $s->__get('titre');
                if($n>0)
                    $this->enCours[$titre]=$n;
                else
                    $this->enCours[$titre]=1;
                return;
            }
        }
        $this->addSerieEnCours($serie, $n);
        //throw new ...;
    }

    /**
     * Méthode qui augmente la valeur à l'intérieur du tableau des épisodes en cours
     *
     * @param Serie $serie
     * @return void
     */
    public function incrementEnCoursSerie(Serie $serie): void {
        $titre = $serie->__get('titre');
        if (isset($this->enCours[$titre])) {
            $this->enCours[$titre]++;
        }
    }

    /**
     * Méthode pour ajouter une série à la liste et l'épisode dans lequel elle/il se trouve
     *
     * @param Serie $serie
     * @param int|null $n
     * @return void
     */
    public function addSerieEnCours(Serie $serie, ?int $n):void{
        $this->addSerie($serie);
        $titre = $serie->__get('titre');
        if($n!=null)
            $this->enCours[$titre]=$n;
        else
            $this->enCours[$titre]=1;
    }

    /**
     * Méthode pour supprimer une série et les informations des épisodes
     *
     * @param Serie $serie
     * @return void
     */
    public function delSerieEnCours(Serie $serie):void{
        $this->delSerie($serie);
        unset($this->enCours[$serie->__get('titre')]);
    }

    /**
     * Méthode pour vérifier si la série est terminée ou non
     *
     * @param Serie $serie
     * @return bool
     */
    public function verifierFinSerie(Serie $serie):bool{
        foreach ($this->series as $s){
            if($s==$serie)
                if($s->__get('nbEpisode')==$this->enCours[$s->__get('titre')]){
                    return true;
                }
        }
        return false;
    }

    /**
     * Méthode pour obtenir l'épisode où nous nous sommes arrêtés dans la série précédente par paramètre
     *
     * @param Serie $serie
     * @return int
     */
    public function getEnCoursSerie(Serie $serie):int{
        foreach ($this->series as $s){
            if($s == $serie){
                $episodes=$serie->__get('liste');
                $pos_ep=1;
                $titre = $s->__get('titre');
                foreach ($episodes as $ep){
                    if($pos_ep==$this->enCours[$titre]){
                        return $ep->__get('numero');
                    }
                    $pos_ep++;
                }
            }
        }
        return 0;
    }

    /**
     * Magic get
     * @param string $at
     * @return mixed
     */
    public function __get(string $at): mixed {
        if (property_exists ($this, $at))
            return $this->$at;
        throw new InvalidName("La variable $at est inexistant.");
    }
}