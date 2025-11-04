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
     * @param string $at
     * @return mixed
     */
    public function __get(string $at): mixed {
        if (property_exists($this, $at))
            return $this->$at;
        throw new InvalidName($at);
    }
}