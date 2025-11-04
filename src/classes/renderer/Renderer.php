<?php

namespace iutnc\netvod\renderer;

interface Renderer
{
    function render(?int $t): string;
}