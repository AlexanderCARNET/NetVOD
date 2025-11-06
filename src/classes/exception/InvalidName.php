<?php

namespace iutnc\netvod\exception;


class InvalidName extends \Exception
{
    public function __construct(string $t){
        parent::__construct("Invalid name : ".$t);
    }
}