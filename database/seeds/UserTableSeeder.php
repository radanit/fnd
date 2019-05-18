<?php

use Illuminate\Database\Seeder;
 

class UserTableSeeder extends Seeder
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
		factory(App\Radan\Auth\Models\User::class)->create(
            [
                'email' => 'admin@radanit.ir',
                'username' => 'admin', 
                'password'=>'admin@123',
                'active' => 1
            ]
        )->attachRole(1);

        factory(App\Radan\Auth\Models\User::class)->create(
            [
                'email' => 'doctor@radanit.ir',
                'username' => 'doctor', 
                'password'=>'doctor@123',
                'active' => 1
            ]
        )->attachRole(1);
    }
}
