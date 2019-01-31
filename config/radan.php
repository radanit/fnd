<?php

return [

  /*
  |--------------------------------------------------------------------------
  | Auto loaded Service Providers
  |--------------------------------------------------------------------------
  | The service providers listed here will be automatically loaded on the
  | request to your application. Feel free to add your own services to
  | this array to grant expanded functionality to your applications.
  |
  */

  'providers' => [
    /*
    * Radan Foundation Service Providers...
    */
    // Radan Auth package service providers
    App\Radan\Auth\Providers\ServiceProvider::class,
    App\Radan\Auth\Providers\RouteServiceProvider::class,

    // Radan Configure package service providers
    App\Radan\Config\Providers\ServiceProvider::class,
    App\Radan\Config\Providers\RouteServiceProvider::class,

    // Radan Profile package service providers        
    App\Radan\Profile\Providers\RouteServiceProvider::class,
  ],

  /*
  |--------------------------------------------------------------------------
  | Profile Foundation Package configurations
  |--------------------------------------------------------------------------    
  | Profile package manage flexibility of user information data type.
  | with this package you can have many users by many type of profile,
  | that  
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
    | Radan Profile Tables
    |--------------------------------------------------------------------------
    |
    | These are the tables used by Profile to store all the profile data.
    |
    */
<<<<<<< HEAD
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
=======
    'tables' => [
      /**
      * profiles table.
      */
      'profiles' => 'profiles',
>>>>>>> 169b56ec2d063a054e0cd773379e8ae166039f92

      /**
      * user profile table.
      */
      'user_profile' => 'user_profile',
    ],

    /*
    |--------------------------------------------------------------------------
    | Radan Profile prevents rules
    |--------------------------------------------------------------------------
    |
    | These are the prevents rules for delete record of profile tables.
    |
    */
    'prevents' => [
      'profiles' => [
        'id' => 1,
        'name' => 'default',
      ],
      'user_profile' => [
      ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Radan Profile Keys
    |--------------------------------------------------------------------------
    |
    | These are the foreign keys used by Radan Profile in the intermediate tables.
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
