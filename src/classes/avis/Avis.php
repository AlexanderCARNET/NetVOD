<?php

namespace iutnc\netvod\avis;

use iutnc\netvod\repository\Repository;

class Avis
{
    private string $commentaire;
    private int $note;
    private string $mail;

    public function __construct(string $mail, string $commentaire, int $note){
        $this->commentaire = $commentaire;
        $this->note = $note;
        $this->mail = $mail;
    }

    public function getNote(): int
    {
        return $this->note;
    }

    public function getCommentaire(): string
    {
        return $this->commentaire;
    }
    public function getMail(): string{
        return $this->mail;
    }

    public static function getAvisSerie(int $id_serie){
        $listAvis = [];
            //recuperation de tous les avis de la bd
        $instance = Repository::getInstance();
        $prepare = $instance->getPDO()->prepare("select email, commentaire, note from avisserie inner join utilisateur on utilisateur.user_id = avisserie.user_id where serie_id=? ");
        $prepare->bindParam(1,$id_serie);
        $prepare->execute();
        while($row = $prepare->fetch()){
            $avis = new Avis($row["email"],$row["commentaire"],$row["note"]);
            array_push($listAvis,$avis);
        }
        return $listAvis;
    }
}