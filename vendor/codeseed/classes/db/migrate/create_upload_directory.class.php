<?php
class CreateUploadDirectory extends Migration {
	public function up() {
		$old = umask(0);
		mkdir(Config::get('upload_dir'), 0777);
		umask($old);
	}

	public function down() {
		$filenames = get_files(Config::get('upload_dir'));
		foreach($filenames as $filename) {
			unlink($filename);
		}
		rmdir(Config::get('upload_dir'));
	}
}

