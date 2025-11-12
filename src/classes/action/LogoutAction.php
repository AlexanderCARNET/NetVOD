<?php
namespace iutnc\netvod\action;

class LogoutAction extends Action
{
    public function execute(): string
    {
        session_unset();
        session_destroy();

        return <<<HTML
            <p>Vous avez été déconnecté avec succès.</p>
            <div class="btn">
            <a href="?action=signin">Se reconnecter</a> 
            </div>
        HTML;
    }
}
