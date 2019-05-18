<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class RadioTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('radio_types')->insert([
            'name' => 'Dental',
            'description' => 'فک و دندان',
            'role_id' => 1
        ]);
    }
}
