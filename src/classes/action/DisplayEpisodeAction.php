<?php
namespace iutnc\netvod\action;

use iutnc\netvod\render\EpisodeRender;
use iutnc\netvod\render\Renderer;

class DisplayEpisodeAction extends Action
{
    public function execute(): string
    {
        if (!isset($_SESSION['user'])) {
            return <<<HTML
                <div class="info-message">
                    <p>Vous devez être connecté pour accéder à cette fonctionnalité.</p>
                    <a href="?action=signin" class="btn">Se connecter</a>
                    <a href="?action=signup" class="btn">Créer un compte</a>
                </div>
            HTML;
        }

        // Recherche de l’épisode sélectionné
        $episode = null;

        if (isset($_SESSION['selected_serie'])) {
            foreach ($_SESSION['selected_serie']->liste as $ep) {
                if ($ep->__get('numero') == ($_GET['id_episode'] ?? null)) {
                    $episode = $ep;
                    $_SESSION['selected_episode'] = $ep;
                    break;
                }
            }
        }

        if ($episode === null) {
            return <<<HTML
                <div class="info-message">
                    <p>Épisode non trouvé.</p>
                    <a href="?action=catalogue" class="btn">Retour au catalogue</a>
                </div>
            HTML;
        }

        $render = new EpisodeRender($episode);
        return $render->render(Renderer::LONG);
    }
}
