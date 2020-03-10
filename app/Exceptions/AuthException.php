<?php


namespace App\Exceptions;


class AuthException extends \Exception
{
    public function __construct($message = "User not logged", $code = 403){
        parent::__construct($message, $code);
    }
}
