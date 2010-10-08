<?php
/**
 * It is borrowed from Essentail PHP Secrurity(Chris Shiflett, O'Reilly.)
 */
class Crypt {
	private $algorithm;
	private $mode;
	private $random_source;
	private $key;

	private $clear_text;
	private $cipher_text;
	private $iv;
	private $iv_size;

	public function __construct($algorithm = MCRYPT_BLOWFISH, $mode = MCRYPT_MODE_CBC, $random_source = MCRYPT_DEV_URANDOM) {
		$this->algorithm = $algorithm;
		$this->mode = $mode;
		$this->random_source = $random_source;
		$this->key = sha1(CRYPT_KEY);
	}

	public function encrypt($data) {
		$this->clear_text = $data;
		$this->iv = mcrypt_create_iv(mcrypt_get_iv_size($this->algorithm, $this->mode), $this->random_source);
		$this->cipher_text = mcrypt_encrypt($this->algorithm, $this->key, $this->clear_text, $this->mode, $this->iv);

		return base64_encode($this->iv . $this->cipher_text);
	}

	public function decrypt($data) {
		$this->iv_size = mcrypt_get_iv_size($this->algorithm, $this->mode);
		$data = base64_decode($data);

		$this->cipher_text = substr($data, $this->iv_size);
		$this->iv = substr($data, 0, $this->iv_size);
		$this->clear_text = mcrypt_decrypt($this->algorithm, $this->key, $this->cipher_text, $this->mode, $this->iv);

		return $this->clear_text;
	}
}

