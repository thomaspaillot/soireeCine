<?php 

class Movie extends Eloquent {
	
	public static $timestamps = true;
	
	public function votes_all() {
		return $this->has_many('Vote');
	}
	
	public function user() {
		return $this->belongs_to('User');
	}
}

?>