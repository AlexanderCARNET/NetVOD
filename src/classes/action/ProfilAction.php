<?php
namespace iutnc\netvod\action;

use iutnc\netvod\repository\Repository;

class ProfilAction extends Action
{
    public function execute(): string
    {
        $user = $_SESSION['user'] ?? null;
        $profil = $_SESSION['profil'] ?? null;

        if (!$user) {
            return "<p>Utilisateur non connecté.</p>
                    <a href='?action=signin'>Se connecter</a>";
        }

        if (!$profil) {
            return "<p>Aucun profil sélectionné.</p>
                    <a href='?action=select_profil'>Choisir un profil</a>";
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $prenom = trim($_POST['prenom'] ?? '');
            $nom = trim($_POST['nom'] ?? '');
            $genre_pref = trim($_POST['genre_pref'] ?? '');

            $repo = Repository::getInstance();
            $pdo = $repo->getPDO();

            $stmt = $pdo->prepare("
                UPDATE profil 
                SET prenom = ?, nom = ?, genre_pref = ?
                WHERE profil_id = ?
            ");
            $stmt->execute([$prenom, $nom, $genre_pref, $profil['profil_id']]);

            $_SESSION['profil']['prenom'] = $prenom;
            $_SESSION['profil']['nom'] = $nom;
            $_SESSION['profil']['genre_pref'] = $genre_pref;

            header('Location: ?action=select_profil');
            exit();
        }

        $email = htmlspecialchars($user['email']);
        $prenom = htmlspecialchars($profil['prenom'] ?? '');
        $nom = htmlspecialchars($profil['nom'] ?? '');
        $genre_pref = htmlspecialchars($profil['genre_pref'] ?? '');

        return <<<HTML
            <div class="serie-long">
            <h2>Profil actuel</h2>
            <p><strong>Email :</strong> {$email}</p>
            <p><strong>Prénom :</strong> {$prenom}</p>
            <p><strong>Nom :</strong> {$nom}</p>
            <p><strong>Genre préféré :</strong> {$genre_pref}</p>
            </div>
                 <div class="btn">
            <a href="?action=select_profil">Changer de profil</a>
            </div>
            <hr>
            <h3>Modifier le profil</h3>
            <form method="POST" action="?action=profil">
                <label for="prenom">Prénom :</label>
                <input type="text" id="prenom" name="prenom" value="{$prenom}" required><br>

                <label for="nom">Nom :</label>
                <input type="text" id="nom" name="nom" value="{$nom}" required><br>

                <label for="genre_pref">Genre préféré :</label>
                <input type="text" id="genre_pref" name="genre_pref" value="{$genre_pref}"><br>

                <button type="submit">Mettre à jour le profil</button>
            </form>
            <hr>
       
        HTML;
    }
}
