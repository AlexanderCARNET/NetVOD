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
        $series_total = $repo->getAllSeries();

   $html = '<h1>Catalogue</h1><div class="catalogue">';
foreach ($series_total as $serie) {
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
