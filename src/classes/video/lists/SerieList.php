<?php
namespace iutnc\netvod\video\lists;

use iutnc\netvod\exception\InvalidName;
use iutnc\netvod\video\serie\Serie;

/**
 * Classe abstraite qui servira à la gestion de séries
 */
abstract class SerieList
{
    //numéro de série dans le tableau
    protected int $nb_series = 0;

    //tableau de séries
    protected array $series = [];

    /**
     * Constructeur qui prend comme paramètre un tableau et vérifie que le contenu est un objet de type Série
     *
     * @param array $series
     */
    public function __construct(array $series){
        foreach ($series as $serie) {
            //Je vérifie s'il s'agit d'un objet de la série
            if($serie instanceof Serie){
            $this->series[] = $serie;
            $this->nb_series++;
            }
        }
    }

    /**
     * Méthode pour ajouter à un tableau l'objet Série passé en paramètre
     *
     * @param Serie $serie
     * @return void
     */
    public function addSerie(Serie $s):void{
        $res=true;
        foreach ($this->series as $serie)
            //je vérifie si elle est déjà présente dans le tableau
            if($serie==$s){
                $res=false;
            }
        if($res){
            $this->series[]=$s;
            $this->nb_series++;
        }
    }

    /**
     * Méthode pour retirer d'un tableau une Série passée en paramètre
     *
     * @param string $titre
     * @return void
     */
    public function delSerie(Serie $s): void
    {
        for($i=0; $i<$this->nb_series; $i++){
            if($this->series[$i]==$s){
                //j'enlève la série
                unset($this->series[$i]);
                //Je réduis le nombre de séries présentes
                $this->nb_series--;
                return;
            }
        }
    }

    /**
     * Méthode pour vérifier si la série passée en paramètre est présente dans le tableau ou non
     *
     * @param Serie $serie
     * @return bool
     */
    public function verifierSerie(Serie $serie):bool{
        foreach ($this->series as $s){
            if($s == $serie){
                return true;
            }
        }
        return false;
    }

    /**
     * Magic get
     *
     * @param string $at
     * @return mixed
     */
    public function __get(string $at): mixed {
        if (property_exists($this, $at))
            return $this->$at;
        throw new InvalidName($at);
    }
}