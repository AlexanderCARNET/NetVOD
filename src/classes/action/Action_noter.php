<?php

namespace iutnc\netvod\action;

use iutnc\netvod\repository\Repository;

class Action_noter extends Action
{
    private string $typeAction;
    public static string $TYPE_SERIE = 'serie';
    public static string $TYPE_EPISODE = 'episode';

    public function __construct(string $typeAction){
        parent::__construct();
        $this->typeAction = $typeAction;
    }
    public function execute(): string
    {

        //verification si l'utilisateur a deja noter cette série ou cette episode
        $instance = Repository::getInstance();
        if($this->typeAction === self::$TYPE_SERIE){
            $prepare = $instance->getPDO()->prepare("select count(*) as count from avisserie where user_id = ? and serie_id = ?");
            $prepare->bindParam(1, $_SESSION['user']["user_id"]);
            $id = $_SESSION['selected_serie']->id;
            $prepare->bindParam(2, $id);
        }else{
            $prepare = $instance->getPDO()->prepare("select count(*) as count from avisvideo where user_id = ? and video_id = ?");
            $prepare->bindParam(1, $_SESSION['user']["user_id"]);
            $id = $_SESSION['selected_episode']->numero;
            $prepare->bindParam(2, $id);
        }

        $prepare->execute();
        $result = $prepare->fetch()["count"];
        if($result > 0){
            return $this->dejaNotee();
        }

        switch ($_SERVER['REQUEST_METHOD']) {
            case 'POST':
                return $this->methodePOST();
            default:
                return $this->methodeGET();
        }
    }


    private function methodeGET(): string
    {
        return <<<HTML
            <form method="post">
                <label for="note">Note : </label>
                <input type="number" max="5" min="1" name="note" required>
                <br>
                <label for="Commentaire">Commentaire : </label>
                <input type="text" name="Commentaire" required >
                <br>
                <button type="submit">Envoyer mon avis</button>
            </form>
        HTML;
    }

    private function methodePOST(): string
    {
        //recuperation et filtrage de la note et du commentaire
        $note = filter_var($_POST["note"], FILTER_SANITIZE_NUMBER_INT);
        $commentaire = filter_var($_POST["Commentaire"], FILTER_SANITIZE_SPECIAL_CHARS);

        //verif de la taille du commentaire
        if (strlen($commentaire) > 500) {
            return $this->commentaireTropLong();
        }

        //verification que la note est bien entre 1 et 5.
        if($note<1 ||$note>5){
            return $this->noteIncorrect();
        }

        //enregistrement dans la BD
        $instance = Repository::getInstance();
        if($this->typeAction === self::$TYPE_SERIE){
            $prepare = $instance->getPDO()->prepare("INSERT INTO avisserie (user_id, serie_id, note, commentaire) VALUES (?,?,?,?)");
            $prepare->bindValue(1, $_SESSION["user"]['user_id']);
            $prepare->bindValue(2, $_SESSION["selected_serie"]->id);
        }else{
            $prepare = $instance->getPDO()->prepare("INSERT INTO avisvideo (user_id, video_id, note, commentaire) VALUES (?,?,?,?)");
            $prepare->bindValue(1, $_SESSION["user"]['user_id']);
            $prepare->bindValue(2, $_SESSION["selected_episode"]->numero);
        }

        $prepare->bindValue(3, $note);
        $prepare->bindValue(4, $commentaire);
        $prepare->execute();

        return "Nous vous remercions d'avoir partagé votre avis !";
    }

    private function dejaNotee(): string{
        return "<p>Série déjà noté</p>";
    }

    private function commentaireTropLong():string
    {
        $form = $this->methodeGET();
        return <<<HTML
            <p>Le commentaire est trop long (maximum 500 caractères).</p>
            $form
        HTML;

    }

    private function noteIncorrect():string
    {
        $form = $this->methodeGET();
        return <<<HTML
            <p>La note doit être comprise entre 1 et 5.</p>
            $form
        HTML;
    }
}