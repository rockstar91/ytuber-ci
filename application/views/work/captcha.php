<script src='https://www.google.com/recaptcha/api.js'></script>

<div class="main" style="">
		<?=form_open('work/'.$action.'/'.$task_id); ?>
		    <div class="form-group" style="min-height: 78px;">
				<div class="g-recaptcha" data-sitekey="<?php echo $this->config->item('recaptcha2')['pub']; ?>"></div>
		    </div>
		    <div class="form-group">
		   		<button type="submit" class="btn btn-default"><?=$this->lang->line('captcha_submit'); ?></button>
		    </div>
		</form>
</div>
