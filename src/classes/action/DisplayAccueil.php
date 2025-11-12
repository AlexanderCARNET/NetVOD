<?php

namespace iutnc\netvod\action;

use iutnc\netvod\renderer\Renderer;
use iutnc\netvod\renderer\SerieRender;
use iutnc\netvod\repository\Repository;

class DisplayAccueil extends Action
{
    public function execute(): string
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ?action=signin');
            exit();
        }

        return $this->form();
    }

    public function form():string{
        $res="<form method='GET'><h1>Bienvenue sur NetVOD</h1>";
        if(!isset($_SESSION['user']))
            $res.="<p>Regarde tes séries et tes films sans limites et sans publicité avec NetVOD.</p>";
        if(isset($_SESSION['preferences'])) {
            $res .= "<section><div class='titre-preferences'><h2>Mes Preferences</h2>";
            $series = $_SESSION['preferences']->__get('series');
            if(!empty($series))
                foreach ($series as $serie) {
                    $render = new SerieRender($serie);
                    $res .= "<div>{$render->render(Renderer::COMPACT)}</div>";
                }
            else{
                $res.="<h3>Aucun serie est present dont la liste.</h3>";
            }
            $res.="</div>";
        }
        if(isset($_SESSION['enCours'])) {
            $res .= "<section><div class='titre-enCours'><h2>En Cours</h2>";
            $series = $_SESSION['enCours']->__get('series');
            $enCours = $_SESSION['enCours'];
            if(!empty($series))
                foreach ($series as $serie) {
                    $res .= "<div class='serie-compact'>
                <a href='?action=display-episode&id_episode=" . $enCours->getEnCoursSerie($serie) . "'>
                    <h3>" . htmlspecialchars($serie->__get('titre')) . "</h3>
                    <img src='" . htmlspecialchars($serie->__get('cheminImage')) . "' alt='Image de la série'>
                </a>
            </div>";
                }
            else{
                $res.="<h3>Aucun serie est present dont la liste.</h3>";
            }
            $res.="</div>";
        }
        if(isset($_SESSION['dejaVisionnees'])) {
            $res .= "<section><div class='titre-dejaVisionnees'><h2>Deja Visionnees</h2>";
            $series = $_SESSION['dejaVisionnees']->__get('series');
            if(!empty($series))
                foreach ($series as $serie) {
                    $render = new SerieRender($serie);
                    $res .= "<div>{$render->render(Renderer::COMPACT)}</div>";
                }
            else{
                $res.="<h3>Aucun serie est present dont la liste.</h>";
            }
            $res.="</div>";
        }
        $res.="<div class='catalogue'><h2>Catalogue</h2>";
        $repo = Repository::getInstance();
        $series_total = $repo->getAllSeriesCompact();
        foreach ($series_total as $serie) {
            $render = new SerieRender($serie);
            $res .= $render->render(Renderer::COMPACT);
        }
        return $res."</div></section>";
    }

}