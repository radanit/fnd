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

  /**
  * number of record fetched in request
  */
  'pagination' => [
    'count' => 15, // if set to 0, return all records
  ],

  /*
  |--------------------------------------------------------------------------
  | Auth Foundation Package configurations
  |--------------------------------------------------------------------------    
  | Auth package manage flexibility of user managment authenticatio and
  | Authrization.
  */
  'auth' => [
    /*
    |--------------------------------------------------------------------------
    | Radan Auth Models
    |--------------------------------------------------------------------------
    |
    | These are the models used by Radan Auth to define the User, Role and 
    | Permission. If you want the Radan Auth to be in a different namespace or
    | to have a different name, you can do it here.
    |
    */
    'models' => [
    ],
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
      'profiles' => 'App\Radan\Profile\Models\Profile',

      /**
      * User Profile model
      */
      'profile_user' => 'App\Radan\Profile\Models\ProfileUser',

      /**
      * User model
      */
      'user' => 'App\Radan\Auth\Models\User',

      /**
      * number of record fetched in request
      */
      'pagination' => [
        'count' => 15, // if set to 0, return all records
      ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Radan Profile Tables
    |--------------------------------------------------------------------------
    |
    | These are the tables used by Profile to store all the profile data.
    |
    */
    'tables' => [
      /**
      * profiles table.
      */
      'profiles' => 'profiles',

      /**
      * user profile table.
      */
      'profile_user' => 'profile_user',
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
      /**
      * profiles table prevents.
      */
      'profiles' => [
        'id' => 1,
        'name' => 'default',
      ],

      /**
      * user profile table prevents.
      */
      'profile_user' => [
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
      'profiles' => 'profile_id',
    ],
  ],
];
