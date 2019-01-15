<?php

namespace App\Radan\Auth\Exceptions;

use Exception;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserNotFoundException extends Exception
{
    //
	public function __construct()
    {
        parent::__construct('The user was not found.');
    }
}
