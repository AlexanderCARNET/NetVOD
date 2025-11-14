<?php

namespace iutnc\netvod\action;

use iutnc\netvod\renderer\EpisodeRender;
use iutnc\netvod\renderer\Renderer;
use iutnc\netvod\renderer\SerieRenderer;
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

            if($_SERVER['REQUEST_METHOD']=='POST'){
                //Je vérifie si la session préférences est présente, dans laquelle l'objet MesPreferences est enregistré.
                if(isset($_SESSION['preferences'])){
                    $series=$_SESSION['preferences'];
                    if(isset($_POST['add-serie'])){
                        $repo->addPreferences();
                        $series->addSerie($serie);
                        $_SESSION['in']=true;
                    }
                    else if(isset($_POST['del-serie'])){
                        $repo->delPreferences();
                        $series->delSerie($serie);
                        $_SESSION['in']=false;
                    }
                    $_SESSION['preferences']=$series;
                }
            }

            $genres = implode(", ", (array)$serie->__get('genre'));
            $typePublic = implode(", ", (array)$serie->__get('typePublic'));
            $render = new SerieRenderer($serie);
            $res = $render->render(Renderer::LONG);
        }

        $form_noter = new Action_noter(Action_noter::$TYPE_SERIE);
$res .= $form_noter->execute();

$espaceComm = new Action_displayAvis(Action_displayAvis::$TYPE_SERIE);
$res .= $espaceComm->execute();

        return $res;
    }

    public function form():string{
        $res="<form method='post'>";
        if(isset($_SESSION['selected_serie']) && isset($_SESSION['preferences'])){
            $series = $_SESSION['preferences'];
            $serie = $_SESSION['selected_serie'];
            if($series->verifierSerie($serie)){
                $stat=true;
            }
            else{
                $stat=false;
            }
        }
        else{
            return "<h2>Aucune serie selectionnee ou tu n'as pas une liste de tes séries préférées</h2>";
        }
        $_SESSION['in']=$stat;
        if($_SESSION['in']){
            $res.="<button type='submit' name='del-serie'>Retirer des favoris</button>";
        }
        else{
            $res.="<button type='submit' name='add-serie'>Ajouter aux favoris</button>";
        }
        return $res."</form>";

    }
}

