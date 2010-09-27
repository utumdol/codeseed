<?php
class DbSessionHandler {

	public static function open() {
		return true;
	}

	public static function close() {
		return true;
	}

	public static function read($session_id) {
		$sessions = new Sessions();
		$s = $sessions->find("session_id = '$session_id'");
		if (is_null($s)) {
			return '';	
		}
		return $s->data;

		// decryption
		// TODO move it to the Crypt method
		/*
		$data = base64_decode($s->data);
		$iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_CBC);
		$cipher_text = substr($data, $iv_size);
		$iv = substr($data, 0, $iv_size);

		$crypt = new Crypt();
		$crypt->iv = $iv;
		$crypt->cipher_text = $cipher_text;
		$crypt->decrypt();

		return $crypt->decrypt();
		*/
	}

	public static function write($session_id, $data) {
		/*
		// encryption
		$crypt = new Crypt();
		$crypt->clear_text = $data;
		$crypt->generate_iv();
		$crypt->encrypt();
		$cipher_text = $crypt->cipher_text;
		$iv = $crypt->iv;
		$data = base64_encode($iv . $cipher_text);
		*/

		$sessions = new Sessions();
		$sessions->session_id = $session_id;
		$sessions->data = $data;
		$s = $sessions->find("session_id = '$session_id'");
		if (is_null($s)) {
			return $sessions->save();
		}
		$sessions->id = $s->id;
		return $sessions->update();
	}

	public static function destroy($session_id) {
		$sessions = new Sessions();
		return $sessions->delete("session_id = '$session_id'");
	}

	public static function clean($max) {
		$sessions = new Sessions();
		$old = time() - $max;
		return $sessions->delete("updated_at < '$old'");
	}
}

