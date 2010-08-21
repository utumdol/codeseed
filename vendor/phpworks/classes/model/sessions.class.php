<?php
class Sessions extends Model {

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
	}

	public static function write($session_id, $data) {
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

