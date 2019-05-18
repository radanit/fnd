<?php

use Illuminate\Database\Seeder;
use App\Radan\Auth\Models\Role;

class RoleTableSeeder extends Seeder
{
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //DB::table('users')->delete();
        //
        Role::create([            
                'name' => 'admin',
                'display_name' => 'مدیریت سیستم', 
                'description'=> 'مدیریت سیستم',                
            ]
        )->attachPermissions([1,2,3,4]);
    
    }
}
