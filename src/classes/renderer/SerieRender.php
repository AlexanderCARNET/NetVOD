<?php
namespace iutnc\netvod\renderer;

use iutnc\netvod\video\serie\Serie;

class SerieRender implements Renderer
{
    private Serie $serie;

    public function __construct(Serie $serie)
    {
        $this->serie = $serie;
    }

    public function render(int $selecteur): string
    {
        if ($selecteur === self::COMPACT) {
            $html = "
            <div class='serie-compact'>
                <a href='?action=display-serie&id_serie=" . $this->serie->__get('id') . "'>
                    <h3>" . htmlspecialchars($this->serie->__get('titre')) . "</h3>
                    <img src='" . htmlspecialchars($this->serie->__get('cheminImage')) . "' alt='Image de la série'>
                </a>
            </div>";
        } elseif ($selecteur === self::LONG) {
            $genres = implode(", ", (array)$this->serie->__get('genre'));
            $typePublic = implode(", ", (array)$this->serie->__get('typePublic'));

            $html = "
            <div class='serie-long'>
                <h1>" . htmlspecialchars($this->serie->__get('titre')) . "</h1>
                <h2>Année : " . $this->serie->__get('annee') . " -
                    Nombres d'épisodes : " . $this->serie->__get('nbEpisode') . " - 
                    Ajoutée le " . $this->serie->__get('dateAjout')->format('Y-m-d') . "</h2>
                <h3>Genre : $genres | Public : $typePublic</h3>
                <p>" . htmlspecialchars($this->serie->__get('descriptif')) . "</p>
                <img src='" . htmlspecialchars($this->serie->__get('cheminImage')) . "' alt='Image de la série'>
            </div>";

            // Rendu des épisodes liés
            $html .= "<h2>Épisodes</h2>";
            $html .= "<div class='episodes-container'>";

            foreach ($this->serie->liste as $episode) {
                $episodeRender = new EpisodeRender($episode);
                $html .= $episodeRender->render(self::COMPACT);
            }

            $html .= "</div>";

        } else {
            throw new \Exception("Sélecteur de rendu inconnu : " . $selecteur);
        }

        return $html;
    }
}