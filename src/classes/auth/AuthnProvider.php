<?php
namespace iutnc\netvod\auth;

use iutnc\netvod\exception\AuthnException; 
use iutnc\netvod\repository\Repository;


class AuthnProvider {

    // Méthode permettant de se connecter à un compte
    public static function signin(string $email, string $password): array {
        $repo = Repository::getInstance();
        $pdo = $repo->getPDO();

        $stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE email = ?");
        $stmt->execute([$email]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$row || !password_verify($password, $row['password'])) {
            throw new AuthnException("Email ou mot de passe incorrect.");
        }

        if (!$row['is_active']) {
    throw new AuthnException("Votre compte n’est pas encore activé.");
}


        return [
            'user_id'    => $row['user_id'],
            'email' => $row['email'],
        ];
    }

    // Méthode permettant de créer un compte
 public static function register(string $email, string $password): string {
    $repo = Repository::getInstance();
    $pdo = $repo->getPDO();

    if (!$pdo) {
        throw new AuthnException("Connexion à la base de données impossible.");
    }

    if (strlen($password) < 10) {
        throw new AuthnException("Le mot de passe doit contenir au moins 10 caractères.");
    }

    $stmt = $pdo->prepare("SELECT email FROM utilisateur WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch(\PDO::FETCH_ASSOC)) {
        throw new AuthnException("Un compte avec cet email existe déjà.");
    }

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    $token = bin2hex(random_bytes(16)); // Token aléatoire

$insert = $pdo->prepare(
    "INSERT INTO utilisateur (email, password, is_active, activation_token) VALUES (?, ?, 0, ?)"
);
$insert->execute([$email, $hashedPassword, $token]);

    // On retourne le token pour pouvoir afficher le lien d'activation
    return $token;
}


    // Getter de l'utilisateur connecté, throw une exception lorsqu'aucun utilisateur est connecté
    public static function getSignedInUser(): ?array {
        if (isset($_SESSION['user'])) {
            return $_SESSION['user'];
        }
        throw new AuthnException("Aucun utilisateur connecté.");
    }
}
