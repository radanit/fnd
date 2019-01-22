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
                'email' => 'm.riahimanesh@irisaco.com',
                'username' => 'mehdi', 
                'password'=>bcrypt('123'),
                'active' => 1
            ]
        );
    }
}
