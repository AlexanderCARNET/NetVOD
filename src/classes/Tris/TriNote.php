<?php

namespace iutnc\netvod\Tris;

use iutnc\netvod\avis\Avis;

class TriNote
{
    public static function getSeriesTriNoteAsc(array $listeSerie):array{
        sort($listeSerie,"triNoteAsc");
        return $listeSerie;
    }

    public static function triNoteDesc():array{
        return [];
    }

    private function triNoteAsc(Avis $a1, Avis $a2):int{
        return $a1->getNote()<$a2->getNote();
    }
}