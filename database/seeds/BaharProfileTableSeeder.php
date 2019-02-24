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
			'structure' => '[
                {"id":"1","item":"el-input","type":"string","required":"true","label":"doctor.first_name","errorMsg":"doctor.first_nameError","name":"first_name","rules":"required|string|max:191"},
                {"id":"2","item":"el-input","type":"string","required":"true","label":"doctor.last_name","errorMsg":"doctor.last_nameError","name":"last_name","rules":"required|string|max:191"},
                {"id":"3","item":"el-select","type":"number","required":"true","label":"doctor.speciality","errorMsg":"doctor.specialityError","name":"speciality_id","rules":"required|exists:specialities,id"},
                {"id":"4","item":"el-upload","min":"3","max": "5","label":"doctor.avatar","errorMsg":"doctor.avatarError","name":"avatar","rules":"dimensions:min_width=100,min_height=100"},
                {"id":"5","item":"el-button","label":"doctor.submit","name":"submit"}
            ]'
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
