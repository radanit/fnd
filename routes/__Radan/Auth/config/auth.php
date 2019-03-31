<?php
/*
  |--------------------------------------------------------------------------
  | Auth Foundation Package configurations
  |--------------------------------------------------------------------------    
  | Auth package manage flexibility of user management authentication and
  | Authorization.
  */
return [    
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
