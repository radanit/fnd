<?php

use Illuminate\Database\Seeder;
use App\Radan\Profile\Models\Profile;
use App\Radan\Auth\Models\Role;
use App\Radan\Auth\Models\Permission;

class DoctorProfileTableSeeder extends Seeder 
{

	/**
     * Run the database seeds.
     *
     * @return void
     */
	public function run()
	{
		// doctor profile
		Profile::create(array(
			'name' => 'doctor',
			'description' => 'پزشک',
			'structure' => [
				[
					"id" => "1",
					"name" => "first_name",
					"item" => "el-input",
					"type" => "text",
					"required" => "true",
					"label" => "profile.first_name",
					"errorMsg" => "profile.first_nameError",
					"rules" => "required|string|max:191",
					
				],
				[
					"id" => "2",
					"name" => "last_name",
					"item" => "el-input",
					"type" => "text",
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
					"item" => "el-select",
					"apiUrl" => "../api/specialities",
					"type" => "select",
					"required" => "true",
					"label" => "profile.speciality",
					"errorMsg" => "profile.specialityError",
					"rules" => "required|string|exists:specialities,id",					
				],
				[
					"id" => "5",
					"name" => "medical_id",
					"item" => "el-input",					
					"type" => "text",
					"required" => "true",
					"label" => "profile.medical_id",
					"errorMsg" => "profile.medicalIdError",
					"rules" => "required|digits_between:5,20",					
				],
			]												
		));	

		// patient profile
		Profile::create(array(
			'name' => 'patient',
			'description' => 'بیمار',
			'structure' => [
				[
					"id" => "1",
					"name" => "first_name",
					"item" => "el-input",
					"type" => "text",
					"required" => "true",
					"label" => "profile.first_name",
					"errorMsg" => "profile.first_nameError",
					"rules" => "required|string|max:191",
					
				],
				[
					"id" => "2",
					"name" => "last_name",
					"item" => "el-input",
					"type" => "text",
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
					"name" => "mobile",
					"item" => "el-input",
					"type" => "text",
					"required" => "false",
					"label" => "profile.mobile",
					"errorMsg" => "profile.mobileError",
					"rules" => "numeric|regex:/(0)[0-9]{10}/",
					
				],
				[
					"id" => "5",
					"name" => "gender",
					"item" => "el-radio-group",
					"type" => "text",
					"required" => "true",
					"label" => "profile.gender",
					"label1" =>"profile.male" ,
					"label2" =>"profile.female",
					"value1" => "0",
					"value2" =>"1",
					"errorMsg" => "profile.genderError",
					"rules" => "required|boolean",
					
				],
				[
					"id" => "6",
					"name" => "birth_year",
					"item" => "date-year-picker",
					"type" => "text",
					"required" => "true",
					"label" => "profile.birthYear",
					"errorMsg" => "profile.birthYearError",
					"rules" => "required|digits:4",					
				],
			]												
		));

		// radio admin profile
		Profile::create(array(
			'name' => 'radioAdmin',
			'description' => 'مدیر رادیولوژی',
			'structure' => [
				[
					"id" => "1",
					"name" => "first_name",
					"item" => "el-input",
					"type" => "text",
					"required" => "true",
					"label" => "profile.first_name",
					"errorMsg" => "profile.first_nameError",
					"rules" => "required|string|max:191",
					
				],
				[
					"id" => "2",
					"name" => "last_name",
					"item" => "el-input",
					"type" => "text",
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
					"name" => "mobile",
					"item" => "el-input",
					"type" => "text",
					"required" => "false",
					"label" => "profile.mobile",
					"errorMsg" => "profile.mobileError",
					"rules" => "numeric|regex:/(0)[0-9]{10}/",
					
				]
			]												
		));

		// receptor profile
		Profile::create(array(
			'name' => 'receptor',
			'description' => 'کارشناس پذیرش',
			'structure' => [
				[
					"id" => "1",
					"name" => "first_name",
					"item" => "el-input",
					"type" => "text",
					"required" => "true",
					"label" => "profile.first_name",
					"errorMsg" => "profile.first_nameError",
					"rules" => "required|string|max:191",
					
				],
				[
					"id" => "2",
					"name" => "last_name",
					"item" => "el-input",
					"type" => "text",
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
					"name" => "mobile",
					"item" => "el-input",
					"type" => "text",
					"required" => "false",
					"label" => "profile.mobile",
					"errorMsg" => "profile.mobileError",
					"rules" => "numeric|regex:/(0)[0-9]{10}/",
					
				]
			]												
		));

		Role::create([
                'name' => 'doctor',
                'display_name' => 'پزشک', 
                'description'=> 'پزشک',                
            ]
		);
		
		Role::create([
                'name' => 'patient',
                'display_name' => 'بیمار', 
                'description'=> 'بیمار',                
            ]
		);

		Role::create([
			'name' => 'receptor',
			'display_name' => 'مسئول پذیرش', 
			'description'=> 'مسئول پذیرش',                
		]);
		
		Permission::create([
			'name' => 'can-manage-radiology',
			'display_name' => 'مدیریت رادیولوژی', 
			'description'=> 'امکان مدیریت اطلاعات پایه',
		]);

		Permission::create([
			'name' => 'can-capture-reception',
			'display_name' => 'امکان افزودن رادیوگرافی', 
			'description'=> 'امکان افزودن رادیوگرافی',
		]);

		Permission::create([
			'name' => 'can-result-reception',
			'display_name' => 'امکان ثبت نتیجه', 
			'description'=> 'امکان ثبت نتیجه برای یک پرونده',
		]);

		Permission::create([
			'name' => 'can-register-reception',
			'display_name' => 'امکان ثبت پذیرش', 
			'description'=> 'امکان ثبت پذیرش',
		]);

	}
}