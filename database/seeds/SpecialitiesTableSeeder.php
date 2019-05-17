<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpecialitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('specialities')->insert([
            'name' => 'Dentist',
            'description' => 'دندانپزشک'
        ]);
    }
}
