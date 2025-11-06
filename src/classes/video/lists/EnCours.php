<?php
namespace iutnc\netvod\video\lists;

/**
 *
 */
class EnCours extends SerieList
{
    private array $enCours=[];

    /**
     * @param array $lists
     * @param array $enCours
     */
    public function __construct(array $lists, array $enCours){
        parent::__construct($lists);
        foreach ($lists as $serie){
            if(!empty($enCours[$serie->__get('titre')])){
                $this->enCours[$serie->get('titre')]=$enCours[$serie->__get('titre')];
            }
            else{
                $this->enCours[$serie->__get('titre')]=1;
            }
        }
    }

    /**
     * @param Serie $serie
     * @param int $n
     * @return void
     */
    public function setEnCoursSerie(Serie $serie, int $n):void{
        foreach ($this->series as $s){
            if($s==$serie){
                $this->enCours[$s->__get('titre')]=$n;
                return;
            }
        }
    }

    /**
     * @param Serie $serie
     * @return void
     */
    public function incrementEnCoursSerie(Serie $serie):void{
        foreach ($this->enCours as $s){
            if($s==$serie){
                $this->enCours[$s->__get('titre')]++;
                return;
            }
        }
    }

    /**
     * @param Serie $serie
     * @param int|null $n
     * @return void
     */
    public function addSerieEnCours(Serie $serie, ?int $n):void{
        $this->addSerie($serie);
        $this->enCours[$serie->__get('titre')]=$n??1;
    }

    /**
     * @param Serie $serie
     * @return void
     */
    public function delSerieEnCours(Serie $serie):void{
        $this->delSerie($serie);
        unset($this->enCours[$serie->__get('titre')]);
    }

    /**
     * @param Serie $serie
     * @return bool
     */
    public function verifierFinSerie(Serie $serie):bool{
        foreach ($this->series as $s){
            if($s==$serie)
                if($s->__get('nb_episodes')==$this->enCours[$s->__get('titre')]){
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
                $titre = $s->__get('titre');
                if($this->enCours[$titre]!=null) {
                    return $this->enCours[$titre];
                }
            }
        }
        return 0;
    }

    /**
     * @param string $at
     * @return mixed
     */
    public function __get(string $at): mixed {
        if (property_exists ($this, $at))
            return $this->$at;
        throw new InvalidName("La variable $at est inexistant.");
    }
}