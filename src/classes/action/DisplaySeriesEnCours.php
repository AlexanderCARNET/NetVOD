<?php

namespace iutnc\netvod\action;

class DisplaySeriesEnCours extends Action
{
    public function execute(): string
    {
        if(isset($_GET['id'])){
            if(isset($_SESSION['enCours'])){
                $liste=$_SESSION['enCours'];
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
        $res="<form method='GET'>";
        if(isset($_SESSION['enCours'])){
            $res.="<section><div class='en-cours'><h2>En Cours:</h2></div><div class='series'>";
            $enCours=$_SESSION['enCours'];
            $ep=$enCours->__get('enCours');
            $series=$enCours->__get('series');
            foreach ($series as $serie){
                $res.="<div><h2>{$serie->__get('titre')}</h2><a href='?action=afficher-episode&Serie={$serie->__get('titre')}&id={$ep[$serie->__get('titre')]}'><img src='{$serie->__get('cheminImage')}' alt='{$serie->__get('titre')}'></a></div>";
            }
        }
        return $res."</div></section>";
    }
}