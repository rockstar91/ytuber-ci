<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th style="width: 70px;">#</th>
            <th style="width: 180px;">Система</th>
            <th style="width: 180px;">Сумма (руб.)</th>
            <th>Баллы</th>
            <th style="width: 180px;">Время</th>
        </tr>
    </thead>
    <tbody>
    <?php if($results) : ?> 
	<?php foreach($results as $item) : ?>
		<tr>
			<td><?php echo $item->id; ?></td>
			<td><?php echo $item->name; ?></td>
			<td><?php echo $item->amount; ?></td>
			<td><?php echo $item->sum; ?></td>
			<td><?php echo date('Y-m-d H:i:s', $item->time); ?></td>
		</tr>
	<?php endforeach; ?>
	<?php else : ?>
		<tr><td colspan="5" style="text-align: center;">Нет записей.</td></tr>
	<?php endif; ?>
    </tbody>
</table>

<?php echo $pagination; ?>