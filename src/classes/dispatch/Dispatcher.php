<?php


namespace iutnc\netvod\dispatch;


use iutnc\netvod\action\SigninAction;
use iutnc\netvod\action\AddUserAction;
use iutnc\netvod\action\LogoutAction;
use iutnc\netvod\action\ActivateAction;
use iutnc\netvod\action\ProfilAction;
use iutnc\netvod\action\ForgettenPasswordAction;
use iutnc\netvod\action\SelectProfilAction;
use iutnc\netvod\action\AddNewProfilAction;
use iutnc\netvod\action\DefaultAction;

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
                $action = new DefaultAction();
                $html = $action->execute();
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
            case 'activate':
                $action = new ActivateAction();
                $html = $action->execute();
                break;
            case 'profil':
                $action = new ProfilAction();
                $html = $action->execute();
                break;
            case 'forgotten_password':
                $action = new ForgettenPasswordAction();
                $html = $action->execute();
                break;  
            case 'select_profil':
                $action = new SelectProfilAction();
                $html = $action->execute();
                break;
            case 'add_new_profil':
                $action = new AddNewProfilAction();
                $html = $action->execute();
                break;
        
           



        }

        $this->renderPage($html);
    }

private function renderPage(string $html): void
{

        if (isset($_SESSION['user'])) {
        $email = $_SESSION['user']['email'];
        $topLinks = <<<HTML
            <a href="?action=profil">Profil</a> 
            <a href="?action=logout">Déconnexion</a>
        HTML;
    } else {
        $topLinks = <<<HTML
            <a href="?action=signin">Connexion</a> 
            <a href="?action=signup">Inscription</a>
        HTML;
    }
   
    $fullPage = <<<HTML
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css" />
    <title>netvod</title>
    <a href ="?action=default">Accueil</a>
    $topLinks;
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

