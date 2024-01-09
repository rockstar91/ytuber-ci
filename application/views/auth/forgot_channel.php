<div class="panel-body">
    <?php if(validation_errors()) : ?>
        <div class="alert alert-danger"><?php echo validation_errors(); ?></div>
    <?php endif; ?>
    <?php if(isset($error)) : ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif;?>
    <?php if(isset($success)) : ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif;?>
    <?php if(isset($forgot_channel_token)) : ?>
        <div class="alert alert-info">Добавьте в описание канала следующий текст: <?php echo $forgot_channel_token; ?></div>
    <?php endif;?>
    <?php echo form_open('auth/forgot_channel'); ?>
    <fieldset>
        <div class="form-group">
            <input class="form-control" placeholder="Channel" name="channel" type="text" autofocus>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-lg btn-danger btn-block" value="<?php echo $this->lang->line('restore'); ?>" />
        </div>
        <div class="form-group">
            <a href="<?=site_url('auth/singup');?>"><?php echo $this->lang->line('singup'); ?></a>
            <a href="<?=site_url('auth/login');?>" style="float: right;"><?php echo $this->lang->line('have_account'); ?></a>
        </div>
    </fieldset>
    </form>
</div><?php
