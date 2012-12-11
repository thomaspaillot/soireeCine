<?php 

class Vote extends Eloquent {

	public static $timestamps = true;

	public function user() {
		return $this->belongs_to('User');
	}
	
	public function movie() {
		return $this->belongs_to('Movie');
	}
}

?>