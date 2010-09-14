<?php
class FlashElement {
	public $name;
	public $value;
	public $life;

	public function FlashElement($name = '', $value = '', $life = 1) {
		$this->name = $name;
		$this->value = $value;
		$this->life = $life;
	}
}

