<script>
    function payedUpdate(payout_id) {
        $.ajax({
            method:'GET',
            cache: false,
            url: '/admin/payout',
            data: { 'payout_id': payout_id},
            success: function (response) {
                
                if(typeof(response.date)=='undefined'){
                    return;
                }
                $('.payout_'+payout_id+' > .payed').html(response.date);
                alert(response.date);
                  
            },
            error: function (response) {}
        });
        return false;
    }
</script>

<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th style="width: 70px;">#</th>
            <th style="width: 180px;">User id</th>
            <th>Система</th>
            <th>Счет</th>
            <th>Сумма (руб)</th>
            <th>Дата запроса</th>
            <th>Дата выплаты</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    <?php if($result) : ?> 
	<?php foreach($result as $item) : ?>
		<tr class="payout_<?=$item->id;?>">
            <td><?php echo $item->id; ?></td>
            <td><?php echo anchor('admin/user_info/'.$item->user_id, $item->user_id); ?></td>
            <td><?php echo $item->system; ?></td>
            <td><?php echo $item->account; ?></td>
            <td><?php echo $item->rub; ?></td>
            <td><?php echo $item->created; ?></td>
            <td class="payed"><?php echo $item->payed; ?></td>
            <td>
                <button type="button" class="btn btn-info btn-circle" onclick="payedUpdate(<?=$item->id;?>);"><i class="fa fa-check"></i></button>
            </td>
		</tr>
	<?php endforeach; ?>
    <?php else : ?>
        <tr><td colspan="8" style="text-align: center;">Нет элементов.</td></tr>
    <?php endif; ?>
    </tbody>
</table>

<?php echo $pagination; ?>