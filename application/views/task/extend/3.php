	<script>
	function comment_change(){
	  var select = document.getElementById("extend_comment_type");
	  var value  = select.options[select.selectedIndex].value;
	  var toggle = document.getElementById("comment_text_block");
	  if(value == 4) {
		toggle.style.display = 'block';
	  } else {
		toggle.style.display = 'none';
	  }
	}
	</script>
	<div class="form-group">
		<label for=""><?=$this->lang->line('comment_type');?></label>
		<select class="form-control" onchange="comment_change()" name="extend[comment_type]" id="extend_comment_type">
			<?php $comment_type = isset($task->extend['comment_type']) ? $task->extend['comment_type'] : null; ?>
			<option value="4" <?=set_select('extend[comment_type]', 4, ($comment_type == 4));?>><?=$this->lang->line('comment_custom');?></option>
			<option value="1" <?=set_select('extend[comment_type]', 1, ($comment_type == 1));?>><?=$this->lang->line('comment_positive');?></option>
			<option value="2" <?=set_select('extend[comment_type]', 2, ($comment_type == 2));?>><?=$this->lang->line('comment_negative');?></option>
			<option value="3" <?=set_select('extend[comment_type]', 3, ($comment_type == 3));?>><?=$this->lang->line('comment_neutral');?></option>
	    </select>
	</div>
	<div class="form-group" id="comment_text_block">
		<label for=""><?=$this->lang->line('comment_text');?></label>
		<p class="small"><?=$this->lang->line('comment_text_tip');?></p>
		<?php $comment_text = isset($comments) ? implode(PHP_EOL, $comments) : ''; ?>
		<textarea class="form-control" rows="8" name="extend[comment_text]"><?=set_value('extend[comment_text]', $comment_text);?></textarea>
	</div>
	<script>
	comment_change();
	</script>