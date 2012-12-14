<?php

class Add_Desc_To_Movies {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('movies', function($table) {
		    $table->text('description');
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('movies', function($table) {
		    $table->drop_column('description');
		});
	}

}