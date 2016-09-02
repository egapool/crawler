<div id="main" class="left">
    <?php if ($result != "" ): ?>
        <p><?php echo $result; ?></p>
    <?php endif; ?>
    <h2>ページ登録</h2>
    <form class="" action="" method="post" enctype="multipart/form-data">
        <div class="">
            <p>サイトを選択</p>
            <select class="/pageinseart" name="site_id">
                <?php foreach ( $sites as $site ): ?>
                <option value="<?php echo $site['id']; ?>"><?php echo $site['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="">
            <p>エクセルファイルをアップロード</p>
            <input type="file" name="file" value="">
        </div>
        <div class="">
            <button type='submit' name='action' value='send'>送信</button>
        </div>
    </form>
</div>
