<?php
namespace iutnc\netvod\video\lists;

/**
 *
 */
class MesPreference extends SerieList
{
    /**
     * @param array $lists
     */
    public function __construct(array $lists){
        parent::__construct($lists);
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