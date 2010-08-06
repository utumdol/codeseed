<?php
class Paging {
	var $total;
	var $size;
	var $link;
	var $cur_page;
	var $frame_size;
	var $is_first_frame;
	var $is_last_frame;

	var $pages;
	var $start_page;
	var $end_page;

	public function Paging($total = 1, $size = 1, $link = '', $cur_page = 1, $frame_size = 10) {
		$this->total = $total;
		$this->size = $size;
		$this->link = $link;
		$this->cur_page = $cur_page;
		$this->frame_size = $frame_size;

		// init
		$this->start_page = $this->get_start_page();
		$this->end_page = $this->get_end_page();
		$this->pages = range($this->start_page, $this->end_page);
	}

	public function get_first_page() {
		return 1;
	}

	public function get_last_page() {
		if ($this->total == 0) {
			return 1;
		}
		return (int)(($this->total - 1) / $this->size) + 1;
	}

	public function get_start_page() {
		if ($this->cur_page > $this->get_last_page()) {
			$this->cur_page = $this->get_last_page();
		}
		$start_page = $this->cur_page - (($this->cur_page - 1) % $this->frame_size);
		if ($start_page == 1) {
			$this->is_first_frame = true;
		}
		return $start_page;
	}

	public function get_end_page() {
		$end_page = $this->get_start_page() + $this->frame_size - 1;
		$last_page = $this->get_last_page();
		if ($end_page >= $last_page) {
			$this->is_last_frame = true;
			return $last_page;
		} else {
			return $end_page;
		}
	}

	public function get_link($page = 1) {
		return str_replace('<page>', $page, $this->link);
	}
}

