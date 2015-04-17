<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIssuesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('issues', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('email');
			$table->string('facebook_id');
			$table->string('username', 255);
			$table->string('comment', 255)->nullable();
			$table->string('image_path', 255);
			$table->timestamps();

			$table->integer('city_id')->unsigned()->index();
			$table->foreign('city_id')->references('id')->on('cities');

			$table->integer('category_id')->unsigned()->index();
			$table->foreign('category_id')->references('id')->on('categories');

			$table->integer('status_id')->unsigned()->index();
			$table->foreign('status_id')->references('id')->on('status');
		});

		DB::update("ALTER TABLE issues ADD COLUMN geom GEOMETRY(POINT, 4326)");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('issues');
	}

}
