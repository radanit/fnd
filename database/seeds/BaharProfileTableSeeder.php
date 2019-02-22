<?php

use Illuminate\Database\Seeder;
use App\Radan\Profile\Models\Profile;

class BaharProfileTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {    
        Profile::create(array(
			'name' => 'patient',
			'description'=> 'بیمار', 
            'structure' => '{
                "first_name":"required|string|max:191",
                "last_name":"required|string|max:191",
                "national_code":"required|digit:10",
                "gender": "required|in:male,female",
                "avatar":"dimensions:min_width=100,min_height=100"
            }'
        ));	
        
        Profile::create(array(
			'name' => 'doctor',
			'description'=> 'پزشک', 
			'structure' => '{
                "first_name":"required|string|max:191",
                "last_name":"required|string|max:191",
                "speciality_id":"required|exists:specialities,id",
                "avatar":"dimensions:min_width=100,min_height=100"
            }'
        ));
        
        Profile::create(array(
			'name' => 'radiology_users',
			'description'=> 'کاربران رادیولوژی', 
			'structure' => '{
                "first_name":"required|string|max:191",
                "last_name":"required|string|max:191",
                "avatar":"dimensions:min_width=100,min_height=100"
            }'
        ));
    }
}
