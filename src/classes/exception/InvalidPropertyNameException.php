<?php
namespace iutnc\netvod\exception;
class InvalidPropertyNameException extends \Exception {

    public function __construct(string $message = "") {
        parent::__construct($message);
    }

};
?>