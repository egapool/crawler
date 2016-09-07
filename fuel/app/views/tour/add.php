<div id="main" class="left history-detail">
<?php if ( !isset($site)): ?>
    ←サイトを選んでね！
<?php else: ?>
    <div id="siteInfo">
		<span class="name"><?php echo $site['name'] ?></span>
		<span class="url"><?php echo $site['url'] ?></span>
    </div>
    <h1>ツアープランナー</h1>
    <form class="" action="/tour/add/<?php echo $history['id']; ?>" method="post">
        <div class="conditions">
            <p>
                プリオリティ： <?php echo is_null($history['conditions']['priority'])?"全て":$history['conditions']['priority']."以上"; ?>
            </p>
            <p>
                タグ：<?php foreach($history['conditions']['tags'] as $tag ):?><span class=""><?php echo $tag; ?><span><?php endforeach;?>
            </p>
            <p>
                フリーワード：<?php foreach($history['conditions']['freeWord'] as $word ):?><span class=""><?php echo $word; ?><span><?php endforeach;?>
            </p>
        </div>
        <div class="">
            <p>いけてるツアー名をつけてください</p>
            <input type="text" name="tour_name" value="">
        </div>
        <div class="">
            <button type='submit' name='action' value='send'>送信</button>
        </div>
    </form>
    <p>
        ツアー内容
    </p>
    <table>
        <thead>
            <tr>
                <th class="page-list-title">title</th>
                <th class="page-list-url">url</th>
                <th class="page-list-priority">優先度</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ( $pages as $page ): ?>
        <tr>
            <td><?php echo $page['title'] ?></td>
            <td><a href="<?php echo $site['url'].$page['url']; ?>" target="_blank"><?php echo $page['url'] ?></a></td>
            <td class="priority-stars-<?php echo $page['priority']; ?>"></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
</div>
