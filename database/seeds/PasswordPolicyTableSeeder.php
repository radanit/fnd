<?php

use Illuminate\Database\Seeder;
use App\Radan\Policy\PasswordPolicy\PasswordPolicy;

class PasswordPolicyTableSeeder extends Seeder 
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
		PasswordPolicy::create(array(
			'name' => 'default',
			'description' => 'پیش فرض',			
		));	
	}
}