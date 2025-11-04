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
     * @param string $titre
     * @param int $n
     * @return void
     */
    public function setEnCoursSerie(string $titre, int $n):void{
        foreach ($this->series as $serie){
            if($serie->__get('titre')===$titre){
                $this->enCours[$serie->__get('titre')]=$n;
                return;
            }
        }
    }

    /**
     * @param string $titre
     * @return void
     */
    public function incrementEnCoursSerie(string $titre):void{
        foreach ($this->enCours as $serie){
            if($serie->__get('titre')===$titre){
                $this->enCours[$serie->__get('titre')]++;
                return;
            }
        }
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