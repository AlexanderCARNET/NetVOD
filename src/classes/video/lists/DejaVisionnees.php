<?php

namespace iutnc\netvod\video\lists;

/**
 *
 */
class DejaVisionnees extends SerieList
{
    /**
     * @param array $series
     */
    public function __construct(array $series)
    {
        parent::__construct($series);
    }

    /**
     * @param string $at
     * @return mixed
     */
    public function __get(string $at): mixed {
        if (property_exists ($this, $at))
            return $this->$at;
        throw new InvalidName($at);
    }
}