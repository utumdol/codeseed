<?php
class CreateUploadDirectory extends Migration {
	public function up() {
		$old = umask(0);
		mkdir(Config::get('upload_dir'), 0777);
		umask($old);
	}

	public function down() {
		exec('rm -rf ' . Config::get('upload_dir'));
	}
}

