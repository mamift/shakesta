<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class ProductsTableSeeder extends Seeder {

	public function run()
	{
		Eloquent::unguard();
		$faker = Faker::create();

		foreach(range(1, 15) as $index)
		{
			Product::create([
				'title' => $faker->text(30),
				'description' => $faker->paragraph(3), 
				'retailer_id' => null,
				'retail_price' => (rand(10, 30)) + (rand(10, 30) / 10),
				'image' => null
			]);
		}
	}
}