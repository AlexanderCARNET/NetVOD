<?php
namespace iutnc\netvod\renderer;

use iutnc\netvod\video\episode\Episode;

class EpisodeRender implements Renderer
{
    private Episode $episode;

    public function __construct(Episode $episode)
    {
        $this->episode = $episode;
    }

    public function render(int $selecteur): string
    {
        if ($selecteur === self::COMPACT) {
            $html = "
            <div class='episode-compact'>
                <a href='?action=display-episode&id_episode=" . $this->episode->__get('numero') . "'>
                    <h2>" . htmlspecialchars($this->episode->__get('titre')) . "</h2>
                    <img src='" . htmlspecialchars($this->episode->__get('fileNameImage')) . "' alt='Image de l’épisode'>
                    <h3>" . $this->episode->__get('duree') . " min</h3>
                </a>
            </div>";
        } elseif ($selecteur === self::LONG) {
            $titre = htmlspecialchars($this->episode->__get('titre'));
            $duree = htmlspecialchars($this->episode->__get('duree'));
            $resume = htmlspecialchars($this->episode->__get('resume'));
            $fileVideo = htmlspecialchars($this->episode->__get('fileNameVideo'));
            
            $html = "
            <div class='episode-page'>
                <h1>$titre</h1>
                <h2>Durée : $duree minutes</h2>

                <video controls>
                    <source src='$fileVideo' type='video/mp4'>
                    Votre navigateur ne supporte pas la lecture vidéo.
                </video>

                <p><strong>Résumé :</strong> $resume</p>

                <div class='episode-actions'>
                    <a href='?action=display-serie&id_serie=" . $_SESSION['selected_serie']->id . "'>Retour à la série</a>
                </div>
            </div>";
        } else {
            throw new \Exception("Sélecteur de rendu inconnu : " . $selecteur);
        }

        return $html;
    }
}
