<?php
class FlashElement {
	var $name;
	var $value;
	var $life;

	public function FlashElement($name = '', $value = '', $life = 1) {
		$this->name = $name;
		$this->value = $value;
		$this->life = $life;
	}
}

