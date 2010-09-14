<?php
/**
 * It is borrowed from Essentail PHP Secrurity(Chris Shiflett, O'Reilly.)
 */
class Crypt {
	private $algorithm;
	private $mode;
	private $random_source;

	public $clear_text;
	public $cipher_text;
	public $iv;

	public function __construct($algorithm = MCRYPT_BLOWFISH, $mode = MCRYPT_MODE_CBC, $random_source = MCRYPT_DEV_URANDOM) {
		$this->algorithm = $algorithm;
		$this->mode = $mode;
		$this->random_source = $random_source;
	}

	public function generate_iv() {
		$this->iv = mcrypt_create_iv(mcrypt_get_iv_size($this->algorithm, $this->mode), $this->random_source);
	}

	public function encrypt() {
		$this->ciphertext = mcrypt_encrypt($this->algorithm, $_SERVER['CRYPT_KEY'], $this->cleartext, $this->mode, $this->iv);
	}

	public function decrypt() {
		$this->cleartext = mcrypt_decrypt($this->algorithm, $_SERVER['CRYPT_KEY'], $this->ciphertext, $this->mode, $this->iv);
	}
}

