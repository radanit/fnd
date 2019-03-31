<?php 
namespace App\Radan\Profile;
use Illuminate\Support\Facades\Facade as LaravelFacade;
/**
 * Class Facade
 *
 * @package App\Radan\Policy\Password
 */
class ProfileFacade extends LaravelFacade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'profile.manager';
    }
}