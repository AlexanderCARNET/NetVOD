<?php


namespace iutnc\netvod\dispatch;


use iutnc\netvod\action\SigninAction;
use iutnc\netvod\action\AddUserAction;
use iutnc\netvod\action\LogoutAction;

session_start();

class Dispatcher
{

    private string $action;

    public function __construct()
    {
        $this->action = $_GET['action'] ?? 'default';
    }

    public function run(): void
    {
        $html = '';

        switch ($this->action) {

            case 'default':
                $html = "<p>Bienvenue sur NetVOD ! Veuillez vous connecter ou vous inscrire.</p>";
                $html .= $_SESSION['user']['email'] ?? 'Utilisateur non connecté';
                break;
            case 'signin':
                $action = new SigninAction();
                $html = $action->execute();
                break;
            case 'signup':
                $action = new AddUserAction();
                $html = $action->execute();
                break;
            case 'logout':
                $action = new LogoutAction();
                $html = $action->execute();
                break;
        
           



        }

        $this->renderPage($html);
    }

private function renderPage(string $html): void
{
   
    $fullPage = <<<HTML
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css" />
    <title>netvod</title>
    <a href ="?action=default">Accueil</a>
    <a href ="?action=signin">Connexion</a>
    <a href ="?action=signup">Inscription</a>
    <a href ="?action=logout">Déconnexion</a>
</head>
<body>
$html
</body>
</html>
HTML;

    echo $fullPage;
}
}
?>

