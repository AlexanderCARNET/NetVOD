<?php
namespace iutnc\netvod\action;

use iutnc\netvod\repository\Repository;

class ActivateAction extends Action {

    public function execute(): string {
        $token = $_GET['token'] ?? '';

        if (!$token) {
            return '<p>Token manquant.</p>';
        }

        $repo = Repository::getInstance();
        $pdo = $repo->getPDO();

        $stmt = $pdo->prepare("SELECT user_id FROM utilisateur WHERE activation_token = ?");
        $stmt->execute([$token]);
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$user) {
            return '<p>Token invalide ou déjà utilisé.</p>';
        }

        $update = $pdo->prepare(
            "UPDATE utilisateur SET is_active = 1, activation_token = NULL WHERE user_id = ?"
        );
        $update->execute([$user['user_id']]);

        return '<p>Votre compte a été activé avec succès ! Vous pouvez maintenant vous connecter.</p>';
    }
}
