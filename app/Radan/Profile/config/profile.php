<?php
/*
|--------------------------------------------------------------------------
| Profile Foundation Package configurations
|--------------------------------------------------------------------------    
| Profile package manage flexibility of user information data type.
| with this package you can have many users by many type of profile.
| 
*/
return [
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
    'profile' => 'profiles',

    /**
    * user profile table.
    */
    'profile_user' => 'profile_user',
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
      'profile' => 'profile_id',
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
      /*
        * profiles table prevents.
        */      
      'id' => 1,
      'name' => 'default',
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
  ],

  /*
  |--------------------------------------------------------------------------
  | Radan Profile user avatar
  |--------------------------------------------------------------------------
  |
  | These are the configuration for avatar disk storage and filed name.
  |
  */
  'disks' => [
    'profile_disk' => [
      'driver' => 'local',
      'root' => public_path('media/profile'),
      'url' => 'media/profile',
      'visibility' => 'public',
    ],
  ],
];