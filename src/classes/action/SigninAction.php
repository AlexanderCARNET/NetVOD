<?php
namespace iutnc\netvod\action;

use iutnc\netvod\auth\AuthnProvider;
use iutnc\netvod\exception\AuthnException;

class SigninAction extends Action
{
    public function execute(): string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            // Formulaire de connexion
            return <<<HTML
            <form method="POST" action="?action=signin">
                <label for="username">Email :</label>
                <input type="email" id="username" name="username" ><br>
                
                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" ><br>
                
                <input type="submit" value="Se connecter">
                <input type="submit" name="pass" value="Mot de passe oublié">
            </form>
            HTML;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Bouton "Mot de passe oublié"
            if (isset($_POST['pass'])) {
                header('Location: ?action=forgotten_password');
                exit();
            }

            $email = filter_var($_POST['username'] ?? '', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'] ?? '';

            if (empty($email) || empty($password)) {
                return '<p>Veuillez remplir tous les champs.</p>';
            }

       try {
    $user = AuthnProvider::signin($email, $password);
    $_SESSION['user'] = $user;

    header('Location: ?action=select_profil');
    exit();
} catch (AuthnException $e) {
    $msg = htmlspecialchars($e->getMessage());
    return "<p><strong>Erreur :</strong> {$msg}</p>
            <a href='?action=signin'>Réessayer</a>";
}

        }

        return '<p>Méthode non supportée.</p>';
    }
}
