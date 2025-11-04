<?php

namespace iutnc\netvod\action;
use iutnc\netvod\auth\AuthnProvider;

class SigninAction extends Action
{

    public function execute(): string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $html = <<<HTML
             <form method="POST" action="?action=signin">
                <label for="username">Email :</label>
                <input type="email" id="username" name="username" ><br>
                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" ><br>
                <input type="submit" value="Se connecter">
                <input type="submit" name="pass" value="Mot de passe oublié">

            </form>
            HTML;
            return $html;
        } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['pass'])) {
                header('Location: ?action=forgotten_password');
                exit();
            }
            $email = filter_var($_POST['username'], FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'] ?? '';

            $user = AuthnProvider::signin($email, $password);

            $_SESSION['user'] = $user;

            return '<p>Connexion réussie. Bienvenue, ' . htmlspecialchars($user['email']) . '!</p>';



        } else {
            return '<p>Méthode non supportée</p>';
        }
    }

}
