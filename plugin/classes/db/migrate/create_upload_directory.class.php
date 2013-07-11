<?php
class CreateUploadDirectory extends Migration {
	public function up() {
		$old = umask(0);
		mkdir(Config::get('upload_dir'), 0777);
		umask($old);
	}

	public function down() {
		rmrf(Config::get('upload_dir'));
	}
}

