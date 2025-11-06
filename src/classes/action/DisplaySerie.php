<?php

namespace iutnc\netvod\action;

use iutnc\netvod\renderer\SerieRenderer;

/**
 * Lorsqu’une série est affichée, possibilité de l’ajouter à la liste de préférence de l’utilisateur au
 * travers d’un bouton « ajouter à mes préférences ».
 */
class DisplaySerie extends Action
{
    public function execute(): string
    {
        $res='';
        if(isset($_SESSION['serie'])){
            $serie = $_SESSION['serie'];
        }
        else{
            return "<h2>Aucune série selectionnee</h2>";
        }
        $render = new SerieRenderer($serie);
        $res.=$render->render(2);
        if($_SERVER['REQUEST_METHOD']=='POST'){
            //Je vérifie si la session préférences est présente, dans laquelle l'objet MesPreferences est enregistré.
            if(isset($_SESSION['preferences'])){
                $series=$_SESSION['preferences'];
                if(isset($_POST['add-serie'])){
                    //
                    //ajouter dans la base de données
                    //
                    $series->addSerie($serie);
                    $_SESSION['in']=true;
                }
                else if(isset($_POST['del-serie'])){
                    $series->delSerie($serie);
                    $_SESSION['in']=false;
                }
            }
            //Dans le cas où la première condition échoue, la seconde vérifie si l'utilisateur s'est connecté pour récupérer les informations de la base de données.
            else if(isset($_SESSION['user'])){
                //
                //prendre les données de la base de données
                //
                return '<h2>Rechargez la page</h2>';
            }
            else{
                return "<h2>Vous devez vous connecter d'abord</h2>";
            }
        }
        return $res.$this->form();
    }

    public function form():string{
        $res="<form method='post'>";
        if(!isset($_SESSION['added'])){
            if(isset($_SESSION['serie']) && isset($_SESSION['preferences'])){
                $series = $_SESSION['preferences'];
                $serie = $_SESSION['serie'];
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
        }
        if($_SESSION['in']){
            $res.="<button type='submit' name='del-serie'>Retirer des favoris</button>";
        }
        else{
            $res.="<button type='submit' name='add-serie'>Ajouter aux favoris</button>";
        }
        return $res."</form";

    }
}