<?php

/*
|--------------------------------------------------------------------------
| Password Policy Foundation Package configurations
|--------------------------------------------------------------------------    
|  Password Policy package manage password policy per user profiles  
*/
return [
  
  /*
  |--------------------------------------------------------------------------
  | Password Policy validation name
  |--------------------------------------------------------------------------
  | This name use in laravel validation list
  */
  'validation_name' => 'password',

  /*
  |--------------------------------------------------------------------------
  | Password Policy driver
  |--------------------------------------------------------------------------
  | Read Password Policy Driver (Drivers: database,local)
  */
  'driver' => 'database',
  
  /*
  |--------------------------------------------------------------------------
  | Password Policy validation rule for local driver
  |--------------------------------------------------------------------------
  | If Password Polict driver set to local, then below parameters use for 
  | password policy validation and policies
  */
  'local' => [
    'default' => [
      'rules' => [
        'min_length' => 6,
      ],
    ],
    'user' => [
      'rules' => [
        'min_length' => 6,
      ],
    ],
  ],
  
  /*
  |--------------------------------------------------------------------------
  | Radan Password Policy Models
  |--------------------------------------------------------------------------    
  | These are the models used by RadanPassword Policy to define the password 
  | policy for each user profile . If you want the Radan Password Policy to be 
  | in a different namespace or to have a different name, you can do it here.    
  */
  'models' => [
    /*
     * Profile model
     */
    'profiles' => 'App\Radan\Profile\Models\Profile',

    /*
     * PasswordPolicy model
     */
    'password_policies' => 'App\Radan\PasswordPolicy\Models\PasswordPolicy',

    /*
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
    
    'password_policies' => 'password_policies',

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

    'profiles' => 'password_policy_id',

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

    'password_policies' => [
      'id' => 1,
      'name' => 'default',
    ],

  ],  
];