<?php

use Illuminate\Database\Seeder;
 

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
		factory(App\Radan\Auth\Models\User::class)->create(['email' => 'm.riahimanesh@irisaco.com','username' => 'mehdi', 'password'=>bcrypt('123')]);
    }
}
