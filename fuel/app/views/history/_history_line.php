<tr>
    <td><a class="btn btn-blue" href="/history/<?php echo $v['id']; ?>">詳細</a></td>
    <td><?php echo $v['site_name']; ?></td>
    <td><?php echo is_null($v['conditions']['priority']) ? "ALL" : $v['conditions']['priority']."以上"; ?></td>
    <td>
    <?php foreach ( $v['conditions']['tags'] as $tag ): ?>
        <span class="label"><?php echo $tag; ?></span>
    <?php endforeach; ?>
    </td>
    <td style="font-style:italic;"><?php foreach($v['conditions']['freeWord'] as $word): ?>"<?php echo $word ?>"<?php endforeach; ?></td>
    <td><?php echo $v['count']; ?></td>
    <td><?php echo $v['start_at']; ?></td>
    <td><?php echo $v['finish_at']; ?></td>
</tr>
