<?php
namespace iutnc\netvod\auth;

use iutnc\netvod\exception\AuthnException; 
use iutnc\netvod\repository\Repository;


class AuthnProvider {

    // Méthode permettant de se connecter à un compte
    public static function signin(string $email, string $password): array {
        $repo = Repository::getInstance();
        $pdo = $repo->getPDO();

        $stmt = $pdo->prepare("SELECT id, email, password, role FROM user WHERE email = ?");
        $stmt->execute([$email]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$row || !password_verify($password, $row['password'])) {
            throw new AuthnException("Email ou mot de passe incorrect.");
        }

        return [
            'id'    => $row['id'],
            'email' => $row['email'],
            'role'  => $row['role']
        ];
    }

    // Méthode permettant de créer un compte
    public static function register(string $email, string $password, string $conf_pass): void {
        $repo = Repository::getInstance();
        $pdo = $repo->getPDO();

        if (!$pdo) {
            throw new AuthnException("Connexion à la base de données impossible.");
        }

        if($password !== $conf_pass) {
            throw new AuthnException("Les mots de passe ne correspondent pas.");
        }

        if (strlen($password) < 10) {
            throw new AuthnException("Le mot de passe doit contenir au moins 10 caractères.");
        }

        $stmt = $pdo->prepare("SELECT email FROM user WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch(\PDO::FETCH_ASSOC)) {
            throw new AuthnException("Un compte avec cet email existe déjà.");
        }
        
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $insert = $pdo->prepare("INSERT INTO user (email, password, role) VALUES (?, ?, 1)");
        $insert->execute([$email, $hashedPassword]);
    }

    // Getter de l'utilisateur connecté, throw une exception lorsqu'aucun utilisateur est connecté
    public static function getSignedInUser(): ?array {
        if (isset($_SESSION['user'])) {
            return $_SESSION['user'];
        }
        throw new AuthnException("Aucun utilisateur connecté.");
    }
}
