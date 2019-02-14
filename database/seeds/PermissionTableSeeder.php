<?php

use Illuminate\Database\Seeder;
use App\Radan\Auth\Models\Permission;

class PermissionTableSeeder extends Seeder
{    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //DB::table('users')->delete();
        //
        Permission::create([
                'name' => '*-show',
                'display_name' => 'نمایش همه', 
                'description'=> 'نمایش همه'
        ]);

        Permission::create([
                'name' => '*-create',
                'display_name' => 'ایجاد همه', 
                'description'=> 'ایجاد همه'
        ]);

        Permission::create([
                'name' => '*-destroy',
                'display_name' => 'حذف همه', 
                'description'=> 'حذف همه'
        ]);

        Permission::create([
                'name' => '*-store',
                'display_name' => 'ویرایش همه', 
                'description'=> 'ویرایش همه'
        ]);
    }
}
