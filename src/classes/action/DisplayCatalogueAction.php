<?php
namespace iutnc\netvod\action;

use iutnc\netvod\render\SerieRender;
use iutnc\netvod\repository\Repository;
use iutnc\netvod\render\Renderer;
use iutnc\netvod\video\serie\Serie;

class DisplayCatalogueAction extends Action
{
    public function execute(): string
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ?action=signin');
            exit();
        }

        $repo = Repository::getInstance();
        $_SESSION['series_recherche'] = $repo->getAllSeries();

        $html = '<h1>Catalogue</h1><div class="catalogue">';
        
        
        if(isset($_GET['filter'])) {
            if($_GET['filter'] === 'genre') {
                $genre = $_GET['filter_genre'];
                $_SESSION['series_recherche'] = $this->filterByGenre($_SESSION['series_recherche'], $genre);
            } elseif($_GET['filter'] === 'typePublic') {
                $typePublic = $_GET['filter_typePublic'];
                $_SESSION['series_recherche'] = $this->filterByTypePublic($_SESSION['series_recherche'], $typePublic);
            }
        }

        if(isset($_GET['mot_clef'])) {
            $motClef = $_GET['mot_clef'];
            $_SESSION['series_recherche'] = $this->motClef($_SESSION['series_total'], $motClef);
        }
        
        if(isset($_GET['order'])) {
            $critere = $_GET['order'];
            if(isset($_SESSION['series_recherche'])) {
                $_SESSION['series_recherche'] = $this->orderBy($_SESSION['series_recherche'], $critere);
            } else {
                $_SESSION['series_recherche'] = $this->orderBy($_SESSION['series_recherche'], $critere);
            }
        }

        foreach ($_SESSION['series_recherche'] as $serie) {
            $renderer = new SerieRender($serie);
            $html .= $renderer->render(Renderer::COMPACT);
        }
        $html .= '</div>';

        return $html;
    }

    public function motClef(array $ListeSeries, string $motClef): array
    {
        $nouvelleListe =[];
        
        foreach ($ListeSeries as $serie) {
            if (str_contains($serie->__get('titre'), $motClef)) {
                $nouvelleListe[] = $serie;
            } elseif (str_contains($serie->__get('descriptif'), $motClef)) {
                $nouvelleListe[] = $serie;
            }
        }
        return $nouvelleListe;
    }


    public function orderBy(array $series, string $critere): array
    {
        // usort;
        usort($series, [$this, 'compare' . ucfirst($critere)]);
        return $series;
    }

    public function compareTitres(Serie $a, Serie $b): int
    {
        return strcmp($a->__get('titre'), $b->__get('titre'));
    }

    public function compareDateAjout(Serie $a, Serie $b): int
    {
        // <=> équivaux à compareTO en java
        return $a->__get('dateAjout') <=> $b->__get('dateAjout');
    }

    public function compareNbEpisodes(Serie $a, Serie $b): int
    {
        return $a->__get('nbEpisode') <=> $b->__get('nbEpisode');
    }

    public function filterByGenre(array $ListeSeries, string $genre): array
    {
        $nouvelleListe =[];
        
        foreach ($ListeSeries as $serie) {
            if (in_array($genre, $serie->__get('genre'))) {
                $nouvelleListe[] = $serie;
            }
        }
        return $nouvelleListe;
    }

    public function filterByTypePublic(array $ListeSeries, string $typePublic): array
    {
        $nouvelleListe =[];
        
        foreach ($ListeSeries as $serie) {
            if (in_array($typePublic, $serie->__get('typePublic'))) {
                $nouvelleListe[] = $serie;
            }
        }
        return $nouvelleListe;
    }
}
