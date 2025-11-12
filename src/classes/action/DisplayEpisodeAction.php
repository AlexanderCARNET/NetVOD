<?php
namespace iutnc\netvod\action;

use iutnc\netvod\renderer\Renderer;
use iutnc\netvod\renderer\EpisodeRender;
use iutnc\netvod\repository\Repository;

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

        $enCours=$_SESSION['enCours'];
        $deja=$_SESSION['dejaVisionnees'];
        $repo = Repository::getInstance();
        $pos_ep=1;

        // Recherche de l’épisode sélectionné
        $episode = null;

        if (isset($_SESSION['selected_serie'])) {
            foreach ($_SESSION['selected_serie']->liste as $ep) {
                if ($ep->__get('numero') == ($_GET['id_episode'] ?? null)) {
                    if(!$deja->verifierSerie($_SESSION['selected_serie'])){
                        if(!$enCours->verifierSerie($_SESSION['selected_serie'])){
                            $repo->addEnCours();
                            $enCours->addSerieEnCours($_SESSION['selected_serie'], $pos_ep);
                        }
                        else if($enCours->verifierFinSerie($_SESSION['selected_serie'])){
                            $repo->delEnCours();
                            $enCours->delSerieEnCours($_SESSION['selected_serie']);
                            $repo->addDejaVisionnees();
                            $deja->addSerie($_SESSION['selected_serie']);
                        }
                        else{
                            $enCours->setEnCoursSerie($_SESSION['selected_serie'], $pos_ep);
                        }
                    }
                    $_SESSION['selected_episode'] = $ep;
                    break;
                }
                else{
                    $pos_ep++;
                }
            }
        }

        if ($ep === null) {
            return <<<HTML
                <div class="info-message">
                    <p>Épisode non trouvé.</p>
                    <a href="?action=catalogue" class="btn">Retour au catalogue</a>
                </div>
            HTML;
        }



        $render = new EpisodeRender($ep);
        return $render->render(Renderer::LONG);
    }
}
