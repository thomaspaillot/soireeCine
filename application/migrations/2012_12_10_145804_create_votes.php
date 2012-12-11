<?php

class Create_Votes {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('votes', function($table) {
			$table->increments('id');
			$table->integer('user_id');
			$table->integer('movie_id');
			$table->timestamps();
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('votes');
	}

}