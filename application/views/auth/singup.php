<div class="panel-body">
	<style>
		.alert-danger {font-size: 13px;}
	</style>
	<?php if(validation_errors() OR isset($error)) : ?>
		<div class="alert alert-danger"><?php echo validation_errors(); ?><?php if(isset($error)) echo $error; ?></div>
	<?php endif; ?>

    <?php if(isset($success)) : ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php else : ?>
    <script>
    function submitSignupForm() {
        document.getElementById("signupForm").submit();
    }
    </script>
    <?php echo form_open('auth/singup', 'id="signupForm"'); ?>
        <fieldset>
            <div class="form-group">
                <input class="form-control" placeholder="<?php echo $this->lang->line('name'); ?>" name="name" type="" value="<?=set_value('name');?>" autofocus>
            </div>
            <div class="form-group">
                <input class="form-control" placeholder="<?php echo $this->lang->line('mail'); ?>" name="mail" type="email" value="<?=set_value('mail');?>">
            </div>
            <div class="form-group">
                <input class="form-control" placeholder="<?php echo $this->lang->line('password'); ?>" name="password" type="password" value="<?=set_value('password');?>">
            </div>
            <div class="form-group">
                <input class="form-control" placeholder="<?php echo $this->lang->line('password_confirm'); ?>" name="password_confirm" type="password" value="<?=set_value('password_confirm');?>">
            </div>

            <div class="form-group">
                <input type="submit" data-sitekey="<?php echo $this->config->item('recaptcha2')['pub']; ?>" data-callback="submitSignupForm" class="g-recaptcha btn btn-lg btn-danger btn-block" value="<?php echo $this->lang->line('singup_submit'); ?>" />
            </div>

            <div class="form-group">
                <a href="<?=site_url('auth/login');?>" style="float: right;"><?php echo $this->lang->line('have_account'); ?></a>
            </div>
        </fieldset>
    </form>
    <?php endif;?>
</div>