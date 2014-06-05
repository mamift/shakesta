<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

		User::create([
			'user_id' => 1, 
			'username' => 'admin', 
			'password' => Hash::make('gizmoe99'), 
			'email' => 'admin@shakesta.com',
			'status' => 'enabled',
			'notes' => 'The default and master admin user',
			'retailer_id' => null
		]);
	}
}