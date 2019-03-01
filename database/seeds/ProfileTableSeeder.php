<?php

use Illuminate\Database\Seeder;
use App\Radan\Profile\Models\Profile;

class ProfileTableSeeder extends Seeder 
{

	/**
     * Run the database seeds.
     *
     * @return void
     */
	public function run()
	{
		//DB::table('profiles')->delete();
		//
		Profile::create(array(
			'name' => 'default',
			'description' => 'پیش فرض',
			'structure' => [
				[
					"id" => "1",
					"name" => "first_name",
					"item" => "el-input",
					"type" => "string",
					"required" => "true",
					"label" => "profile.first_name",
					"errorMsg" => "profile.first_nameError",
					
				],
				[
					"id" => "2",
					"name" => "last_name",
					"item" => "el-input",
					"type" => "string",
					"required" => "true",
					"label" => "profile.last_name",
					"errorMsg" => "profile.last_nameError",
				]
			]												
		));	
	}
}