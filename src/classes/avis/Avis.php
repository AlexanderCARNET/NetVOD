<?php

namespace iutnc\netvod\avis;

class Avis
{
    private string $commentaire;
    private int $note;
    private string $mail;

    public function __construct(string $mail, string $commentaire, int $note){
        $this->commentaire = $commentaire;
        $this->note = $note;
        $this->mail = $mail;
    }

    public function getNote(): int
    {
        return $this->note;
    }

    public function getCommentaire(): string
    {
        return $this->commentaire;
    }
    public function getMail(): string{
        return $this->mail;
    }
}