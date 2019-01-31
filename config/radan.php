<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
    */

    'providers' => [
        /*
         * Radan Fundation Service Providers...
         */
        // Radan Auth pakage service providers
        App\Radan\Auth\Providers\ServiceProvider::class,
        App\Radan\Auth\Providers\RouteServiceProvider::class,
        
        // Radan Config pakage service providers
        App\Radan\Config\Providers\ServiceProvider::class,
        App\Radan\Config\Providers\RouteServiceProvider::class,

        // Radan Profile pakage service providers        
        App\Radan\Profile\Providers\RouteServiceProvider::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Profile Fundation Pakage configurations
    |--------------------------------------------------------------------------    
    |
    */
    'profile' => [
        /*
        |--------------------------------------------------------------------------
        | Radan Profile Models
        |--------------------------------------------------------------------------
        |
        | These are the models used by Radan Profile to define the profiles, user_profiles.
        | If you want the Radan Profile to be in a different namespace or
        | to have a different name, you can do it here.
        |
        */
        'models' => [
        /**
         * Profile model
         */
        'profile' => 'App\Radan\Profile\Models\Profile',

        /**
         * User Profile model
         */
        'user_profile' => 'App\Radan\Profile\Models\UserProfile',        

        ],

        /*
        |--------------------------------------------------------------------------
        | Radan Proflile Tables
        |--------------------------------------------------------------------------
        |
        | These are the tables used by Laratrust to store all the authorization data.
        |
        */
        'tables' => [
            /**
             * Roles table.
             */
            'profiles' => 'profiles',

            /**
             * Permissions table.
             */
            'user_profiles' => 'user_profile',
        ],

        /*
        |--------------------------------------------------------------------------
        | Radan Proflile Keys
        |--------------------------------------------------------------------------
        |
        | These are the foreign keys used by Radan Proflile in the intermediate tables.
        |
        */
        'foreign_keys' => [
            /**
             * User foreign key on Laratrust's role_user and permission_user tables.
             */
            'user' => 'user_id',

            /**
             * Role foreign key on Laratrust's role_user and permission_role tables.
             */
            'profile' => 'profile_id',    
        ],
    ],
];
