<?php


namespace App\Exceptions;


use Throwable;

class VerifyException extends \Exception
{
public function __construct($message = "User verified", $code = 404)
{
    parent::__construct($message, $code);
}
}
