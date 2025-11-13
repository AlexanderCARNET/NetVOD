<?php

namespace iutnc\netvod\exception;

class ExceptionPasNote extends \Exception
{
    public function __construct(string $message = "") {
        parent::__construct($message);
    }
}