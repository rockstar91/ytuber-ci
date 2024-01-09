	<div class="form-group">
		<label for=""><?=$this->lang->line('like_type');?></label>
		<select class="form-control" name="extend[type]">
			<?php $type = isset($task->extend['type']) ? $task->extend['type'] : null; ?>
			<option value="1" <?=set_select('extend[type]', 1, ($type == 1));?>><?=$this->lang->line('like_positive');?></option>
			<option value="2" <?=set_select('extend[type]', 2, ($type == 2));?>><?=$this->lang->line('like_negative');?></option>
	    </select>
	</div>