<?php
/**
 * get default value for form.<br/>
 * get_default($obj, $prop1, $prop2, ...) means $obj->prop1->prop2.
 * get_default($arr, $idx1, $idx2, ...) means $arr[$idx1][$idx2].
 */
function get_default(/* $obj, $prop1, $prop2, ... or $arr, $idx1, $idx2, ...*/) {
	$args = func_get_args();
	if (empty($args)) {
		return null;
	}

	$props = array_slice($args, 1);
	if (empty($props)) {
		return $args;
	}

	// return old value first.
	$flash = Context::get('flash');
	$old_params = get_array_value($flash->get('old_params'), $props);
	if (isset($old_params)) {
		return $old_params;
	}

	if (is_array($args[0])) {
		return get_array_value($args[0], array_slice($args, 1));
	}

	if (is_object($args[0])) {
		return get_object_property($args[0], array_slice($args, 1));
	}

	return null;
}

function input_radio($name, $values = array(), $checked_value = '') {
	foreach($values as $value) {
		$checked = ($value == $checked_value) ? 'checked="checked" ' : '';
		echonl("<input type=\"radio\" name=\"{$name}\" value=\"{$value}\" {$checked}/>");
	}
}

function input_select($name, $options = array(), $selected_value = '',  $id = '') {
	echonl("<select name=\"{$name}\" id=\"{$id}\">");
	foreach($options as $value => $html) {
		$selected = ($value == $selected_value) ? 'selected="selected" ' : '';
		echonl("<option value=\"{$value}\" {$selected}>{$html}</option>");
	}
	echonl("</select>");
}

