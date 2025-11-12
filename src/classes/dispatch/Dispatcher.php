<?php
namespace iutnc\netvod\dispatch;

use iutnc\netvod\action\{DisplayAccueil,
    DisplayCatalogueAction,
    DisplayEpisodeAction,
    DisplaySerieAction,
    SigninAction,
    AddUserAction,
    LogoutAction,
    ActivateAction,
    ProfilAction,
    ForgettenPasswordAction,
    SelectProfilAction,
    AddNewProfilAction,
    Action_displayAvis};

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
            case 'signin':
                $action = new SigninAction();
                break;
            case 'signup':
                $action = new AddUserAction();
                break;
            case 'logout':
                $action = new LogoutAction();
                break;
            case 'activate':
                $action = new ActivateAction();
                break;
            case 'profil':
                $action = new ProfilAction();
                break;
            case 'forgotten_password':
                $action = new ForgettenPasswordAction();
                break;
            case 'select_profil':
                $action = new SelectProfilAction();
                break;
            case 'add_new_profil':
                $action = new AddNewProfilAction();
                break;
            case 'display-serie':
                $action = new DisplaySerieAction();
                break;
            case 'display-episode':
                $action = new DisplayEpisodeAction();
                break;
            case "action_displayAvis":
                $diaplyAvis = new Action_displayAvis();
                $html = $diaplyAvis->execute();
                break;
            default:
                $action = new DisplayAccueil();
                break;
        }

        $html = $action->execute();
        $this->renderPage($html);
    }

    private function renderPage(string $html): void
    {
        $topLinks = isset($_SESSION['user'])
            ? '<a href="?action=profil">Profil</a> | <a href="?action=logout">Déconnexion</a>'
            : '<a href="?action=signin">Connexion</a> | <a href="?action=signup">Inscription</a>';

        echo <<<HTML
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <link rel="stylesheet" href="style.css" />
            <title>NetVOD</title>
        </head>
        <body>
            <nav>
                <a href="?action=default">Accueil</a> | $topLinks
            </nav>
            <main>
                $html
            </main>
        </body>
        </html>
        HTML;
    }
}
