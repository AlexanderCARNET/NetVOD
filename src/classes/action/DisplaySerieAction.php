<?php

namespace iutnc\netvod\action;

use iutnc\netvod\action\Action;
use iutnc\netvod\render\Renderer;
use iutnc\netvod\render\SerieRender;
use iutnc\netvod\repository\Repository;

// Action gérant l'affichage d'une Série
class DisplaySerieAction extends Action {

    public function execute(): string
    {
        // Vérification que l'utilisateur est connecté
        if (!isset($_SESSION['user'])) {
            return <<<HTML
                <div class="info-message">
                    <p>Vous devez être connecté pour accéder à cette fonctionnalité.</p>
                    <a href="?action=signin" class="btn"><button>Se connecter</button></a>
                    <a href="?action=add-user" class="btn"><button>Créer un compte</button></a>
                </div>
            HTML;
        } else {
            $repo = Repository::getInstance();
            $serie = $repo->getFullSerieById($_GET['id_serie']);
            if ($serie === null) {
                return <<<HTML
                    <div class="info-message">
                        <p>Série non trouvée.</p>
                        <a href="?action=catalogue" class="btn"><button>Retour au catalogue</button></a>
                    </div>
                HTML;
            }
            $_SESSION['selected_serie'] = $serie;
            $render =  new SerieRender($serie);
            $res = $render->render(Renderer::LONG);

            //ajout de l'espace pour noter
            $form_noter = new Action_noter();
            $res .= $form_noter->execute();

            //ajout de l'espace commentaire
            $espaceComm = new Action_displayAvis();
            $res .= $espaceComm->execute();

            return $res;
        }
    }
}

