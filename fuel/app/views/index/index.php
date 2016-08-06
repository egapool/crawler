<div id="main" class="left">
	<div id="siteInfo">
		<span class="name"><?php echo $site['name'] ?></span>
		<span class="url"><?php echo $site['url'] ?></span>
	</div>
	<div id="search">
		<p class="priority">
			探索レベル：<span class="" data-priority=1>1</span>
			<span class="" data-priority=2>2</span>
			<span class="" data-priority=3>3</span>
			<span class="" data-priority=4>4</span>
			<span class="" data-priority=5>5</span>
			<span class="" data-priority=6>6</span>
		</p>
		<ul class="tags">
		<?php foreach ( $tags as $tag ): ?>
			<li><span class="" data-tag="<?php echo $tag['id'] ?>"><?php echo $tag['name'] ?></span></li>
		<?php endforeach; ?>
		</ul>
	</div>
	<div id="pages">
		<p class="count"><?php echo $count; ?>件 / <?php echo $endTime;?>終了予定</p>
		<table>
			<thead>
				<tr><th>title</th><th>url</th><th>優先度</th></tr>
			</thead>
		<?php foreach ( $pages as $page ): ?>
			<tr>
			<tbody>
				<td><?php echo $page['title'] ?></td><td><?php echo $site['url'].$page['url'] ?></td><td><?php echo $page['priority']?></td>
			</tr>
			</tbody>
		<?php endforeach; ?>
		</table>
	</div>
</div>