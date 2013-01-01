<?php
class Mysql {
	private $conn;

	private $host;
	private $user;
	private $passwd;
	private $name;

	private $types = array(
			'binary' => 'BLOB',
			'boolean' => 'TINYINT',
			'date' => 'DATE',
			'datetime' => 'DATETIME',
			'decimal' => 'DECIMAL',
			'float' => 'FLOAT',
			'integer' => 'INT',
			'string' => 'VARCHAR',
			'text' => 'TEXT',
			'time' => 'TIME',
			'timestamp' => 'DATETIME',
			'enum' => 'ENUM'
	);

	private $sizes = array(
			'binary' => '',
			'boolean' => '1',
			'date' => '',
			'datetime' => '',
			'decimal' => '',
			'float' => '',
			'integer' => '11',
			'string' => '255',
			'text' => '',
			'time' => '',
			'timestamp' => '',
			'enum' => ''
	);

	private $value_functions = array(
			'BLOB' => 'strval',
			'TINYINT' => 'intval',
			'DATE' => 'strval',
			'DATETIME' => 'strval',
			'DECIMAL' => 'floatval',
			'FLOAT' => 'floatval',
			'INT' => 'intval',
			'VARCHAR' => 'strval',
			'TEXT' => 'strval',
			'TIME' => 'strval',
			'TIMESTAMP' => 'strval',
			'ENUM' => 'strval'
	);

	public function __construct($host, $user, $passwd, $name) {
		$this->host = $host;
		$this->user = $user;
		$this->passwd = $passwd;
		$this->name = $name;
	}

	public function connect() {
		if (!function_exists('mysqli_connect')) {
			throw new ProcessingError('class mysqli_connect doesn\'t exist: no MySQL interface');
		}
		$this->conn = mysqli_connect($this->host, $this->user, $this->passwd, $this->name);
		if (mysqli_connect_error()) {
			throw new ProcessingError('DB 연결 에러(' . mysqli_connect_errorno() . ') - ' . mysqli_connect_error());
		}
	}

	public function close() {
		mysqli_close($this->conn);
	}

	public function execute($query, $params = array()) {
		$query = $this->bind_params($query, $this->escape_array($params));
		Log::debug($query);
		$result = mysqli_query($this->conn, $query);
		if (!$result) {
			throw new ProcessingError('Could not run query: ' . $this->error());
		}
		return $result;
	}

	private function escape_array($params = array()) {
		$result = array();
		foreach($params as $param) {
			if (is_null($param)) {
				$result[] = 'null';
				continue;
			}

			$quote = '';
			if (is_string($param)) {
				$quote = "'";
			}
			$result[] = $quote . $this->escape_string($param) . $quote;
		}
		return $result;
	}

	public function escape_string($param) {
		return mysqli_real_escape_string($this->conn, $param);
	}

	private function bind_params($query, $params = array()) {
		if (empty($params)) {
			return $query;
		}
		$result = '';
		$querys = explode('?', $query);
		for ($i = 0; $i < count($querys) - 1; $i++) {
			$result .= $querys[$i];
			$result .= $params[$i];
		}
		$result .= $querys[$i]; // add last one
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

	public function get_type($type) {
		return $this->types[strtolower($type)];
	}

	public function get_size($type) {
		return $this->sizes[strtolower($type)];
	}

	public function get_value($type, $value) {
		if (is_null($value)) {
			return null;
		}

		$func = $this->value_functions[strtoupper(preg_replace('/\(.*\)/', '', $type))]; // remove '(...)' in type string.
		return call_user_func($func, $value);
	}

	///////////////////////////////////////////////////////////////////////////
	// DML
	///////////////////////////////////////////////////////////////////////////

	/**
	 * @param $query Query object
	 * @return a result object
	 */
	public function select($query) {
		// make condition
		$where = '';
		if (!is_blank($query->where)) {
			$where = ' WHERE ' . $query->where;
		}
		$order = '';
		if (!is_blank($query->order)) {
			$order = ' ORDER BY ' . $query->order;
		}
		$limit = '';
		if (!is_blank($query->offset) && !is_blank($query->limit)) {
			$limit = " LIMIT $query->offset, $query->limit";
		}
		$group = '';
		if (!is_blank($query->group)) {
			$group = ' GROUP BY ' . $query->group;
		}
		$having = '';
		if (!is_blank($query->having)) {
			$having = ' HAVING ' . $query->having;
		}

		$result = $this->execute('SELECT ' . $query->select . ' FROM ' . $query->from . $query->join . $where . $group . $having . $order . $limit, $query->params);
		return $result;
	}

	/**
	 * @param $query Query object
	 * @return true on success, false on failure
	 */
	public function delete($query) {
		// make condition
		$where = '';
		if (!is_blank($query->where)) {
			$where = ' WHERE ' . $query->where;
		}

		// delete
		$result = $this->execute('DELETE FROM ' . $query->from . $where, $query->params);
		return $result;
	}

	/**
	 * @return true on success, false on failure
	 */
	public function insert($query) {
		$result = $this->execute('INSERT INTO ' . $query->from . ' (' . implode(', ', $query->column_names) . ') VALUES (' . implode(', ', $query->values) . ')', $query->params);
		return $result;
	}

	/**
	 * @return true on success, false on failure
	 */
	public function update($query) {
		$where = '';
		if (!is_blank($query->where)) {
			$where = ' WHERE ' . $query->where;
		}

		$pairs = array();
		$i = 0;
		foreach($query->column_names as $name) {
			$value = $query->values[$i++];
			$pairs[] = "$name  = $value";
		}

		$result = $this->execute('UPDATE ' . $query->from . ' SET ' . implode(', ', $pairs) . $where, $query->params);
		return $result;
	}

	/**
	 * @return a table columns array
	 */
	public function get_table_columns($table_name) {
		$table = array();

		$cache = apc_fetch($table_name);
		if ($cache !== false) {
			return $cache;
		}

		$result = $this->execute('SHOW COLUMNS FROM ' . $table_name);
		while ($row = $this->fetch($result)) {
			$schema = new Column();
			$schema->name = $row['Field'];
			$schema->type = $row['Type'];
			$table[] = $schema;
		}
		$this->free_result($result);

		apc_store($table_name, $table);
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
	 * @return true on success, false on failure
	 */
	public function create_table($table_name) {
		$type = $this->get_type('integer');
		$size = $this->get_size('integer');
		return $this->execute("CREATE TABLE $table_name (id $type($size) NOT NULL AUTO_INCREMENT, PRIMARY KEY(id))");
	}

	/**
	 * @return true on success, false on failure
	 */
	public function drop_table($table_name) {
		$this->execute("DROP TABLE $table_name");
	}

	/**
	 * @param $scale the number of digits to the right of the decimal point
	 * @return true on success, false on failure
	 */
	public function add_column($table_name, $name, $type, $is_null = true, $size = null, $default = null, $scale = null) {
		$not_null = ($is_null) ? '' : 'NOT NULL';
		$new_type = $this->get_type($type);
		$new_size = (empty($size)) ? $this->get_size($type) : $size;

		// support the size of decimal type
		if ($type == 'decimal' && !is_null($scale)) {
			$new_size .= ", $scale";
		}

		if (!is_blank($new_size)) {
			$new_size = "($new_size)";
		}

		$default = (is_null($default)) ? '' : 'DEFAULT ' . $default;
		$this->execute("ALTER TABLE $table_name ADD COLUMN $name $new_type$new_size $default $not_null");
	}

	/**
	 * @return true on success, false on failure
	 */
	public function remove_column($table_name, $name) {
		$this->execute("ALTER TABLE $table_name DROP COLUMN $name");
	}

	/**
	 * @return true on success, false on failure
	 */
	public function change_column($table_name, $name, $type, $is_null = true, $size = null) {
		$not_null = ($is_null) ? '' : 'NOT NULL';
		$new_type = $this->get_type($type);
		$new_size = (empty($size)) ? $this->get_size($type) : $size;

		// support the size of decimal type
		if ($type == 'decimal' && !is_null($scale)) {
			$new_size .= ", $scale";
		}

		if (!is_blank($new_size)) {
			$new_size = "($new_size)";
		}

		$this->execute("ALTER TABLE $table_name MODIFY $name $new_type$new_size $not_null");
	}

	/**
	 * @return true on success, false on failure
	 */
	public function add_index($table_name, $name, $columns, $is_unique) {
		$unique = ($is_unique) ? 'UNIQUE' : '';
		$this->execute("ALTER TABLE $table_name ADD $unique INDEX $name ($columns)");
	}

	/**
	 * @return true on success, false on failure
	 */
	public function remove_index($table_name, $name) {
		$this->execute("ALTER TABLE $table_name DROP INDEX $name");
	}
}

