<?php

use Illuminate\Database\Seeder;
use App\User;

class UserTableSeeder extends Seeder {

	public function run()
	{
		$users = [
			[
				'name' => 'Everton Inocencio',
				'email' => 'hewerthomn@gmail.com',
				'password' => \Hash::make('123456'),
				'city_id' => null,
				'created_at' => new \DateTime(),
				'updated_at' => new \DateTime()
			],
			[
				'name' => 'Randson',
				'email' => 'randsonjs@gmail.com',
				'password' => \Hash::make('123456'),
				'city_id' => null,
				'created_at' => new \DateTime(),
				'updated_at' => new \DateTime()
			]
		];

		User::insert($users);
	}

}
