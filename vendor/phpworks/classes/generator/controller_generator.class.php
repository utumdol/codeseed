<?php
class ControllerGenerator {

	// 1. mkdir app
	// 2. mkdir app/controller
	// 3. generate controller file with actions
	// 4. mkdir app/view
	// 5. mkdir app/view/controller
	// 6. generate app/view/controller file
	var $name;

	function ControllerGenerator($name) {
		$this->name = $name;
	}
}
?>