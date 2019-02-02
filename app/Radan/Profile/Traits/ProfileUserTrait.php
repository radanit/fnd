<?php

namespace App\Radan\Profile\Traits;

/**
 * This file is part of Radan Profile, 
 *
 * @license MIT
 * @package Radan/Profile
 */

use Illuminate\Support\Str;
use InvalidArgumentException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

trait ProfileUserTrait
{
    /**
     * One-to-One relations with Role.
     *
     * @return \Illuminate\Database\Eloquent\Relations\OneToOne
     */
    public function profileUser()
    {
        $profileUser = $this->hasOne(
            Config::get('radan.profile.models.profile_user'),
            Config::get('radan.profile.foreign_keys.user'),
            $this->primaryKey
        );

        return $profileUser;
    }

    /**
     * Alias to eloquent one-to-one relation's attach() method.
     *
     * @param  mixed  $profileUser
     * @return static
     */
    public function attachProfile($object)
    {                
        /*if (is_array($object))
        {
            return $this->profileUser()->create($object);
        }
        else if ($object instanceof $object)
        {
            return $this->profileUser->save($object);
        }            
        
        // $profileUser = ProfileUser->data = "";*/

        
    }

    /**
     * Alias to eloquent one-to-one relation's detach() method.
     *
     * @param  mixed  $profileUser
     * @return static
     */
    public function detachProfile($profile)
    {
        /*return $this->$relationship()->deattach(
            $profile,
            $attributes
        );*/
    }
}
