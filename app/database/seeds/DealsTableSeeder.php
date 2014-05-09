<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class DealsTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

		 // "INSERT INTO `shakesta`.`deal` (`deal_id`, `price_discount`, `terms`, `expires_time`, `begins_time`, `category`, `created_at`, `updated_at`) VALUES (NULL, '0.5', 'Terms 1', '2014-05-08 05:18:30', '2014-05-07 11:18:19', 'STUFF 1', '0000-00-00 00:00:00', '0000-00-00 00:00:00'); " 

		foreach(range(1, 10) as $index)
		{
			Deal::create([
				NULL, '0.5', 'Terms 1', '2014-05-08 05:18:30', '2014-05-07 11:18:19', 'STUFF 1', null, null
			]);
		}
	}

}