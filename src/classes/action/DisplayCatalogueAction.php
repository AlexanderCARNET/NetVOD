<?php
namespace iutnc\netvod\action;

use iutnc\netvod\exception\ExceptionPasNote;
use iutnc\netvod\renderer\SerieRenderer;
use iutnc\netvod\repository\Repository;
use iutnc\netvod\renderer\Renderer;
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

            // valeurs actuelles pour rendre le formulaire "sticky"
            $motClefValue = isset($_GET['mot_clef']) ? htmlspecialchars(trim($_GET['mot_clef']), ENT_QUOTES) : '';
            $selectedGenre = $_GET['filtre_genre'] ?? '';
            $selectedPublic = $_GET['filtre_public'] ?? '';
            $selectedOrder = $_GET['order'] ?? '';

            $html = '<h1>Catalogue</h1><div class="catalogue">' ;
            $html .= '<form class="search-form" method="GET">';
            // obliger pour que le paramètre action soit bien présent lors de la soumission !!!
            $html .= '<input type="hidden" name="action" value="catalogue">';
            $html .= '<input type="text" name="mot_clef" placeholder="Chercher une série..." value="' . $motClefValue . '">';

            $html .= '<select name="filtre_genre" placeholder="Filtrer par genre">'
                    . '<option value="">Tous les genres</option>';
            foreach ($repo->getAllGenres() as $genre) {
                $sel = ($selectedGenre === $genre) ? ' selected' : '';
                $html .= '<option value="' . htmlspecialchars($genre, ENT_QUOTES) . '"' . $sel . '>' . htmlspecialchars($genre) . '</option>';
            }
            $html .= '</select>';

            $html .= '<select name="filtre_public" placeholder="Filtrer par public">'
                    . '<option value="">Tous les publics</option>';
            foreach ($repo->getAllTypesPublic() as $type) {
                $sel = ($selectedPublic === $type) ? ' selected' : '';
                $html .= '<option value="' . htmlspecialchars($type, ENT_QUOTES) . '"' . $sel . '>' . htmlspecialchars($type) . '</option>';
            }
            $html .= '</select>';

            $html .= '<select name="order" placeholder="Trier par">'
                    . '<option value="">Pas de tri</option>';
        $orders = ['titre' => "Titre", 'dateAjout' => "Date d'ajout", 'nbEpisode' => "Nombre d'épisodes" , 'noteAsc' => "Notes croissantes" , 'noteDsc' => "Notes décroissantes"];
        foreach ($orders as $val => $label) {
                $sel = ($selectedOrder === $val) ? ' selected' : '';
                $html .= '<option value="' . $val . '"' . $sel . '>' . $label . '</option>';
            }
            $html .= '</select>';

            $html .= '<input type="submit" value="Rechercher">'
                  . '</form>';
        try {
        if (isset($_GET['filtre_genre']) && $_GET['filtre_genre'] !== '') {
            $genre = $_GET['filtre_genre'];
            $_SESSION['series_recherche'] = $this->filterByGenre($_SESSION['series_recherche'], $genre);
            if ($_SESSION['series_recherche'] === []) {
                throw new \Exception("Aucun résultat trouver. Pas de série de ce genre.");
            }
        }

        if (isset($_GET['filtre_public']) && $_GET['filtre_public'] !== '') {
            $typePublic = $_GET['filtre_public'];
            $_SESSION['series_recherche'] = $this->filterByTypePublic($_SESSION['series_recherche'], $typePublic);
            if ($_SESSION['series_recherche'] === []) {
                throw new \Exception("Aucun résultat trouver. Pas de série de ce type de public.");
            }
        }
        

        if (isset($_GET['mot_clef']) && trim($_GET['mot_clef']) !== '') {
            $motClef = trim($_GET['mot_clef']);
            $_SESSION['series_recherche'] = $this->motClef($_SESSION['series_recherche'], $motClef);
            if ($_SESSION['series_recherche'] === []) {
                throw new \Exception("Aucun résultat trouver avec ce mot clef.");
            }
        }
        
        if (isset($_GET['order']) && $_GET['order'] !== '') {
            $critere = $_GET['order'];
            $_SESSION['series_recherche'] = $this->orderBy($_SESSION['series_recherche'], $critere);
        }

        foreach ($_SESSION['series_recherche'] as $serie) {
            $renderer = new SerieRenderer($serie);
            $html .= $renderer->render(Renderer::COMPACT);
        }
        } catch (\Exception $e) {
            $html .= '<p class="error-message">' . $e->getMessage() . '</p>';
        }
        $html .= '</div>';

        return $html;
    }

    public function motClef(array $ListeSeries, string $motClef): array
    {
        $nouvelleListe = [];

        if ($motClef === '') {
            return $ListeSeries;
        }

        foreach ($ListeSeries as $serie) {
            $titre = $serie->__get('titre');
            $descriptif = $serie->__get('descriptif');
            // mb_stripos fait une recherche case insensitive (ne tient pas compte des majuscules/minuscules) banger
            if (mb_stripos($titre, $motClef) !== false || mb_stripos($descriptif, $motClef) !== false) {
                $nouvelleListe[] = $serie;
            }
        }
        return $nouvelleListe;
    }


    public function orderBy(array $series, string $critere): array
    {
        if($critere === 'titre') {
            usort($series, [$this, 'compareTitres']);
        } elseif ($critere === 'dateAjout') {
            usort($series, [$this, 'compareDateAjout']);
        } elseif ($critere === 'nbEpisode') {
            usort($series, [$this, 'compareNbEpisodes']);
        } elseif($critere === 'noteAsc') {
            usort($series, [$this, 'compareNoteAsc']);
        } elseif($critere === 'noteDsc') {
            usort($series, [$this, 'compareNoteDsc']);
        }
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

    public function compareNoteAsc(Serie $a, Serie $b): int
    {
        try {
            $aNote = $a->getNoteMoyenne();
        } catch (ExceptionPasNote $e){
            return  1;
        }
        try {
            $bNote = $b->getNoteMoyenne();
        } catch (ExceptionPasNote $e){
            return  -1;
        }
        return $aNote <=> $bNote;
    }

    public function compareNoteDsc(Serie $a, Serie $b): int
    {
        try {
            $aNote = $a->getNoteMoyenne();
        } catch (ExceptionPasNote $e){
            return  1;
        }
        try {
            $bNote = $b->getNoteMoyenne();
        } catch (ExceptionPasNote $e){
            return  -1;
        }
        return $bNote <=> $aNote;
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
