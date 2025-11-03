<?php

namespace iutnc\netvod\action;

use iutnc\netvod\auth\AuthnProvider;
use iutnc\netvod\exception\AuthnException;

// Action permettant de gérer l'ajout d'utilisateurs (inscription)
class AddUserAction extends Action {

    public function execute(): string {
        // Affichage du form pour permettre l'utilisateur de rentrer ses données
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
        }

        // Si l'utilisateur a appuyé sur le submit du form précédent
        elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'] ?? '';
            $conf_pass = $_POST['conf_pass'] ?? '';

            try {
                // Tentative d'enregistrer l'utilisateur
                AuthnProvider::register($email, $password, $conf_pass);
                return "<p>Inscription réussie pour $email. Vous pouvez maintenant vous connecter.</p>";
            } catch (AuthnException $e) {
                // La gestion des cas d'erreurs est prise en charge dans la classe AuthnProvider
                $msg = $e->getMessage();

                return <<<HTML
                <div class="info-message">
                    <p>$msg</p>
                    <a href="?action=signup" class="btn">Réessayer</a>
                </div>
                HTML;
            } 
        }

        return "<p>Méthode HTTP non supportée. Utilisez GET ou POST.</p>";
    }
}
