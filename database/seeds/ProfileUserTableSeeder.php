<?php

use Illuminate\Database\Seeder;
use App\Radan\Profile\Models\ProfileUser;

class ProfileUserTableSeeder extends Seeder 
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
		ProfileUser::create(array(
				'profile_id' => 1,
				'user_id' => 1,
				'data' => [
					"first_name" => "مدیر",
					"last_name" => "سیستم"
				]
			));
		ProfileUser::create(array(
			'profile_id' => 2,
			'user_id' => 2,
			'data' => [
				"first_name" => "پزشک",
				"last_name" => "پزشک"
			]
		));			
	}
}
