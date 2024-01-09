<ul>
	<li><?=anchor('admin/user_info/'.$id, 'Информация');?></li>
	<li><?=anchor('admin/user_channelinfo/'.$id, 'Канал');?></li>
	<li><?=anchor('admin/user_tasks/'.$id, 'Задачи');?></li>
    <li><?=anchor('admin/user_payments/'.$id, 'Оплаты');?></li>
    <li><?=anchor('admin/user_refunds/'.$id, 'Возвраты');?></li>
    <li><?=anchor('admin/user_stat/'.$id, 'Статистика');?></li>
	<li><?=anchor('admin/user_comment_penaltys/'.$id, 'Штрафы по комментариям');?></li>
	<li><?=anchor('admin/user_subsribe_penaltys/'.$id, 'Штрафы по подпискам');?></li>
</ul>

<?=form_open('admin/user_ban'); ?>

    <div class="form-group">
        <input class="form-control" name="user_id" value="<?php echo $id;?>" placeholder="">
    </div>

    <div class="form-group">
        <input class="form-control" name="reason" placeholder="">
    </div>

    <button type="submit" class="btn btn-default">Ban</button>
</form>
<?=anchor('admin/user_unban/'.$id, 'Разбанить');?>
<br />
<?=anchor('admin/setactivity/'.$id, 'Выставит активность 1');?>
<br />
<?=anchor('admin/checkactivity/'.$id, 'Проверить и выставить активность');?>
<br />
<?=anchor('admin/user_noavatar/'.$id, 'Забанить на 1 день, нет аватарки');?>
<br />
<?=anchor('admin/user_recaptha_score_change/'.$id, 'Поставить рекапча оценку 0.9');?>
