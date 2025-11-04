<?php
namespace iutnc\netvod\action;

use iutnc\netvod\repository\Repository;
use PDO;

class ForgettenPasswordAction extends Action
{
    public function execute(): string
    {
        $repo = Repository::getInstance();
        $pdo = $repo->getPDO();

        $token = $_GET['token'] ?? '';

        if ($token) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $password = $_POST['password'] ?? '';
                $password2 = $_POST['password2'] ?? '';

                if (!$password || $password !== $password2) {
                    return '<p>Les mots de passe doivent être identiques et non vides.</p>' . $this->renderPasswordForm($token);
                }

                $stmt = $pdo->prepare("SELECT id, activation_token FROM user WHERE activation_token LIKE ?");
                $stmt->execute(['reset:' . $token . '%']);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!$user) {
                    return '<p>Token invalide.</p>';
                }

                $parts = explode(':', $user['activation_token'], 3);
                if (count($parts) !== 3 || $parts[0] !== 'reset' || $parts[1] !== $token) {
                    return '<p>Token invalide.</p>';
                }

                $expires = (int)$parts[2];
                if ($expires < time()) {
                    return '<p>Le lien a expiré.</p>';
                }

                $hashed = password_hash($password, PASSWORD_BCRYPT);
                $update = $pdo->prepare("UPDATE user SET password = ?, activation_token = NULL WHERE id = ?");
                $update->execute([$hashed, $user['id']]);

                return '<p>Mot de passe changé avec succès. Vous pouvez maintenant vous connecter.</p>';
            }

            return $this->renderPasswordForm($token);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            if (!$email) {
                return '<p>Email requis.</p>' . $this->renderRequestForm();
            }

            $stmt = $pdo->prepare("SELECT id FROM user WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user) {
                return '<p>Si un compte existe pour cet email, un lien de réinitialisation a été envoyé.</p>';
            }


            $resetToken = bin2hex(random_bytes(16));
            $expires = time() + 3600; // 1 heure
            $store = 'reset:' . $resetToken . ':' . $expires;

            $update = $pdo->prepare("UPDATE user SET activation_token = ? WHERE id = ?");
            $update->execute([$store, $user['id']]);

            $url = htmlspecialchars('?action=forgotten_password&token=' . $resetToken);

            return '<p>Un email a été envoyé si le compte existe. (Lien de test ci-dessous)</p>'
                . '<p><a href="' . $url . '">' . $url . '</a></p>';
        }

        return $this->renderRequestForm();
}

    private function renderRequestForm(): string
    {
        return <<<HTML
<form method="post">
    <label for="email">Adresse email :</label>
    <input type="email" id="email" name="email" required><br>
    <button type="submit">Demander la réinitialisation</button>
</form>
HTML;
    }

    private function renderPasswordForm(string $token): string
    {
        $t = htmlspecialchars($token);
        return <<<HTML
<form method="post">
    <input type="hidden" name="token" value="{$t}">
    <label for="password">Nouveau mot de passe :</label>
    <input type="password" id="password" name="password" required><br>
    <label for="password2">Confirmer mot de passe :</label>
    <input type="password" id="password2" name="password2" required><br>
    <button type="submit">Changer le mot de passe</button>
</form>
HTML;
    }
}