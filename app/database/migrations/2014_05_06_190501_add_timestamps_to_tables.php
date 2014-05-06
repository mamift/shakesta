<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddTimestampsToTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('user', function(Blueprint $table) {
			$table->timestamps();
		});

		Schema::table('deal', function(Blueprint $table) {
			$table->timestamps();
		});

		Schema::table('product', function(Blueprint $table) {
			$table->timestamps();
		});

		Schema::table('retailer', function(Blueprint $table) {
			$table->timestamps();
		});

		Schema::table('shop', function(Blueprint $table) {
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('user', function(Blueprint $table) {
			$table->dropColumn('created_at');
			$table->dropColumn('updated_at');
		});

		Schema::table('deal', function(Blueprint $table) {
			$table->dropColumn('created_at');
			$table->dropColumn('updated_at');	
		});

		Schema::table('product', function(Blueprint $table) {
			$table->dropColumn('created_at');
			$table->dropColumn('updated_at');
		});

		Schema::table('retailer', function(Blueprint $table) {
			$table->dropColumn('created_at');
			$table->dropColumn('updated_at');
		});

		Schema::table('shop', function(Blueprint $table) {
			$table->dropColumn('created_at');
			$table->dropColumn('updated_at');
		});


	}

}
