<?php
class FlashElement {
	private $name;
	private $value;
	private $life;

	public function FlashElement($name = '', $value = '', $life = 1) {
		$this->name = $name;
		$this->value = $value;
		$this->life = $life;
	}
}

