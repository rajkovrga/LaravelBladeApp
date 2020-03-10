<?php


namespace App\Exceptions;


class NotVerifyException extends \Exception
{
public function __construct($message = "User not verified", $code = 401)
{
    parent::__construct($message, $code);
}
}
