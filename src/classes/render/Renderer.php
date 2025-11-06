<?php
namespace iutnc\netvod\render;
interface Renderer{
    public const COMPACT = 1;
    const LONG = 2;

    function render(int $selecteur):string;
}