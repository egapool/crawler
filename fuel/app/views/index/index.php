<div id="main" class="left">
	<?php if ( !isset($site)): ?>
        ←サイトを選んでね！
    <?php else: ?>
	<div id="siteInfo">
		<span class="name"><?php echo $site['name'] ?></span>
		<span class="url"><?php echo $site['url'] ?></span>
	</div>
	<div id="search">
		<p class="priority">
			探索レベル：<span class="search-post selected" data-priority="">ALL</span><span class="search-post" data-priority=1>1</span><span class="search-post" data-priority=2>2</span><span class="search-post" data-priority=3>3</span><span class="search-post" data-priority=4>4</span><span class="search-post" data-priority=5>5</span><span class="search-post" data-priority=6>6</span></p>
		<p class="tags">
		絞込タグ(タグ同士はOR検索)：
		<?php foreach ( $tags as $tag ): ?>
		<span class="search-post" data-tag="<?php echo $tag['id'] ?>"><?php echo $tag['name'] ?></span>
		<?php endforeach; ?>
		</p>
		<p class="free-word">
			<input class="search-post" type="text" name="freetext" value="" placeholder="絞込みフリーワード(URL)">
		</p>
	</div>
	<div id="pages">
		<p class="pages-info">調査件数：<span class="page-count"><?php echo $count; ?></span>件 / 終了予定は <span class="end-time"><?php echo $endTime;?></span> です</p>
		<p id="go">ツアーに出る</p>
		<div id="result-table">
			<table>
				<thead>
					<tr><th>title</th><th>url</th><th>優先度</th></tr>
				</thead>
				<tbody>
				<?php foreach ( $pages as $page ): ?>
				<tr>
					<td><?php echo $page['title'] ?></td>
					<td><?php echo $site['url'].$page['url'] ?></td>
					<td style="color:#dac41f;"><?php for($i=0;$i<$page['priority'];$i++): ?>★<?php endfor; ?></td>
				</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
	<?php endif; ?>
</div>
