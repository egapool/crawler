<div id="main" class="left">
    <?php if ( !isset($site)): ?>
        サイトを選んでね！
    <?php else: ?>
    <div id="siteInfo">
		<span class="name"><?php echo $site['name'] ?></span>
		<span class="url"><?php echo $site['url'] ?></span>
	</div>
    <h1>クローリング履歴</h1>
    <table class="table">
        <thead>
            <tr>
                <th></th>
                <th>サイト</th>
                <th>プライオリティ</th>
                <th>タグ</th>
                <th>絞込み</th>
                <th>件数</th>
                <th>開始時刻</th>
                <th>終了時刻</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ( $list as $v ): ?>
            <?php echo View::forge('history/_history_line',['v'=>$v]); ?>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
</div>
