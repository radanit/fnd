<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
	{
		Model::unguard();

		$this->call('ProfileTableSeeder');
		$this->command->info('Profile table seeded!');

		$this->call('ProfileUserTableSeeder');
		$this->command->info('UserProfile table seeded!');

		$this->call('ConfigTableSeeder');
		$this->command->info('Radan Config table seeded!');
		
		$this->call('PasswordPolicyTableSeeder');
		$this->command->info('Radan Password Policy table seeded!');

        $this->call('PermissionTableSeeder');
        $this->command->info('Permission table seeded!');

        $this->call('RoleTableSeeder');
        $this->command->info('Role table seeded!');
        
        $this->call('UserTableSeeder');
        $this->command->info('User table seeded!');
        
        // Add for bahar seeding
        $this->baharDatabaseSeeder();
		
    }
    
    protected function baharDatabaseSeeder()
    {
        $this->call('BaharProfileTableSeeder');
        $this->command->info('BaharProfile seeded!');

        $this->call('BaharRoleTableSeeder');
        $this->command->info('BaharRole seeded!');
    }
}
