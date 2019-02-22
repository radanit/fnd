<?php

use Illuminate\Database\Seeder;
use App\Bahar\Models\Role;

class BaharRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([            
            'name' => 'patient',
            'display_name' => 'بیمار', 
            'description'=> 'بیمار',                
        ]);

        Role::create([            
            'name' => 'doctor',
            'display_name' => 'پزشک', 
            'description'=> 'پزشک',                
        ]);

        Role::create([            
            'name' => 'radiology_technician',
            'display_name' => 'تکنسین رادیولوژی', 
            'description'=> 'تکنسین رادیولوژی',                
        ]);

        Role::create([            
            'name' => 'radiology_admin',
            'display_name' => 'مدیر رادیولوژی', 
            'description'=> 'مدیر رادیولوژی',                
        ]);

        Role::create([            
            'name' => 'radiology_receptor',
            'display_name' => 'مسئول پذیرش', 
            'description'=> 'مسئول پذیرش',                
        ]);
    }
}
