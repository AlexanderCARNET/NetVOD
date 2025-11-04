<?php
namespace iutnc\netvod\action;

use iutnc\netvod\repository\Repository;
use PDO;

class ProfilAction extends Action
{
    public function execute(): string
    {
        $user = $_SESSION['user'] ?? null;
        $html = '';

        // Vérifie si un utilisateur est connecté
        if (!$user) {
            return <<<HTML
                <p>Utilisateur non connecté.</p>
                <a href="?action=signin">Se connecter</a> |
                <a href="?action=default">Accueil</a>
            HTML;
        }

        $repo = Repository::getInstance();
        $pdo = $repo->getPDO();
        $email = $user['email'];

        //  Si le formulaire a été soumis on met à jour les données
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $prenom = htmlspecialchars($_POST['prenom']);
            $nom = htmlspecialchars($_POST['nom']);
            $genre_pref = htmlspecialchars($_POST['genre_pref']);

            $update = $pdo->prepare("
                UPDATE user
                SET prenom = ?, nom = ?, genre_pref = ?
                WHERE email = ?
            ");
            $update->execute([$prenom, $nom, $genre_pref, $email]);

            // Met à jour la session
            $_SESSION['user']['prenom'] = $prenom;
            $_SESSION['user']['nom'] = $nom;
            $_SESSION['user']['genre_pref'] = $genre_pref;

            $html .= "<p><strong>Profil mis à jour avec succès.</strong></p><hr>";
        }



        $email = htmlspecialchars($email);
        $prenom = htmlspecialchars($_SESSION['user']['prenom'] ?? '');
        $nom = htmlspecialchars($_SESSION['user']['nom'] ?? '');
        $genre_pref = htmlspecialchars($_SESSION['user']['genre_pref'] ?? '');


        // Affichage du profil
        $html .= <<<HTML
            <h2>Profil de l'utilisateur</h2>
            <p>Email : {$email}</p>
            <p>Prénom : {$prenom}</p>
            <p>Nom : {$nom}</p>
            <p>Genre préféré : {$genre_pref}</p>

            <form method="post" action="?action=profil">
                <input type="text" name="prenom" placeholder="Prénom"  required>
                <input type="text" name="nom" placeholder="Nom"  required>
                <input type="text" name="genre_pref" placeholder="Genre préféré"  required>
                <button type="submit">Mettre à jour</button>
            </form>
        HTML;

        return $html;
    }
}
