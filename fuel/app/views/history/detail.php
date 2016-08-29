<div id="main" class="left history-detail">
    <div id="siteInfo">
		<span class="name"><?php echo $site['name'] ?></span>
		<span class="url"><?php echo $site['url'] ?></span>
    </div>
    <h1>クローリング詳細</h1>
    <table class="table">
        <thead>
            <tr>
                <th></th>
                <th>サイト</th>
                <th>プライオリティ</th>
                <th>タグ</th>
                <th>絞込み</th>
                <th>総件数</th>
                <th>開始時刻</th>
                <th>終了時刻</th>
            </tr>
        </thead>
        <tbody>
            <?php echo View::forge('history/_history_line',['v'=>$history]); ?>
        </tbody>
    </table>
    <p><a href="/history">一覧に戻る</a></p>
    <table class="table">
        <thead>
            <tr>
                <th>デバイス</th>
                <th>url(1回目)</th>
                <th>ステータス</th>
                <th>url(2回目)</th>
                <th>ステータス</th>
                <th>url(3回目)</th>
                <th>ステータス</th>
                <th>title</th>
                <th>h1</th>
                <th>keywords</th>
                <th>description</th>
                <th>noindex</th>
                <th>canonical</th>
                <th>next</th>
                <th>prev</th>
                <th>日時</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ( $logs as $v ): ?>
            <tr>
                <td>PC</td>
                <td><a href="<?php echo $v['url1']; ?>" target="_blank"><?php echo $v['url1']; ?></a></td>
                <td><?php echo $v['status_code1']; ?></td>
                <td><a href="<?php echo $v['url2']; ?>" target="_blank"><?php echo $v['url2']; ?></a></td>
                <td><?php echo $v['status_code2']; ?></td>
                <td><a href="<?php echo $v['url3']; ?>" target="_blank"><?php echo $v['url3']; ?></a></td>
                <td><?php echo $v['status_code3']; ?></td>
                <td><?php echo $v['title']; ?></td>
                <td><?php echo $v['h1']; ?></td>
                <td><?php echo $v['keywords']; ?></td>
                <td><?php echo $v['description']; ?></td>
                <td><?php echo $v['noindex']; ?></td>
                <td><?php echo $v['canonical']; ?></td>
                <td><?php echo $v['next']; ?></td>
                <td><?php echo $v['prev']; ?></td>
                <td><?php echo date('m/d H:i',strtotime($v['created_at'])); ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
