<?php 

class User extends Eloquent {

	public static $timestamps = true;

	public function votes() {
		return $this->has_many('Vote');
	}

    public function set_password($password) {
		return $this->set_attribute('password', Hash::make($password));
	}
	
}

?>