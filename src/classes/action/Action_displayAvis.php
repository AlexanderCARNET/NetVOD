<?php

namespace iutnc\netvod\action;

use iutnc\netvod\avis\Avis;
use iutnc\netvod\avis\RendererAvis;
use iutnc\netvod\Tris\TriNote;
use iutnc\netvod\video\serie\Serie;

class Action_displayAvis extends Action
{

    public function execute(): string
    {

        $listAvis = Avis::getAvisSerie($_SESSION['selected_serie']->id);

        //concatenation de tout
     $res = "<div class='avis-section'><h2>Espace commentaires :</h2>";

foreach($listAvis as $avis) {
    $renderer = new RendererAvis($avis);
    $res .= "<div class='avis-card'>";
    $res .= $renderer->render();
    $res .= "</div>";
}

$res .= "</div>";
        return $res;
    }
}