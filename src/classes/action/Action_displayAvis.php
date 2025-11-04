<?php

namespace iutnc\netvod\action;

use iutnc\netvod\avis\Avis;
use iutnc\netvod\repository\Repository;
use iutnc\netvod\avis\RendererAvis;

class Action_displayAvis extends Action
{

    public function execute(): string
    {
        //init de test -------------------------------------------
        $_SESSION['id_serie'] = 2;


        $listAvis = [];
        //recuperation de tous les avis de la bd
        $instance = Repository::getInstance();
        $prepare = $instance->getPDO()->prepare("select email, commentaire, note from avis inner join user on user.id = avis.id_user where id_serie=? ");
        $prepare->bindParam(1,$_SESSION['id_serie']);
        $prepare->execute();
        while($row = $prepare->fetch()){
            $avis = new Avis($row["email"],$row["commentaire"],$row["note"]);
            array_push($listAvis,$avis);
        }

        //concatenation de tout
        $res = "";
        foreach($listAvis as $avis){
            $renderer = new RendererAvis($avis);
            $res .= $renderer->render();
        }
        return $res;
    }
}