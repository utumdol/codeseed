<?php
class CreateTmpDirectory extends Migration {
	public function up() {
		$old = umask(0);
		mkdir(Config::get('tmp_dir'), 0777);
		umask($old);
	}

	public function down() {
		$filenames = get_files(Config::get('tmp_dir'));
		foreach($filenames as $filename) {
			unlink($filename);
		}
		rmdir(Config::get('tmp_dir'));
	}
}

