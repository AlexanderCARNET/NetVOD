<?php

namespace iutnc\netvod\avis;

use iutnc\netvod\avis\Avis;

class RendererAvis
{
    private Avis $avis;

    public function __construct(Avis $avis){
        $this->avis = $avis;
    }

    public function render():string{
        $note = $this->avis->getNote();
        $commentaire = $this->avis->getCommentaire();
        $mail = $this->avis->getMail();
        return <<<HTML
            <h3>Avis de $mail</h3>
            <p>Commentaire : $commentaire</p>
            <p>Note : $note</p>
        HTML;
    }
}