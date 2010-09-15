<?php
class Generator {
	private $name = '';
	private $path = '';
	private $template = '';

	public function __construct($name) {
		$this->name = $name;
	}

	public function generate() {
		$this->validation();
		$this->generate_path();
		$this->generate_file();
	}

	public function validation() {
		if (file_exists($this->get_path() . '/' . $this->get_filename())) {
			throw new ValidationError(abbr_path($this->get_path() . '/' . $this->get_filename()) . ' is already exists.');
		}
	}

	public function get_path() {
		return $this->path;
	}

	public function get_filename() {
		return $this->name . '.php';
	}

	public function get_contents() {
		return $this->template;
	}

	public function generate_path() {
		if (is_dir($this->get_path())) {
			echonl('exist ' . abbr_path($this->get_path()));
		} else {
			echonl('generate ' . abbr_path($this->get_path()));
			mkdir($this->get_path(), 0755, true);
		}
	}

	public function generate_file() {
		$filename = $this->get_filename();
		$content = $this->get_contents();
		echonl('generate ' . abbr_path($this->get_path()) . '/' . $filename);
		$f = fopen($this->get_path() . '/' . $filename, 'w');
		fwrite($f, $content, strlen($content)); 
		fclose($f);
	}
}

