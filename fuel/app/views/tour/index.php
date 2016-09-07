<div id="main" class="left history-detail">
<?php if ( !isset($site)): ?>
    ←サイトを選んでね！
<?php else: ?>
    <div id="siteInfo">
		<span class="name"><?php echo $site['name'] ?></span>
		<span class="url"><?php echo $site['url'] ?></span>
    </div>
    <h1>楽しいツアーリスト</h1>
    <table class="table">
        <thead>
            <tr>
                <th>ツアーID</th>
                <th>サイト</th>
                <th>ユーザー</th>
                <th>タイトル</th>
                <th>重要度</th>
                <th>タグ</th>
                <th>絞込み</th>
                <th>件数</th>
                <th>ツアーURL</th>
                <th>jenkins shell</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ( $tours as $v ): ?>
            <tr>
                <td><?php echo $v['id'] ?></td>
                <td><?php echo $v['site_name'] ?></td>
                <td><?php echo $v['user_id'] ?></td>
                <td><?php echo $v['title'] ?></td>
                <td><?php echo is_null($v['conditions']['priority']) ? "ALL" : $v['conditions']['priority']."以上"; ?></td>
                <td>
                <?php foreach ( $v['conditions']['tags'] as $tag ): ?>
                    <span class="label"><?php echo $tag; ?></span>
                <?php endforeach; ?>
                </td>
                <td style="font-style:italic;"><?php foreach($v['conditions']['freeWord'] as $word): ?>"<?php echo $word ?>"<?php endforeach; ?></td>
                <td><?php echo $v['count']; ?></td>
                <td><?php echo Uri::base()."tour/enjoy/".$v['enjoykey']; ?></td>
                <td><input class="code" onclick="this.select();" type="input" value="curl <?php echo Uri::base()."tour/enjoy/".$v['enjoykey']; ?>"/></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
</div>
