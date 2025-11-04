<?php

namespace iutnc\netvod\video\serie;

use iutnc\netvod\repository\Repository;

class Serie
{
    private int $id;

    public function __construct(int $id){
        $this->id = $id;
    }
    public function getNoteMoyenne():float{
        //recupération de la note moyenne de la serie dans la bd
        $instance = Repository::getInstance();
        $prepare = $instance->getPDO()->prepare("SELECT ROUND(AVG(note),2) as moy FROM avis WHERE id_serie=?");
        $prepare->bindValue(1,$this->id);
        $prepare->execute();
        $res = $prepare->fetch();
        return $res['moy'];
    }
}