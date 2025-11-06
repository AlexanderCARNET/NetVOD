<?php
namespace iutnc\netvod\action;

class DefaultAction extends Action
{
    public function execute(): string
    {
            if(!isset($_SESSION['user'])) {
                header ('Location: ?action=signin');
                exit();
            }

            return <<<HTML
            <h2>Bienvenue sur NetVOD</h2>
            <p>Choisissez une action dans le menu.</p>
            HTML;


    }
}
