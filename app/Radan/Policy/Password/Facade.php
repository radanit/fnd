<?php 

namespace App\Radan\Policy\PasswordPolicy;

use Illuminate\Support\Facades\Facade as LaravelFacade;
use App\Radan\Policy\PasswordPolicy\PolicyManager;

/**
 * Class Facade
 *
 * @package PasswordPolicy\Providers\Laravel
 */
class Facade extends LaravelFacade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return app(PolicyManager::class);
    }
}