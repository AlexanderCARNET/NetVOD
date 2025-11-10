<?php

namespace iutnc\netvod\action;

use iutnc\netvod\action\Action;
use iutnc\netvod\render\Renderer;
use iutnc\netvod\render\EpisodeRender;

// Action gérant l'affichage du catalogue des Séries
class DisplayEpisodeAction extends Action {

    public function execute(): string {
        // Vérification que l'utilisateur est connecté
        if (!isset($_SESSION['user'])) {
            return <<<HTML
                <div class="info-message">
                    <p>Vous devez être connecté pour accéder à cette fonctionnalité.</p>
                    <a href="?action=signin" class="btn">Se connecter</a>
                    <a href="?action=add-user" class="btn">Créer un compte</a>
                </div>
            HTML;
        } else {
            $res = '';
            $episodes = $_SESSION['selected_episode'];
            // si l'épisode n'existe pas
            if ($episodes === null) {
                $res = <<<HTML
                    <div class="info-message">
                        <p>Épisode non trouvé.</p>
                        <a href="?action=catalogue" class="btn">Retour au catalogue</a>
                    </div>
                HTML;
            } else {
                // Affichage de l'épisode
                $render = new EpisodeRender($episodes);
                $res = $render->render(Renderer::LONG);
            }
            return $res;
        }
    }
}