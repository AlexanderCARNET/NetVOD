<?php

namespace iutnc\netvod\render;

use iutnc\deefy\render\Renderer;
use iutnc\netvod\video\episode\Episode;
class EpisodeRender  implements Renderer{
    
    private Episode $episode;

    public function __construct(Episode $episode) {
        $this->episode = $episode;
    }

    public function render(int $selecteur): string {
        if($selecteur === self::COMPACT){
            $html = "<div class='episode-compact'>
                        <h3>Episode " . $this->episode->numero . " : " . $this->episode->titre . "</h3>
                        <imag src='" . $this->episode->fileNameImage . "' alt='Image de l\'épisode'>
                        <h2>" . $this->episode->duree . "</h2>
                    </div>";
        } elseif ($selecteur === self::LONG) {
            $html = "<div class='episode-long'>
                        <h3>Episode " .$this->episode->titre . "</h3>
                        <h2>Durée : " . $this->episode->duree . " minutes</h2>
                        <img src='" . $this->episode->fileNameImage . "' alt='Image de l\'épisode'>
                        <p>" . $this->episode->resume . "</p>
                    </div>";
        } else {
            throw new \Exception("Sélecteur de rendu inconnu : " . $selecteur);
        }
        return $html;
    }
}