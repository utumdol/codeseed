<?php
class CreateUploadDirectory extends Migration {
	public function up() {
		$old = umask(0);
		mkdir(Config::get('upload_dir'), 0777);
		umask($old);
		symlink(Config::get('upload_dir'), Config::get('public_dir') . '/upload');
	}

	public function down() {
		rmrf(Config::get('upload_dir'));
		unlink(Config::get('public_dir') . '/upload');
	}
}

