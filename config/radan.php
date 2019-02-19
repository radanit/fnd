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
<<<<<<< HEAD
=======

    // Radan Password Policy package service providers
    App\Radan\PasswordPolicy\Providers\RouteServiceProvider::class,
    App\Radan\PasswordPolicy\Providers\ServiceProvider::class,
>>>>>>> dev
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
  
  /*
  |--------------------------------------------------------------------------
  | Password Policy Foundation Package configurations
  |--------------------------------------------------------------------------    
  |  Password Policy package manage password policy per user profiles  
  */
  'password_policy' => [
    /*
    |--------------------------------------------------------------------------
    | Use Password Policy feature in the package
    |--------------------------------------------------------------------------
    | Defines if Radan Profile will use the Password Policy feature.
    */
    'use_password_policy' => true,

    /*
    |--------------------------------------------------------------------------
    | Password Policy driver
    |--------------------------------------------------------------------------
    | Read Password Policy Driver (Drivers: database,localstore)
    */
    'driver' => 'database',

    

    /*
    |--------------------------------------------------------------------------
    | Password Policy default validation rule for localstore driver
    |--------------------------------------------------------------------------
    | Password validation if password policy feature is disable.
    */
    'default_validation_rules' => 'string|min:6|confirmed',
    'default_validation_name' => 'password',
    'default_policy_name' => 'default',

    /*
    |--------------------------------------------------------------------------
    | Radan Password Policy Models
    |--------------------------------------------------------------------------    
    | These are the models used by RadanPassword Policy to define the password 
    | policy for each user profile . If you want the Radan Password Policy to be 
    | in a different namespace or to have a different name, you can do it here.    
    */
    'models' => [
      /**
      * Profile model
      */
      'profiles' => 'App\Radan\Profile\Models\Profile',

      /*
       * PasswordPolicy model
       */
      'password_policies' => 'App\Radan\PasswordPolicy\Models\PasswordPolicy',

      /**
      * number of record fetched in request
      */
      'pagination' => [
        'count' => 15, // if set to 0, return all records
      ],
    ],
      /*
    |--------------------------------------------------------------------------
    | Radan Password Policy Tables
    |--------------------------------------------------------------------------  
    | These are the tables used by Password Policy to store all data.  
    */
    'tables' => [      
      /**
      * password policy table.
      */
      'password_policies' => 'password_policies' 
    ],

    /*
    |--------------------------------------------------------------------------
    | Radan Password Policy Keys
    |--------------------------------------------------------------------------
    |
    | These are the foreign keys used by Radan Profile in the intermediate tables.
    |
    */
    'foreign_keys' => [
      'profiles' => 'password_policy_id'
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
      * password policy table prevents.
      */
      'password_policies' => [
        'id' => 1,
        'name' => 'deafult',
      ],
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
      'users' => 'App\Radan\Auth\Models\User',

      /*
       * PasswordPolicy model
       */
      'password_policies' => 'App\Radan\Profile\Models\PasswordPolicy',

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

      /**
      * password policy table.
      */
      'password_policies' => 'password_policies' 
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

      /**
      * password policy table prevents.
      */
      'password_policies' => [
        'id' => 1,
        'name' => 'deafult',
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
      'users' => 'user_id',      
      'profiles' => 'profile_id',
    ],

    /*
    |--------------------------------------------------------------------------
    | Radan Profile defaults value
    |--------------------------------------------------------------------------
    |
    | These are the foreign keys used by Radan Profile in the intermediate tables.
    |
    */
    'defaults' => [
      'profile' => [ 'name' => 'default'],      
      'password_policy' => [ 'name' => 'default'],
    ],

  ],
];
