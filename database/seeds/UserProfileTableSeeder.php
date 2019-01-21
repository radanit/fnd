<?php

use Illuminate\Database\Seeder;
use App\Radan\Profile\Models\UserProfile;

class UserProfileTableSeeder extends Seeder 
{

	/**
     * Run the database seeds.
     *
     * @return void
     */
	public function run()
	{
		//DB::table('user_profile')->delete();
		//
		UserProfile::create(array(
				'profile_id' => 1,
				'user_id' => 1,
				'data' => '{"name":"admin","family":"admin"}'
			));
	}
}