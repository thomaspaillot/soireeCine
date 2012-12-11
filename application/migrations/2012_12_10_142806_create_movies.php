<?php

class Create_Movies {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('movies', function($table) {
			$table->increments('id');
			$table->integer('user_id');
			$table->string('title', 128);
			$table->string('link', 128);
			$table->integer('votes')->default(0);
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
		Schema::drop('movies');
	}

}