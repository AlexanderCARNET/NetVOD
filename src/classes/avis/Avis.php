<?php

namespace iutnc\netvod\avis;

class Avis
{
    private string $commentaire;
    private int $note;

    public function __construct(string $commentaire, int $note){
        $this->commentaire = $commentaire;
        $this->note = $note;
    }

    public function getNote(): int
    {
        return $this->note;
    }

    public function getCommentaire(): string
    {
        return $this->commentaire;
    }
}