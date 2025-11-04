<?php

namespace iutnc\netvod\avis;

use iutnc\netvod\avis\Avis;

class DiaplayAvis
{
    private Avis $avis;

    public function __construct(Avis $avis){
        $this->avis = $avis;
    }

    public function display():string{
        $note = $this->avis->getNote();
        $commentaire = $this->avis->getCommentaire();
        return <<<HTML
            <p>Note : $note</p>
            <p>Commentaire : </p>
            <p>$commentaire</p>
        HTML;
    }
}