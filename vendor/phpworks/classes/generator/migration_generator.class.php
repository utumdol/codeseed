<?php
class MigrationGenerator extends Generator {
	public $path;
	public $template = '<?php
class <class> extends Migration {
	public function up() {

	}

	public function down() {

	}
}

';
	private $from;
	private $table_template = '<?php
class Create<class> extends Migration {
	public function up() {
		$this->create_table(\'<table>\');
		// $this->add_column(\'<table>\', \'name\', \'string\', true, \'255\');
	}

	public function down() {
		$this->drop_table(\'<table>\');
	}
}

';

	public function __construct($name, $from = '') {
		parent::__construct($name);
		$this->path = Config::get('migr_dir');
		$this->from = $from;
		if ($this->from == 'model') {
			$this->template = $this->table_template;
		}
	}

	public function get_filename() {
		$this_time = date('YmdHis');
		if ($this->from == 'model') {
			return $this_time . '_create_' . classname_to_filename($this->name) . '.class.php';
		}
		return $this_time . '_' . classname_to_filename($this->name) . '.class.php';
	}

	public function get_contents() {
		$table = classname_to_tablename($this->name);
		$class = tablename_to_classname($this->name);
		$result = str_replace('<table>', $table, $this->template);
		$result = str_replace('<class>', $class, $result);
		return $result;
	}
}

