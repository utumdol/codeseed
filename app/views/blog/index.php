<table>
<thead>
<tr>
	<th>id</th>
	<th>subject</th>
</tr>
</thead>
<tbody>
<?php
foreach($this->list as $article) {
?>
<tr>
	<td><a href="/blog/view/<?= $article->id ?>"><?= $article->id ?></a></td>
	<td><a href="/blog/view/<?= $article->id ?>"><?= $article->subject ?></a></td>
</tr>
<?php
}
?>
</tbody>
</table>
<?
$this->load_view('layout/_paging');
?>
<div class="menu">
	<span>[<a href="/blog/index">처음으로</a>]</span><span>[<a href="/blog/post_form">등록하기</a>]</span>
</div>

