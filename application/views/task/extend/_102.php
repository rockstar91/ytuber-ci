
	<div class="form-group" id="comment_text_block">
		<label for=""><?=$this->lang->line('comment_text');?></label>
		<p class="small"><?=$this->lang->line('comment_text_tip');?></p>
		<?php $comment_text = isset($task->extend['comment_text']) ? $task->extend['comment_text'] : ''; ?>
		<textarea class="form-control" rows="8" name="extend[comment_text]"><?=set_value('extend[comment_text]', $comment_text);?></textarea>
	</div>