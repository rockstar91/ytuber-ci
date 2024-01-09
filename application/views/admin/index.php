<h3>Пользователи</h3>
<ul>
	<li><?=anchor('admin/users', 'Все пользователи');?></li>
	<?php if($this->user->admin) : ?>
	<li><?=anchor('admin/users_top_purchase', 'ТОП по оплатам');?></li>
	<li><?=anchor('admin/payments', 'Оплаты');?></li>
    <li><?=anchor('admin/payout', 'Выплаты');?></li>
    <li><?=anchor('admin/refunds', 'Возвраты');?></li>
	<?php endif; ?>
	<li>
		<?=anchor('admin/users_top', 'ТОП по выполнениям задач');?>
		<ul>
			<li><?=anchor('admin/users_top/'.TASK_VIEW, 'по просмотрам');?></li>
			<li><?=anchor('admin/users_top/'.TASK_LIKE, 'по лайкам');?></li>
			<li><?=anchor('admin/users_top/'.TASK_COMMENT, 'по комментам');?></li>
			<li><?=anchor('admin/users_top/'.TASK_SUBSCRIBE, 'по подпискам');?></li>
			<li><?=anchor('admin/users_top/'.TASK_GPSHARE, 'по G+');?></li>
		</ul>
	</li>
</ul>

<h3>Логи Cron</h3>
<ul>
	<li><?=anchor('admin/cron_log/subscribe', 'Штрафы по подпискам');?></li>
	<li><?=anchor('admin/cron_log/like', 'Штрафы по лайкам');?></li>
</ul>
<br/>
<h3>Забанить пользователей через каналы</h3>
<div class="form-group">
<?=form_open('admin/banByChannels'); ?>
<textarea name="channelList" value="" type="text" class="textarea" style="width:300px; height:240px">
</textarea>
<br/>
 <button type="submit" class="btn btn-default">Забанить пользователей</button>
 </form>
</div>
<h3>Открыть пользователя через канал</h3>
<div class="form-group">
<?=form_open('admin/goToUserFromChannel'); ?>
<input class="form-control" name="userchannel" value="" placeholder="" style="width:300px">
<br/>
 <button type="submit" class="btn btn-default">Открыть пользователя</button>
 </form>
</div>