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

    public function form(): string
    {
        $res = "<div class='accueil-container'>";
        $res .= "<h1>Bienvenue sur NetVOD</h1>";

        if (!isset($_SESSION['user'])) {
            $res .= "<p>Regarde tes séries et tes films sans limites et sans publicité avec NetVOD.</p>";
        }

        /* ========== MES PRÉFÉRENCES ========== */
        if (isset($_SESSION['preferences'])) {
            $res .= "<section class='catalogue-section'>";
            $res .= "<h2>Mes Préférences</h2><div class='catalogue'>";
            $series = $_SESSION['preferences']->__get('series');

            if (!empty($series)) {
                foreach ($series as $serie) {
                    $render = new SerieRender($serie);
                    $res .= $render->render(Renderer::COMPACT);
                }
            } else {
                $res .= "<h3>Aucune série présente dans la liste.</h3>";
            }

            $res .= "</div></section>";
        }

        /* ========== EN COURS ========== */
        if (isset($_SESSION['enCours'])) {
            $res .= "<section class='catalogue-section'>";
            $res .= "<h2>En cours</h2><div class='catalogue'>";
            $series = $_SESSION['enCours']->__get('series');
            $enCours = $_SESSION['enCours'];

            if (!empty($series)) {
                foreach ($series as $serie) {
                    $res .= "
                    <div class='serie-compact'>
                        <a href='?action=display-episode&id_episode=" . $enCours->getEnCoursSerie($serie) . "'>
                            <h3>" . htmlspecialchars($serie->__get('titre')) . "</h3>
                            <img src='" . htmlspecialchars($serie->__get('cheminImage')) . "' alt='Image de la série'>
                        </a>
                    </div>";
                }
            } else {
                $res .= "<h3>Aucune série présente dans la liste.</h3>";
            }

            $res .= "</div></section>";
        }

        /* ========== DÉJÀ VISIONNÉES ========== */
        if (isset($_SESSION['dejaVisionnees'])) {
            $res .= "<section class='catalogue-section'>";
            $res .= "<h2>Déjà visionnées</h2><div class='catalogue'>";
            $series = $_SESSION['dejaVisionnees']->__get('series');

            if (!empty($series)) {
                foreach ($series as $serie) {
                    $render = new SerieRender($serie);
                    $res .= $render->render(Renderer::COMPACT);
                }
            } else {
                $res .= "<h3>Aucune série présente dans la liste.</h3>";
            }

            $res .= "</div></section>";
        }

        /* ========== CATALOGUE COMPLET ========== */
        $res .= "<section class='catalogue-section'>";
        $res .= "<h2>Catalogue</h2><div class='catalogue'>";
        $repo = Repository::getInstance();
        $series_total = $repo->getAllSeriesCompact();

        foreach ($series_total as $serie) {
            $render = new SerieRender($serie);
            $res .= $render->render(Renderer::COMPACT);
        }

        $res .= "</div></section>";

        $res .= "</div>"; // fermeture .accueil-container

        return $res;
    }
}
