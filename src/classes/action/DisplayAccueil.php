<?php

namespace iutnc\netvod\action;

class DisplayAccueil extends Action
{
    public function execute(): string
    {
        if(isset($_GET['id'])){
            if(isset($_SESSION['preferences'])){
                $liste=$_SESSION['preferences'];
                foreach ($liste as $serie){
                    if($serie->__get('id') == $_GET['id']){
                        $_SESSION['serie']=$serie;
                    }
                }
            }
        }
        return $this->form();
    }

    public function form():string{
        $res="<form method='GET'><h1>Welcome in NetVOD</h1><p>Regarde tes séries et tes films sans limites et sans publicité avec NetVOD.</p>";
        if(isset($_SESSION['preferences'])){
            $res.="<section><div class='titre-preferences'><h2>Mes Preferences</h2></div><div class='series'>";
            $series=$_SESSION['preferences']->__get('series');
            foreach ($series as $serie){
                $res.="<div><h2>{$serie->__get('titre')}</h2><a href='?action=afficher-serie&id={$serie->__get('id')}'><img src='{$serie->__get('cheminImage')}' alt='{$serie->__get('titre')}'></a></div>";
            }
            $series=$_SESSION['dejaVisionnees']->__get('series');
            foreach ($series as $serie){
                $res.="<div><h2>{$serie->__get('titre')}</h2><a href='?action=afficher-serie&id={$serie->__get('id')}'><img src='{$serie->__get('cheminImage')}' alt='{$serie->__get('titre')}'></a></div>";
            }
        }
        return $res."</div></section>";
    }

}