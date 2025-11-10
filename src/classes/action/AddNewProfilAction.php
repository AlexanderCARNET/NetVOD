<?php
namespace iutnc\netvod\action;

use iutnc\netvod\repository\Repository;
use PDO;

class AddNewProfilAction extends Action
{
    public function execute(): string
    {
        $user = $_SESSION['user'] ?? null;

        if (!$user) {
            return "<p>Veuillez vous connecter avant de choisir un profil.</p>
                    <a href='?action=signin'>Connexion</a>";
        }

        $repo = Repository::getInstance();
        $pdo = $repo->getPDO();

        if( $_SERVER['REQUEST_METHOD'] === 'GET' ) {
            $html = <<<HTML
                <h2>Créer un nouveau profil</h2>
                <form method="POST" action="?action=add_new_profil">
                    <label for="prenom">Prénom :</label>
                    <input type="text" id="prenom" name="prenom" required><br>

                    <label for="nom">Nom :</label>
                    <input type="text" id="nom" name="nom" required><br>

                    <label for="genre_pref">Genre préféré :</label>
                    <input type="text" id="genre_pref" name="genre_pref" required><br>

                    <button type="submit">Créer le profil</button>
                </form>
            HTML;
        }

        if( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
            $prenom = htmlspecialchars($_POST['prenom']);
            $nom = htmlspecialchars($_POST['nom']);
            $genre_pref = htmlspecialchars($_POST['genre_pref']);

            $insert = $pdo->prepare("
                INSERT INTO profil (user_id, prenom, nom, genre_pref)
                VALUES (?, ?, ?, ?)
            ");
            $insert->execute([$user['user_id'], $prenom, $nom, $genre_pref]);

            $_SESSION['user']['prenom'] = $prenom;
            $_SESSION['user']['nom'] = $nom;
            $_SESSION['user']['genre_pref'] = $genre_pref;

            return "<p><strong>Nouveau profil créé avec succès.</strong></p>
                    <a href='?action=select_profil'>Sélectionner un profil</a>";
        }

      
        return $html;
    }
}
