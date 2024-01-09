
<div class="panel panel-info">
    <div class="panel-heading">
    	<i class="fa fa-info-circle fa-1x"></i>
    	<?php echo $this->lang->line('list_info'); ?>
    </div>
</div>

<div class="table-responsive">
<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th><?php echo $this->lang->line('name'); ?></th>
            <th><?php echo $this->lang->line('type'); ?></th>
            <th><?php echo $this->lang->line('total_cost'); ?></th>
            <th style="width: 150px;"><?php echo $this->lang->line('action_cost'); ?></th>
            <th><?php echo $this->lang->line('complete_penalty'); ?></th>
            <th><?php echo $this->lang->line('manage'); ?></th>
        </tr>
    </thead>
    <tbody>
    <?php if($results) : ?> 
	<?php foreach($results as $item) : ?>
		<tr<?php if($item->total_cost < $item->action_cost) {echo ' class="done"';} else if($item->disabled) {echo ' class="warning danger"';} ?>>
			<td><a href="https://www.google.com/url?sa=t&rct=j&q=&esrc=s&source=web&cad=rja&url=<?php echo $item->url; ?>" target="_blank"><?php echo $item->name; ?></a><p style="margin: 0;"><?php echo $item->category; ?></p></td>
			<td><?php echo $item->type; ?></td>
			<td><?php echo $item->total_cost; ?></td>
			<td><?php echo $item->action_cost; ?></td>
			<td>
				<?php 
				$action_done 	= $item->action_done - $item->action_fail - $item->action_refund; 
				$action_total 	= floor($item->total_cost / $item->action_cost) + $action_done;
				echo $action_done . '&nbsp;/&nbsp;' . $action_total; 
				?>
				<?php if($item->action_fail > 0 && $this->user->admin) : ?>
                                
				<i class="fa fa-exclamation-circle fa-fw" data-toggle="tooltip" data-placement="right" title="" data-original-title="<?php printf($this->lang->line('penalty_tip'), $item->action_fail, $item->action_fail*$item->action_cost); ?>"></i>
				<?php endif; ?>
			</td>
			<td>
				<?php echo anchor('task/edit/'.$item->id, '<i class="fa fa-pencil"></i>', 'class="btn btn-success btn-circle" title="'.$this->lang->line('edit').'"'); ?> 

				<?php if($item->type_id == TASK_VK_SHARE && $item->action_done > 3) : ?>
				<?php echo anchor('task/csv/'.$item->id.'/soc_vk', '<i class="fa fa-list"></i>', 'class="btn btn-success btn-circle" title=""'); ?> 
				<?php endif; ?>

				<?php if($item->type_id == TASK_TWITTER_SHARE && $item->action_done > 3) : ?>
				<?php echo anchor('task/csv/'.$item->id.'/soc_twitter', '<i class="fa fa-list"></i>', 'class="btn btn-success btn-circle" title=""'); ?> 
				<?php endif; ?>
				
				<?php if($item->type_id == TASK_LIKE && $item->action_done > 3) : ?>
				<?php echo anchor('task/done_recalc/'.$item->id, '<i class="fa fa-refresh"></i>', 'class="btn btn-success btn-circle" title="Пересчитать кол-во выполнений" onclick="YT_DoneRecalc('.$item->id.'); return false;"'); ?> 
				<?php endif; ?>
				
				<?php if($item->type_id == TASK_SUBSCRIBE && $item->action_done > 5) : ?>
				<?php echo anchor('task/done_recalc/'.$item->id, '<i class="fa fa-refresh"></i>', 'class="btn btn-success btn-circle" title="Пересчитать кол-во выполнений" onclick="YT_DoneRecalc('.$item->id.'); return false;"'); ?> 
				<?php endif; ?>

				<?php if($item->type_id == TASK_VIEW && $item->action_done > 200) : ?>
				<?php echo anchor('task/done_recalc/'.$item->id, '<i class="fa fa-refresh"></i>', 'class="btn btn-success btn-circle" title="Пересчитать кол-во выполнений" onclick="YT_DoneRecalc('.$item->id.'); return false;"'); ?> 
				<?php endif; ?>
				
				<a href="/task/remove/<?php echo $item->id; ?>" class="btn btn-danger btn-circle" onclick="return YT_ConfirmDelete();" title="<?php echo $this->lang->line('remove'); ?>"><i class="glyphicon glyphicon-remove"></i></a>
			</td>
		</tr>
		<?php if(!empty($item->description)) { ?>
		<tr><td colspan="6" style="color: red;"><?php echo $item->description; ?></td></tr>
		<?php } ?>
	<?php endforeach; ?>
	<?php else : ?>
		<tr><td colspan="6" style="text-align: center;"><?php echo $this->lang->line('no_task'); ?></td></tr>
	<?php endif; ?>
    </tbody>
</table>
</div>

<?php echo $pagination; ?>

<div>
<?php echo anchor('task/add', $this->lang->line('add_task'), 'class="btn btn-success"'); ?>
</div>