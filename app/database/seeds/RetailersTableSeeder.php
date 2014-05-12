<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class RetailersTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

		foreach(range(1, 8) as $index)
		{
			Retailer::create([
				'title' => $faker->text(15),
				'description' => $faker->paragraph(3) 
			]);
		}
	}

}