<div class="pagination pagination-centered">
	<ul>
		<?php
		$pages = $this->paging->pages;
		if (!$this->paging->is_first_frame) {
			/*
			$link = $this->paging->get_link(1);
			echo '<li><a href=\'' . $link . '\'>FIRST</a></li>';
			*/
			$link = $this->paging->get_link($pages[0] - 1);
			echo '<li><a href=\'' . $link . '\'>&laquo;</a></li>';
		}
		foreach ($pages as $page) {
			if ($this->paging->cur_page == $page) {
				echo '<li class="active"><a href="#">' . $page . '</a></li>';
			} else {
				$link = $this->paging->get_link($page);
				echo '<li><a href=\'' . $link . '\'>' . $page . '</a></li>';
			}
		}
		if (!$this->paging->is_last_frame) {
			$link = $this->paging->get_link(array_pop($pages) + 1);
			echo '<li><a href=\'' . $link . '\'>&raquo;</a></li>';
			/*
			$link = $this->paging->get_link($this->paging->get_last_page());
			echo '<li><a href=\'' . $link . '\'>LAST</a></li>';
			*/
		}
		?>
	</ul>
</div>

