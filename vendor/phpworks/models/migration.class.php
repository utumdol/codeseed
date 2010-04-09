<?php
class Migration {

	public function Migration() {
		global $DATABASE;

		$this->database = $DATABASE;
	}

	public function create_table($table_name) {
		$this->database->execute("CREATE TABLE $table_name (id INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(id))");
	}

	public function drop_table($table_name) {
		$this->database->execute("DROP TABLE $table_name");
	}

	public function add_column($table_name, $name, $type, $size, $is_null = false) {
		$not_null = ($is_null) ? '' : 'NOT NULL'; 
		$this->database->execute("ALTER TABLE $table_name ADD COLUMN $name $type($size) $not_null");
	}

	public function drop_column($table_name, $name) {
		$this->database->execute("ALTER TABLE $table_name DROP COLUMN $name");
	}

	public function add_index($table_name, $name, $fields) {
		$this->database->execute("ALTER TABLE $table_name ADD INDEX $name ($fields)");
	}

	public function drop_index($table_name, $name) {
		$this->database->execute("ALTER TABLE $table_name DROP INDEX $name");
	}
}
?>
