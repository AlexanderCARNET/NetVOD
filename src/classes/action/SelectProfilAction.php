<?php
namespace iutnc\netvod\action;

use iutnc\netvod\repository\Repository;
use PDO;

class SelectProfilAction extends Action
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

        $stmt = $pdo->prepare("SELECT * FROM profil WHERE user_id = ?");
        $stmt->execute([$user['user_id']]);
        $profils = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($profils)) {
            return "<p>Aucun profil trouvé.</p>
                    <a href='?action=add_new_profil'>Créer un profil</a>";
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $profil_id = $_POST['profil_id'] ?? null;
            if ($profil_id) {
                $stmt = $pdo->prepare("SELECT * FROM profil WHERE profil_id = ? AND user_id = ?");
                $stmt->execute([$profil_id, $user['user_id']]);
                $profil = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($profil) {
                    $_SESSION['profil'] = $profil;

                    header('Location: ?action=default');
                    exit();
                }

                return "<p>Profil invalide.</p>";
            }
        }

        $html = "<h2>Choisissez un profil</h2>
                 <form method='post' action='?action=select_profil'>
                 <select name='profil_id'>";
        foreach ($profils as $p) {
            $prenom = htmlspecialchars($p['prenom']);
            $nom = htmlspecialchars($p['nom']);
            $html .= "<option value='{$p['profil_id']}'>{$prenom} {$nom}</option>";
        }
        $html .= "</select><br><button type='submit'>Utiliser ce profil</button></form>";

        return $html;
    }
}
