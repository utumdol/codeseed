<?php
/**
 * get default value for form.
 * form에서 입력값을 출력할 경우에만 사용하도록 합니다.
 * 
 * form_value($obj, $prop1, $prop2, ...) means $obj->prop1->prop2.
 * form_value($arr, $idx1, $idx2, ...) means $arr[$idx1][$idx2].
 */
function form_value(/* $obj, $prop1, $prop2, ... or $arr, $idx1, $idx2, ...*/) {
	$args = func_get_args();
	if (empty($args)) {
		return null;
	}

	$props = array_slice($args, 1);
	if (empty($props)) {
		return $args;
	}

	// 사용자가 입력한 수정값 보존을 위해 플래시(1회성 세션)에서 우선 검색한다.
	$flash = Context::get('flash');
	$old_params = array_value($flash->get('_old_params'), $props);
	if (isset($old_params)) {
		return $old_params;
	}

	if (is_array($args[0])) {
		return array_value($args[0], array_slice($args, 1));
	}

	if (is_object($args[0])) {
		return object_value($args[0], array_slice($args, 1));
	}

	return null;
}

/**
 * 라디오 버튼 출력
 */
function input_radio($name, $values = array(), $checked_value = '',  $id = '', $class = '') {
	foreach($values as $value) {
		$checked = ($value == $checked_value) ? 'checked="checked" ' : '';
		echonl("<input type=\"radio\" name=\"{$name}\" id=\"{$id}\" class=\"{$class}\" value=\"{$value}\" {$checked}/>");
	}
}

/**
 * 셀렉트 박스 출력
 */
function input_select($name, $options = array(), $selected_value = '',  $id = '', $class = '') {
	echonl("<select name=\"{$name}\" id=\"{$id}\" class=\"{$class}\">");
	foreach($options as $value => $html) {
		$selected = ($value == $selected_value) ? 'selected="selected" ' : '';
		echonl("<option value=\"{$value}\" {$selected}>{$html}</option>");
	}
	echonl("</select>");
}

