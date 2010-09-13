<?php
class Crypt {
	private $algorithm;
	private $mode;
	private $random_source;

	public $clear_text;
	public $cipher_text;
	public $iv;

	public function Crypt($algorithm = MCRYPT_BLOWFISH, $mode = MCRYPT_MODE_CBC, $random_source = MCRYPT_DEV_URANDOM) {
		$this->algorithm = $algorithm;
		$this->mode = $mode;
		$this->random_source = $random_source;
	}

	public 
}

