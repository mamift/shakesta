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
			'retailer_id' => null
		]);

		foreach(range(1, 3) as $index)
		{
			User::create([
				'username' => $faker->text(10), 
				'password' => Hash::make('password'),
				'email' => $faker->email(),
				'retailer_id' => null
			]);
		}
	}
}