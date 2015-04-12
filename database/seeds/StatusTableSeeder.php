<?php

use Illuminate\Database\Seeder;
use App\Status;

class StatusTableSeeder extends Seeder {

	public function run()
	{
		DB::table('status')->delete();

		$status = [
			['id' => 1, 'name' => 'Aberto', 'icon' => 'img/status/1.png'],
			['id' => 2, 'name' => 'Resolvido', 'icon' => 'img/status/2.png'],
			['id' => 3, 'name' => 'Cancelado', 'icon' => 'img/status/3.png']
		];

		Status::insert($status);
	}

}
