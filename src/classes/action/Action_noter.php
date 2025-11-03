<?php

namespace iutnc\netvod\action;

class Action_noter extends Action
{

    public function execute(): string
    {
        return <<<HTML
            <form method="post">
                <label for="note">Note (entre 1 et 5)</label>
                <input type="number" max="5" min="1" name="note" required>
                <label>
                <input type="text" name="Commentaire" required >
                <button type="submit">Envoyer mon avis</button>
            </form>
        HTML;
    }
}