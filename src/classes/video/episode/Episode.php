<?php
class Episode {
    private int $numero;
    private string $titre;
    private int $pduree;
    private string $fileNameImage;

    public function __construct(int $numero, string $titre, int $pduree, string $fileNameImage) {
        $this->numero = $numero;
        $this->titre = $titre;
        $this->pduree = $pduree;
        $this->fileNameImage = $fileNameImage;
    }
}