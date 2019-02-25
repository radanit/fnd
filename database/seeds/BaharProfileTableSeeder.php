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
            'structure' => '[
                {"id":"1","item":"el-input","type":"string","required":"true","label":"patient.first_name","errorMsg":"patient.first_nameError","name":"first_name"},
                {"id":"2","item":"el-input","type":"string","required":"true","label":"patient.last_name","errorMsg":"patient.last_nameError","name":"last_name"},
                {"id":"3","item":"el-input","type":"string","required":"true","label":"patient.national_code","errorMsg":"patient.national_codeError","name":"national_code"},
                {"id":"4","item":"el-button","label":"patient.submit","name":"submit"}
            ]'
        ));	
        
        Profile::create(array(
			'name' => 'doctor',
			'description'=> 'پزشک', 
			'structure' => '[
                {"id":"1","item":"el-input","type":"string","required":"true","label":"doctor.first_name","errorMsg":"doctor.first_nameError","name":"first_name","rules":"required|string|max:191"},
                {"id":"2","item":"el-input","type":"string","required":"true","label":"doctor.last_name","errorMsg":"doctor.last_nameError","name":"last_name","rules":"required|string|max:191"},
                {"id":"3","item":"el-select","apiUrl":"../api/bahar/specialities","type":"number","required":"true","label":"doctor.speciality","errorMsg":"doctor.specialityError","name":"speciality_id","rules":"required|exists:specialities,id"},	
                {"id":"4","item":"el-button","label":"doctor.submit","name":"submit"}
            ]'
        ));
        
        Profile::create(array(
			'name' => 'radiology_users',
			'description'=> 'کاربران رادیولوژی', 
			'structure' => '[
                {"id":"1","item":"el-input","type":"string","required":"true","label":"patient.first_name","errorMsg":"patient.first_nameError","name":"first_name"},
                {"id":"2","item":"el-input","type":"string","required":"true","label":"patient.last_name","errorMsg":"patient.last_nameError","name":"last_name"},                
                {"id":"4","item":"el-button","label":"patient.submit","name":"submit"}
            ]'
        ));
    }
}
