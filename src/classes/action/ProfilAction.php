<?php
namespace iutnc\netvod\action;

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

        $email = htmlspecialchars($user['email']);
        $prenom = htmlspecialchars($profil['prenom'] ?? '');
        $nom = htmlspecialchars($profil['nom'] ?? '');
        $genre_pref = htmlspecialchars($profil['genre_pref'] ?? '');

        return <<<HTML
            <h2>Profil actuel</h2>
            <p><strong>Email :</strong> {$email}</p>
            <p><strong>Prénom :</strong> {$prenom}</p>
            <p><strong>Nom :</strong> {$nom}</p>
            <p><strong>Genre préféré :</strong> {$genre_pref}</p>
            <hr>
            <a href="?action=select_profil">Changer de profil</a>
        HTML;
    }
}
