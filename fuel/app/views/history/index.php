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
                <th>開始時刻</th>
                <th>終了時刻</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ( $list as $v ): ?>
            <tr>
                <td><a class="btn btn-blue" href="/history/<?php echo $v['id']; ?>">詳細</a></td>
                <td><?php echo $v['site_name']; ?></td>
                <td><?php echo is_null($v['conditions']['priority']) ? "ALL" : $v['conditions']['priority']."以上"; ?></td>
                <td>
                <?php foreach ( $v['conditions']['tags'] as $tag ): ?>
                    <span class="label"><?php echo $tag; ?></span>
                <?php endforeach; ?>
                </td>
                <td><?php echo $v['count']; ?></td>
                <td><?php echo $v['start_at']; ?></td>
                <td><?php echo $v['finish_at']; ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
</div>
