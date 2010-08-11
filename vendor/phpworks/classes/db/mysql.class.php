<?php
class MySQL {
	var $conn;

	var $host;
	var $user;
	var $passwd;
	var $name;

	public function MySQL($host, $user, $passwd, $name) {
		$this->host = $host;
		$this->user = $user;
		$this->passwd = $passwd;
		$this->name = $name;
	}

	public function connect() {
		if (!function_exists('mysqli_connect')) {
			throw new ProcessingError('[FATAL] class mysqli_connect doesn\'t exist: no MySQL interface');
		}
		$this->conn = mysqli_connect($this->host, $this->user, $this->passwd, $this->name);
		if (mysqli_connect_error()) {
			throw new ProcessingError('DB 연결 에러(' . mysqli_connect_errorno() . ') - ' . mysqli_connect_error());
		}
	}

	public function close() {
		mysqli_close($this->conn);
	}

	public function execute($query) {
		$result = mysqli_query($this->conn, $query);
		if (!$result) {
			throw new ProcessingError('Could not run query: ' . $this->error());
		}
		return $result;
	}

	public function fetch($result) {
		return mysqli_fetch_array($result);
	}

	public function free_result($result) {
		return mysqli_free_result($result);
	}

	public function error() {
		return mysqli_error($this->conn);
	}

	public function real_escape_string($escapestr) {
		return mysqli_real_escape_string($this->conn, $escapestr);
	}

	///////////////////////////////////////////////////////////////////////////
	// DML
	///////////////////////////////////////////////////////////////////////////

	/**
	 * @return true or false
	 */
	public function insert($table_name, $names = array(), $values = array()) {
		$query = 'INSERT INTO ' . $table_name . ' (' . implode(', ', $names) . ') VALUES (' . implode(', ', $values) . ')';
		$result = $this->execute($query);

		return $result;
	}

	/**
	 * @return a result object
	 */
	public function select($select = '*', $table_name, $where = '', $group = '', $page = '', $size = '', $order = '') {
		// make condition
		if (!empty($where)) {
			$where = ' WHERE ' . $where;
		}
		if (!empty($order)) {
			$order = ' ORDER BY ' . $order;
		}
		$limit = '';
		if (!empty($page) && !empty($size)) {
			$page_start = ($page - 1) * $size;
			$limit = " LIMIT $page_start, $size";
		}
		if (!empty($group)) {
			$group = ' GROUP BY ' . $group;
		}

		$result = $this->execute('SELECT ' . $select . ' FROM ' . $table_name . $where . $group . $order . $limit);
		return $result;
	}

	/**
	 * @return true or false
	 */
	public function update($table_name, $names = array(), $values = array(), $where = '') {
		if (!empty($where)) {
			$where = ' WHERE ' . $where;
		}

		$paris = array();
		$i = 0;
		foreach($names as $name) {
			$value = $values[$i++];
			$pairs[] = "$name  = $value";
		}

		$query = 'UPDATE ' . $table_name . ' SET ' . implode(', ', $pairs) . $where;
		$result = $this->execute($query);

		return $result;
	}

	/**
	 * @return true or false
	 */
	public function delete($table_name, $where = '') {
		if (!empty($where)) {
			$where = ' WHERE ' . $where;
		}

		// delete
		$query = 'DELETE FROM ' . $table_name . $where;
		$result = $this->execute($query);

		return $result;
	}

	/**
	 * @return a result object
	 */
	public function get_table_schema($table_name) {
		$table = array();
		$result = $this->execute('SHOW COLUMNS FROM ' . $table_name);
		while ($row = $this->fetch($result)) {
			$schema = new Field();
			$schema->name = $row['Field'];
			$schema->type = $row['Type'];
			$table[] = $schema;
		}
		$this->free_result($result);
		return $table;
	}

	/**
	 * @return a result object
	 */
	public function get_tables() {
		$tables = array();
		$result = $this->execute('SHOW TABLES FROM ' . $this->name);
		while ($row = $this->fetch($result)) {
			$tables[] = $row[0];
		}
		$this->free_result($result);
		return $tables;
	}

	///////////////////////////////////////////////////////////////////////////
	// DDL
	///////////////////////////////////////////////////////////////////////////

	/**
	 * @return true or false
	 */
	public function create_table($table_name) {
		return $this->execute("CREATE TABLE $table_name (id INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(id))");
	}

	/**
	 * @return true or false
	 */
	public function drop_table($table_name) {
		$this->execute("DROP TABLE $table_name");
	}

	/**
	 * @return true or false
	 */
	public function add_column($table_name, $name, $type, $size, $is_null = true) {
		$not_null = ($is_null) ? '' : 'NOT NULL'; 
		$this->execute("ALTER TABLE $table_name ADD COLUMN $name $type($size) $not_null");
	}

	/**
	 * @return true or false
	 */
	public function drop_column($table_name, $name) {
		$this->execute("ALTER TABLE $table_name DROP COLUMN $name");
	}

	/**
	 * @return true or false
	 */
	public function add_index($table_name, $name, $fields) {
		$this->execute("ALTER TABLE $table_name ADD INDEX $name ($fields)");
	}

	/**
	 * @return true or false
	 */
	public function drop_index($table_name, $name) {
		$this->execute("ALTER TABLE $table_name DROP INDEX $name");
	}
}

