<?php 

namespace App\Radan\Policy\Password;

use Illuminate\Support\Facades\Facade as LaravelFacade;
use App\Radan\Policy\Password\PolicyManager;

/**
 * Class Facade
 *
 * @package App\Radan\Policy\Password
 */
class PasswordPolicyFacade extends LaravelFacade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'policy.manager';
    }
}