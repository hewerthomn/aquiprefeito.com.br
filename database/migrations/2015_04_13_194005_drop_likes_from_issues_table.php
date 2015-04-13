<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropLikesFromIssuesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('issues', function(Blueprint $table)
		{
			$table->dropColumn('likes');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('issues', function(Blueprint $table)
		{
			$table->integer('likes')->default(0);
		});
	}

}
