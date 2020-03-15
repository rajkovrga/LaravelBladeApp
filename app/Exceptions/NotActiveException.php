<?php


namespace App\Exceptions;


class NotActiveException extends \Exception
{
    public function __construct($message = "Account is not active", $code = 401)
    {
        parent::__construct($message, $code);
    }
}
