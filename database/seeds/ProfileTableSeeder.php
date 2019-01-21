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
			'description' => 'default',
			'structure' => '{"name":"string","family":"string"}'
		));	
	}
}