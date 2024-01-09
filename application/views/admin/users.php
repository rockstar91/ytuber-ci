<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th style="width: 70px;">#</th>
            <th style="width: 180px;">Дата регистрации</th>
            <th>Имя</th>
            <th>E-mail</th>
            <th>Confirm</th>
            <th>Channel</th>
            <th style="width: 180px;">Выполнил заданий</th>
            <th style="width: 180px;">Заработал для вас</th>
        </tr>
    </thead>
    <tbody>
    <?php if($results) : ?> 
	<?php foreach($results as $item) : ?>
		<tr>
			<td><?php echo anchor('admin/user/'.$item->id, $item->id); ?></td>
			<td><?php echo $item->time; ?></td>
			<td><?php echo htmlspecialchars($item->name); ?></td>
            <td><?php echo $item->mail; ?></td>
            <td><?php echo $item->confirm; ?></td>
            <td>
                <?php 
                echo $item->channel ? anchor('admin/user_channelinfo/'.$item->id.'/snippet', $item->channel) : $item->channel;
                ?>
            </td>
			<td><?php echo $item->done; ?></td>
			<td><?php echo $item->earned; ?></td>
		</tr>
	<?php endforeach; ?>
    <?php else : ?>
        <tr><td colspan="7" style="text-align: center;">Нет пользователей.</td></tr>
    <?php endif; ?>
    </tbody>
</table>

<?php echo $pagination; ?>