<?php

class Add_Archived_To_Movies {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('movies', function($table) {
		    $table->boolean('archived')->default(0);
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
		    $table->drop_column('archived');
		});
	}

}