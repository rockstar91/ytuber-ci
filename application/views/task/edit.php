<div id="task_form_container">
<?php if(validation_errors() && !$this->input->post('change_type')) : ?>
<div class="alert alert-danger">
    <?=validation_errors(); ?>
</div>
<?php endif; ?>

<?=form_open('task/edit/'.$id, array('id' => 'task_form')); ?>
	<input type="hidden" name="change_type" id="change_type" value="0" />
	<div class="row">
		<?php if($types) : ?>
		<div class="form-group col-sm-6">
			<label for="type_id"><?php echo $this->lang->line('type'); ?></label>
			<select class="form-control" name="type_id" id="type_id" disabled>
				<?php foreach ($types as $type) : ?>
				<?php if(!($this->user->admin OR $this->user->referrer_id == 7) && $type->id == 20) {continue;} ?>
				<?php if($type->id == 21) {continue;} ?>
                    <?php if($type->id == 10) {continue;} ?>
				<option value="<?=$type->id;?>" <?=set_select('type_id', $type->id, ($task->type_id == $type->id));?>><?=$type->name;?></option>
				<?php endforeach; ?>
		    </select>
		</div>

		<input type="hidden" name="type_id" value="<?php echo $task->type_id; ?>" />
		<?php endif; ?>

		<?php if($categories) : ?>
		<div class="form-group col-sm-6">
			<label for="category_id"><?php echo $this->lang->line('category'); ?></label>
			<select class="form-control" name="category_id">
				<?php foreach ($categories as $category) : ?>
				<option value="<?=$category->id;?>" <?=set_select('category_id', $category->id, ($task->category_id == $category->id));?>><?=$category->name;?></option>
				<?php endforeach; ?>
		    </select>
		</div>	
		<?php endif; ?>
	</div>

	<div class="row">
		<div class="form-group col-sm-6">
			<label for="url"><?php echo $this->lang->line('url'); ?></label>
			<input type="text" class="form-control" name="url" disabled value="<?=set_value('url', $task->url);?>" size="50" placeholder="<?php if($url_placeholder) {echo $url_placeholder;} else {echo 'https://www.youtube.com/watch?v=rtR2eJXb4U0';} ?>" />
		</div>
		<div class="form-group col-sm-6">
			<label for="name"><?php echo $this->lang->line('name'); ?></label>
			<input type="text" class="form-control" name="name" value="<?=set_value('name', $task->name);?>" size="50" placeholder="<?=$this->lang->line('name_placeholder');?>" />
		</div>
	</div>
	<div class="row">
		<!-- Цены -->
		<div class="form-group col-sm-3">
			<label for="total_cost"><?php echo $this->lang->line('total_cost'); ?></label>
			<input type="text" class="form-control" name="total_cost" id="total_cost" value="<?=set_value('total_cost', $task->total_cost);?>" size="15" placeholder="200" autocomplete="off" />
		</div>
		<div class="form-group col-sm-3">
			<label for="action_cost"><?php echo $this->lang->line('action_cost'); ?></label>
			<input type="text" class="form-control" name="action_cost" id="action_cost" value="<?=set_value('action_cost', $task->action_cost);?>" size="15" placeholder="1" autocomplete="off" />
			<p style="margin-top: 5px; font-size: 0.9em;"><?php echo $this->lang->line('position'); ?><span id="action_cost_position" style="font-weight: bold;">&infin;</span></p>
		</div>
		<div class="form-group col-sm-3">
			<label for="action_target"><?php echo $this->lang->line('action_target'); ?></label>
			<input type="text" class="form-control" name="action_target" id="action_target" value="<?=set_value('action_target', floor($task->total_cost/$task->action_cost));?>" size="15" placeholder="0" />
		</div>
		<div class="form-group col-sm-3">
			<label for="hour_limit"><?php echo $this->lang->line('hour_limit'); ?></label>
			<input type="text" class="form-control" name="hour_limit" value="<?=set_value('hour_limit', $task->hour_limit);?>" size="15" placeholder="0 - без лимита" />
		</div>
	</div>

	<?php require(dirname(__FILE__).'/_geo.php'); ?>

	<?php if($types) : ?>
	<div class="form_extend">
		<?php 
		$type_id = $this->input->post('type_id') ? (int) $this->input->post('type_id') : $task->type_id;
		$path = dirname(__FILE__).'/extend/'.$type_id.'.php';
		if(is_file($path)) {require($path);}
		?>
	</div>
	<?php endif; ?>

	<div class="form-group">
		<input type="submit" class="btn btn-success" value="<?php echo $this->lang->line('save_task'); ?>" />
	</div>
</form>
</div>