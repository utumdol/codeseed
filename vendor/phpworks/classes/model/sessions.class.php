<?php
class Sessions extends Model {

	public static function open() {
		return true;
	}

	public static function close() {
		return true;
	}

	public static function read($id) {
		$sessions = new Sessions();
		$s = $sessions->find("id = '$id'");
		if (is_null($s)) {
			return '';	
		}
		return $s->data;
	}

	public static function write($id, $data) {
		$sessions = new Sessions();
		$sessions->id = $id;
		$sessions->data = $data;
		$sessions->aceess = time();
		if (is_null($sessions->find("id = $id"))) {
			return $sessions->save();
		}
		return $sessions->update();
	}

	public static function destroy($id) {
		$sessions = new Sessions();
		return $sessions->delete("id = '$id'");
	}

	public static function clean($max) {
		$sessions = new Sessions();
		$old = time() - $max;
		return $sessions->delete("access < '$old'");
	}
}

