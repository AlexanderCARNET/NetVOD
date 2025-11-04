<?php

namespace iutnc\netvod\render;

use iutnc\netvod\render\Renderer;
use iutnc\netvod\video\episode\Episode;
class EpisodeRender  implements Renderer{
    
    private Episode $episode;

    public function __construct(Episode $episode) {
        $this->episode = $episode;
    }

    public function render(int $selecteur): string {
        if($selecteur === self::COMPACT){
            $html = "<div class='episode-compact'>
                        <h2>Episode " . $this->episode->numero . " : " . $this->episode->titre . "</h2>
                        <imag src='" . $this->episode->fileNameImage . "' alt='Image de l\'épisode'>
                        <h3>" . $this->episode->duree . "</h3>
                    </div>";
        } elseif ($selecteur === self::LONG) {
            $html = "<div class='episode-long'>
                        <h2>Episode " .$this->episode->titre . "</h2>
                        <h3>Durée : " . $this->episode->duree . " minutes</h3>
                        <img src='" . $this->episode->fileNameImage . "' alt='Image de l\'épisode'>
                        <p>" . $this->episode->resume . "</p>
                    </div>";
        } else {
            throw new \Exception("Sélecteur de rendu inconnu : " . $selecteur);
        }
        return $html;
    }
}