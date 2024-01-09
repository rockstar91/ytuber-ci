<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th style="width: 70px;">#</th>
            <th style="width: 180px;">User id</th>
            <th>Система</th>
            <th>Сумма (руб)</th>
            <th>Кол-во баллов</th>
            <th>Дата оплаты</th>
        </tr>
    </thead>
    <tbody>
    <?php if($results) : ?> 
	<?php foreach($results as $item) : ?>
		<tr>
            <td><?php echo $item->id; ?></td>
            <td><?php echo anchor('admin/user/'.$item->user_id, $item->user_id); ?></td>
            <td><?php 
			
			if($item->payment_system_id == 1){
			echo 'Банковские карты';
			}
			if($item->payment_system_id == 2){
			echo 'Яндекс деньги';
			}
			if($item->payment_system_id == 3){
			echo 'W1';
			}
			if($item->payment_system_id == 4){
			echo 'Webmoney';
			}
			?></td>
            <td><?php echo $item->amount; ?></td>
            <td><?php echo $item->sum; ?></td>
            <td><?php echo date('Y-m-d H:i:s', $item->time); ?></td>
		</tr>
	<?php endforeach; ?>
    <?php else : ?>
        <tr><td colspan="7" style="text-align: center;">Нет пользователей.</td></tr>
    <?php endif; ?>
    </tbody>
</table>

<?php echo $pagination; ?>