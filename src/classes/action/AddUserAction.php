<?php

namespace iutnc\netvod\action;

use iutnc\netvod\auth\AuthnProvider;
use iutnc\netvod\exception\AuthnException;

// Action permettant de gérer l'ajout d'utilisateurs (inscription)
class AddUserAction extends Action
{

    public function execute(): string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            return <<<HTML
            <form method="post" action="?action=signup">
                <label for="email">Email :</label>
                <input type="email" id="email" name="email" required><br>

                <label for="password">Mot de passe :</label> 
                <input type="password" id="password" name="password" required><br>
                  <label for="password">Confirmation mot de passe :</label>
                <input type="password" id="conf_pass" name="conf_pass" required><br>

                <button type="submit">Créer le compte</button>
            </form>
            HTML;
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'] ?? '';
            $conf_pass = $_POST['conf_pass'] ?? '';

            try {
                $token = AuthnProvider::register($email, $password);

                $html = <<<HTML
    <p>Inscription réussie ! Cliquez sur le lien ci-dessous pour activer votre compte :</p>
    <a href="?action=activate&token=$token">Activer mon compte</a>
HTML;

                return $html;
            } catch (AuthnException $e) {
                $msg = $e->getMessage();

                return <<<HTML
                <div class="info-message">
                    <p>$msg</p>
                    <a href="?action=signup" class="btn">Réessayer</a>
                </div>
                HTML;
            }
        }
    }
}
