<?php

use Illuminate\Database\Seeder;
use App\Radan\Profile\Models\Profile;
use App\Radan\Auth\Models\Role;

class DoctorProfileTableSeeder extends Seeder 
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
			'name' => 'doctor',
			'description' => 'پزشک',
			'structure' => [
				[
					"id" => "1",
					"name" => "first_name",
					"item" => "el-input",
					"type" => "string",
					"required" => "true",
					"label" => "profile.first_name",
					"errorMsg" => "profile.first_nameError",
					"rules" => "required|string|max:191",
					
				],
				[
					"id" => "2",
					"name" => "last_name",
					"item" => "el-input",
					"type" => "string",
					"required" => "true",
					"label" => "profile.last_name",
					"errorMsg" => "profile.last_nameError",
					"rules" => "required|string|max:191",
				],
				[
					"id" => "3",
					"name" => "avatar",
					"item" => "el-upload",
					"type" => "file",
					"required" => "false",
					"label" => "profile.avatar",
					"errorMsg" => "profile.avatarError",
					"rules" => "bail|nullable|image|mimes:jpeg,jpg,png,gif|max:2048",
					
				],
				[
					"id" => "4",
					"name" => "speciality",
					"item" => "el-list",
					"type" => "list",
					"required" => "true",
					"label" => "profile.speciality",
					"errorMsg" => "profile.specialityError",
					"rules" => "required|string|exists:specialities",					
				],
			]												
		));	
		
		Role::create([          
                'name' => 'doctor',
                'display_name' => 'پزشک', 
                'description'=> 'پزشک',                
            ]
        );
	}
}