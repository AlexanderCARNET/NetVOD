<?php
namespace iutnc\netvod\render;
use iutnc\netvod\render\Renderer;
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
                        <img src='" . $this->serie->__get('cheminImage') . "' alt='Image de la série'>
                    </div>";
        } elseif ($selecteur === self::LONG) {
            $html = "<div class='serie-long'>
                        <h1>" . $this->serie->__get('titre') . "</h1>
                        <h2>Année : " . $this->serie->__get('annee') . " \nNombre d'épisodes : " . $this->serie->__get('nbEpisode') . "Ajoutée le " . $this->serie->__get('dateAjout')->format('Y-m-d') . "</h2>
                        <h2>Genre : " . $this->serie->__get('genre') . " \nPublic :" . $this->serie->__get('typePublic') . "</h2>
                        <p>" . $this->serie->__get('descriptif') . "</p>
                        <img src='" . $this->serie->__get('cheminImage') . "' alt='Image de la série'>
                    </div>";
                    foreach ($this->serie->liste as $episode) {
                        $episodeRender = new EpisodeRender($episode);
                        $html .= $episodeRender->render(self::COMPACT);
                    }
        } else {
            throw new \Exception("Sélecteur de rendu inconnu : " . $selecteur);
        }
        return $html;
    }
}