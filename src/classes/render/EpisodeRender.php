<?php
namespace iutnc\netvod\render;

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
           $html = "
            <div class='episode-long'>
                <h2>" . htmlspecialchars($this->episode->__get('titre')) . "</h2>
                <h3>Durée : " . $this->episode->__get('duree') . " minutes</h3>
                <video controls width='640'>
                    <source src='" . htmlspecialchars($this->episode->__get('fileNameVideo')) . "' type='video/mp4'>
                    Votre navigateur ne supporte pas la lecture vidéo.
                </video>
                <p><b>Résumé</b> :" . htmlspecialchars($this->episode->__get('resume')) . "</p>
            </div>";

        } else {
            throw new \Exception("Sélecteur de rendu inconnu : " . $selecteur);
        }

        return $html;
    }
}
