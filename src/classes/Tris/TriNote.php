<?php

namespace iutnc\netvod\Tris;

use iutnc\netvod\avis\Avis;
use iutnc\netvod\video\serie\Serie;

class TriNote
{
    public static function getSeriesTriNoteAsc(array $listeSerie):array{
        sort($listeSerie,"triNoteAsc");
        return $listeSerie;
    }

    public static function triNoteDesc():array{
        return [];
    }

    private function triNoteAsc(Serie $a1, Serie $a2):int{
        return $a1->getNoteMoyenne()<$a2->getNoteMoyenne();
    }
}