<?php

namespace iutnc\netvod\action;

use iutnc\netvod\avis\Avis;
use iutnc\netvod\avis\RendererAvis;

class Action_displayAvis extends Action
{

    public function execute(): string
    {
        //init de test -------------------------------------------
        $_SESSION['id_serie'] = 2;


        $listAvis = Avis::getAvisSerie($_SESSION['id_serie']);

        //concatenation de tout
        $res = "<h2>Espace commentaires : </h2>";
        foreach($listAvis as $avis){
            $renderer = new RendererAvis($avis);
            $res .= $renderer->render();
        }
        return $res;
    }
}