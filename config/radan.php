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
    App\Radan\Profile\Providers\ProfileServiceProvider::class,

    // Radan Password Policy package service providers
    App\Radan\Policy\Providers\RouteServiceProvider::class,
    App\Radan\Policy\Providers\PasswordPolicyServiceProvider::class,    
  ],
  
  /*
  |--------------------------------------------------------------------------
  | Number of records return
  |--------------------------------------------------------------------------
  | This configuration use in apiResource controller@index method that return
  | resource. if pagination.count set to zero or empty, then index method
  | return Model::all() and if set to integer value, return paginate(count).
  |
  */
  'pagination' => [
    'count' => 15, // if set to 0, return all records
  ],

  /*
  |--------------------------------------------------------------------------
  | Auth Foundation Package configurations
  |--------------------------------------------------------------------------    
  | Auth package manage flexibility of user managment authentication and
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
      /**
      * Permission model
      */
      'permissions' => 'App\Radan\Auth\Models\Permission',
      /**
      * Role model
      */
      'roles' => 'App\Radan\Auth\Models\Role',

      /**
      * User model
      */
      'users' => 'App\Radan\Auth\Models\User',

      /**
      * number of record fetched in request
      */
      'pagination' => [
        'count' => 15, // if set to 0, return all records
      ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Radan Aut prevents rules
    |--------------------------------------------------------------------------
    |
    | These are the prevents rules for delete record of Auth tables.
    |
    */
    'prevents' => [
      /**
      * users table prevents.
      */
      'users' => [
        'id' => 1,
        'username' => 'admin',
      ],

      /**
      * roles table prevents.
      */
      'roles' => [
        'name' => 'Administrators',        
      ],

      /**
      * permissions table prevents.
      */
      'permissions' => [
        'name' => 'All',
      ],
    ],
  ],  
];
