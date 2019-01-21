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

		$this->call('UserTableSeeder');
		$this->command->info('User table seeded!');

		$this->call('ProfileTableSeeder');
		$this->command->info('Profile table seeded!');

		$this->call('UserProfileTableSeeder');
		$this->command->info('UserProfile table seeded!');
	}
}
