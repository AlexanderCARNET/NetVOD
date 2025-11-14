<?php

namespace iutnc\netvod\action;

use iutnc\netvod\renderer\Renderer;
use iutnc\netvod\renderer\SerieRenderer;
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
                    $render = new SerieRenderer($serie);
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
                    $render = new SerieRenderer($serie);
                    $res .= $render->render(Renderer::COMPACT);
                }
            } else {
                $res .= "<h3>Aucune série présente dans la liste.</h3>";
            }

            $res .= "</div></section>";
        }

        /* ========== CATALOGUE COMPLET ========== */
        $repo = Repository::getInstance();
        $_SESSION['series_recherche'] = $repo->getAllSeries();

            // valeurs actuelles pour rendre le formulaire "sticky"
            $motClefValue = isset($_GET['mot_clef']) ? htmlspecialchars(trim($_GET['mot_clef']), ENT_QUOTES) : '';
            $selectedGenre = $_GET['filtre_genre'] ?? '';
            $selectedPublic = $_GET['filtre_public'] ?? '';
            $selectedOrder = $_GET['order'] ?? '';

            $res .= '<h1>Catalogue</h1><div class="catalogue">' ;
            $res .= '<form class="search-form" method="GET">';
            // obliger pour que le paramètre action soit bien présent lors de la soumission !!!
            $res .= '<input type="hidden" name="action" value="catalogue">';
            $res .= '<input type="text" name="mot_clef" placeholder="Chercher une série..." value="' . $motClefValue . '">';

            $res .= '<select name="filtre_genre" placeholder="Filtrer par genre">'
                    . '<option value="">Tous les genres</option>';
            foreach ($repo->getAllGenres() as $genre) {
                $sel = ($selectedGenre === $genre) ? ' selected' : '';
                $res .= '<option value="' . htmlspecialchars($genre, ENT_QUOTES) . '"' . $sel . '>' . htmlspecialchars($genre) . '</option>';
            }
            $res .= '</select>';

            $res .= '<select name="filtre_public" placeholder="Filtrer par public">'
                    . '<option value="">Tous les publics</option>';
            foreach ($repo->getAllTypesPublic() as $type) {
                $sel = ($selectedPublic === $type) ? ' selected' : '';
                $res .= '<option value="' . htmlspecialchars($type, ENT_QUOTES) . '"' . $sel . '>' . htmlspecialchars($type) . '</option>';
            }
            $res .= '</select>';

            $res .= '<select name="order" placeholder="Trier par">'
                    . '<option value="">Pas de tri</option>';
            $orders = ['titre' => "Titre", 'dateAjout' => "Date d\'ajout", 'nbEpisode' => "Nombre d\'épisodes"];
            foreach ($orders as $val => $label) {
                $sel = ($selectedOrder === $val) ? ' selected' : '';
                $res .= '<option value="' . $val . '"' . $sel . '>' . $label . '</option>';
            }
            $res .= '</select>';

            $res .= '<input type="submit" value="Rechercher">'
                  . '</form>';

        foreach ($_SESSION['series_recherche'] as $serie) {
            $renderer = new SerieRenderer($serie);
            $res .= $renderer->render(Renderer::COMPACT);
        }
        $res .= '</div>';

        return $res;
    }
}