<?php

namespace iutnc\netvod\Tris;

use iutnc\netvod\avis\Avis;
use iutnc\netvod\video\serie\Serie;

class TriNote
{
    public static function getSeriesTriNoteAsc(array $listeSerie):array{
        usort($listeSerie,array(self::class,'triNoteAsc'));
        return $listeSerie;
    }

    public static function getSeriesTriNoteDesc(array $listeSerie):array{
        usort($listeSerie,array(self::class,'triNoteDesc'));
        return $listeSerie;
    }

    private static function triNoteAsc(Serie $a1, Serie $a2):int{
        return $a1->getNoteMoyenne()>$a2->getNoteMoyenne();
    }
    private static function triNoteDesc(Serie $a1, Serie $a2):int{
        return $a1->getNoteMoyenne()<$a2->getNoteMoyenne();
    }
}