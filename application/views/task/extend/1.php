	<style>
	.time-select {
		margin-top: 5px;
	}
	.time-select span {
		margin-right: 3px;
		color: #337ab7;
		border-bottom: 1px dotted #337ab7;
		cursor: pointer;
	}
	</style>
	
	<?php $time = isset($task->extend['time']) ? $task->extend['time'] : null; ?>
	<div class="form-group">
		<label for=""><?=$this->lang->line('viewing_time');?></label>
	    <input type="text" class="form-control" name="extend[time]" id="extend_time" value="<?=set_value('extend[time]', $time);?>" size="15" placeholder="45">
	    <div class="time-select">
	    	<span>45</span>
	    	<span>60</span>
	    	<span>90</span>
	    	<span>180</span>
	    	<span>300</span>
	    	<span>600</span>
	    </div>
	</div>