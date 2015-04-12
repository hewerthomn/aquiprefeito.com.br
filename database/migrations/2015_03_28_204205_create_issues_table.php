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
			$table->string('comment', 255)->nullable();
			$table->integer('like')->default(0);
			$table->integer('dislike')->default(0);
			$table->integer('city_id')->unsigned()->index();
			$table->integer('category_id')->unsigned()->index();
			$table->timestamps();

			$table->foreign('city_id')->references('id')->on('cities');
			$table->foreign('category_id')->references('id')->on('categories');
		});
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
