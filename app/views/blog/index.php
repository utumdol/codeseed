<table id="list">
	<thead>
		<tr>
			<th class="title subject">제목</th>
			<th class="title date">수정일</th>
		</tr>
	</thead>
	<tbody>
		<?php
		foreach($this->list as $article) {
		?>
		<tr>
			<td class="subject"><a href="/blog/view/<?= $article->id ?>"><?= h($article->subject) ?></a><?= get_comment_count($this->comment_counts, $article->id) ?></td>
			<td class="date"><?= date('m-d H:i', $article->updated_at) ?></td>
		</tr>
		<?php
		}
		?>
	</tbody>
</table>
<?
$this->load_view('layout/_paging');
?>
<div class="menu_area">
	<span>[<a href="/blog/index">처음으로</a>]</span><span>[<a href="/blog/post_form">등록하기</a>]</span>
</div>

