<?php

namespace iutnc\netvod\action;

use iutnc\netvod\avis\Avis;
use iutnc\netvod\avis\RendererAvis;

class Action_displayAvis extends Action
{
    private string $typeAvis;
    public static string $TYPE_SERIE = 'serie';
    public static string $TYPE_EPISODE = 'episode';

    public function __construct(string $typeAvis){
        parent::__construct();
        $this->typeAvis = $typeAvis;
    }

    public function execute(): string
    {
        if($this->typeAvis === self::$TYPE_SERIE){
            $listAvis = Avis::getAvisSerie($_SESSION['selected_serie']->id);
        }else{
            $listAvis = Avis::getAvisVideo($_SESSION['selected_episode']->numero);
        }


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