<?php

use Illuminate\Database\Seeder;
use App\Radan\Config\Models\Config;

class ConfigTableSeeder extends Seeder 
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
		Config::create([
			'key' => 'radan.auth.redirectTo',
			'value' => '/home'			
		]);	

        Config::create([
            'key' => 'radan.auth.redirectAfterLogout',
            'value' => 'login'           
        ]); 

        Config::create([
            'key' => 'radan.auth.userActivityLog',
            'value' => '1'         
        ]);
	}
}
