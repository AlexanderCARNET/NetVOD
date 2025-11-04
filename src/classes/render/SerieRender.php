<?php
namespace iutnc\netvod\render;
use iutnc\deefy\render\Renderer;
use iutnc\netvod\video\serie\Serie;

class SerieRender implements Renderer {
    
    private Serie $serie;

    public function __construct(Serie $serie) {
        $this->serie = $serie;
    }

    public function render(int $selecteur): string {
        if ($selecteur === self::COMPACT) {
            $html = "<div class='serie-compact'>
                        <h3>" . $this->serie->__get('titre') . "</h3>
                        <img src='" . $this->serie->__get('fileNameImage') . "' alt='Image de la série'>
                    </div>";
        } elseif ($selecteur === self::LONG) {
            $html = "<div class='serie-long'>
                        <h3>" . $this->serie->__get('titre') . "</h3>
                        <h2>Année : " . $this->serie->__get('annee') . " \nNombre d'épisodes : " . $this->serie->__get('nbEpisode') . "Ajoutée le " . $this->serie->__get('dateAjout') . "</h2>
                        <h2>Genre : " . $this->serie->__get('genre') . " \nPublic :" . $this->serie->__get('typePublic') . "</h2>
                        <p>" . $this->serie->__get('descriptif') . "</p>
                        <img src='" . $this->serie->__get('cheminImage') . "' alt='Image de la série'>
                    </div>";
        } else {
            throw new \Exception("Sélecteur de rendu inconnu : " . $selecteur);
        }
        return $html;
    }
}