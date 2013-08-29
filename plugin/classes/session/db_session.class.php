<?php
class DbSession {

	public static function open() {
		return true;
	}

	public static function close() {
		return true;
	}

	public static function read($session_id) {
		$sessions = new Sessions();
		$s = $sessions->where("session_id = ?", $session_id)->find();
		if (is_null($s)) {
			return '';
		}

		// decryption
		$crypt = new Crypt();
		return $crypt->decrypt($s->data);
	}

	public static function write($session_id, $data) {
		// encryption
		$crypt = new Crypt();
		$data = $crypt->encrypt($data);

		$sessions = new Sessions();
		$sessions->session_id = $session_id;
		$sessions->data = $data;
		$s = $sessions->where("session_id = ?", $session_id)->find();
		if (is_null($s)) {
			return $sessions->save();
		}
		$sessions->id = $s->id;
		return $sessions->update();
	}

	public static function destroy($session_id) {
		return Sessions::neo()->where("session_id = ?", $session_id)->delete();
	}

	public static function clean($max = 0) {
		$old = time() - $max;
		return Sessions::neo()->where("updated_at < ?", $old)->delete();
	}
}

