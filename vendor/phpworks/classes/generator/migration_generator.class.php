<?php
class MigrationGenerator extends Generator {
	var $from;
	var $path = MIGR_DIR;
	var $template = '<?php
class <class> extends Migration {
	public function up() {

	}

	public function down() {

	}
}

';
	var $table_template = '<?php
class Create<class> extends Migration {
	public function up() {
		$this->create_table(\'<table>\');
		// $this->add_column(\'<table>\', \'name\', \'varchar\', \'255\', TRUE);
	}

	public function down() {
		$this->drop_table(\'<table>\');
	}
}

';

	public function MigrationGenerator($name, $from = '') {
		$this->name = $name;
		$this->from = $from;
		if ($this->from == 'model') {
			$this->template = $this->table_template;
		}
	}

	public function get_filename() {
		$this_time = date('YmdHis');
		if ($this->from == 'model') {
			return $this_time . '_create_' . $this->name . '.class.php';
		}
		return $this_time . '_' . $this->name . '.class.php';
	}

	public function get_contents() {
		$table = filename_to_tablename($this->name);
		$class = tablename_to_classname($this->name);
		$result = str_replace('<table>', $table, $this->template);
		$result = str_replace('<class>', $class, $result);
		return $result;
	}
}

