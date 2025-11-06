<?php
namespace iutnc\netvod\video\lists;

/**
 *
 */
abstract class SerieList
{
    //
    protected int $nb_series = 0;
    //
    protected array $series = [];

    /**
     * @param array $series
     */
    public function __construct(array $series){
        foreach ($series as $serie) {
            if($serie instanceof Serie){
            $this->series[] = $serie;
            $this->nb_series++;
            }
        }
    }

    /**
     * @param Serie $serie
     * @return void
     */
    public function addSerie(Serie $s):void{
        $res=true;
        foreach ($this->series as $serie)
            if($serie==$s){
                $res=false;
            }
        if($res){
            $this->series[]=$s;
            $this->nb_series++;
        }
    }

    /**
     * @param string $titre
     * @return void
     */
    public function delSerie(Serie $s): void
    {
        for($i=0; $i<$this->nb_series; $i++){
            if($this->series[$i]==$s){
                unset($this->series[$i]);
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
     * @param string $at
     * @return mixed
     */
    public function __get(string $at): mixed {
        if (property_exists($this, $at))
            return $this->$at;
        throw new InvalidName($at);
    }
}