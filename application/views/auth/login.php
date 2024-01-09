<div class="panel-body">
    <style>
        .alert-danger {font-size: 13px;}
    </style>
    <?php if(validation_errors()) : ?>
        <div class="alert alert-danger"><?php echo validation_errors(); ?></div>
    <?php endif; ?>

    <?php if(isset($error)) : ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <?php if($this->session->userdata('success')) : ?>
        <div class="alert alert-success"><?php echo $this->session->userdata('success'); ?></div>
    <?php endif; ?>

    <script>
    function submitLoginForm() {
        document.getElementById("loginForm").submit();
    }
    </script>

    <?php echo form_open('auth/login', 'id="loginForm"'); ?>
        <fieldset>
            <div class="form-group">
                <input class="form-control" placeholder="<?php echo $this->lang->line('mail'); ?>" name="mail" type="email" autofocus>
            </div>
            <div class="form-group">
                <input class="form-control" placeholder="<?php echo $this->lang->line('password'); ?>" name="password" type="password" value="">
            </div>
            
            <!-- Change this to a button or input when using this as a form -->
            <div class="form-group">
                <input type="submit" data-sitekey="<?php echo $this->config->item('recaptcha2')['pub']; ?>" data-callback="submitLoginForm" class="g-recaptcha btn btn-lg btn-danger btn-block" value="<?php echo $this->lang->line('login'); ?>" />
            </div>

            <?php /*
            <div class="form-group">
                <button class="btn btn-block btn-social btn-google-plus" onclick="window.location='<?php echo site_url('auth/google'); ?>'; return false;">
                    <i class="fa fa-google-plus"></i> <?php echo $this->lang->line('singin_with_google'); ?>
                </button>
            </div>
            */ ?>
            <div class="form-group">
                <a href="<?=site_url('auth/singup');?>"><?php echo $this->lang->line('singup'); ?></a>
                <a href="<?=site_url('auth/forgot');?>" style="float: right;"><?php echo $this->lang->line('have_account'); ?></a>
            </div>
        </fieldset>
    </form>
</div>