<?php if(validation_errors()) : ?>
<div class="alert alert-danger">
    <?=validation_errors(); ?>
</div>
<?php endif; ?>
<?php if(isset($success)) : ?>
<div class="alert alert-success">
    <?=$success;?>
</div>
<?php endif; ?>

<?=form_open('user/setting'); ?>
    <div class="form-group">
        <label for="name"><?=$this->lang->line('name');?></label>
        <input type="text" class="form-control" name="name" value="<?=set_value('name', $user->name);?>" placeholder="" />
    </div>
    <!--
    <div class="form-group">
        <label for="channel">YouTube-канал</label>
        <input type="text" class="form-control" name="channel" value="<?=set_value('channel', $user->channel);?>" placeholder="" />
    </div> 
    -->
    <div class="form-group">
        <label for="password"><?=$this->lang->line('password');?></label>
        <input type="password" class="form-control" name="password" value="" placeholder="" />
        <p><?=$this->lang->line('password_tip');?></p>
    </div>
    <div class="form-group">
        <label for="password_confirm"><?=$this->lang->line('password_confirm');?></label>
        <input type="password" class="form-control" name="password_confirm" value="" placeholder="" />
    </div>
    <div class="form-group">
        <label for="password_confirm"><?=$this->lang->line('api_key');?></label>
        <input type="text" class="form-control" name="api_key" style="cursor: text; background: #F3F3F3;" value="<?=htmlspecialchars($user->api_key);?>" placeholder="" onclick="this.select();" />
        <div>
            <input type="checkbox" name="api_key_generate" value="1" placeholder="" />
            <span><?=$this->lang->line('api_key_tip');?></span>
        </div>
    </div>
    <div class="form-group">
        <label><?=$this->lang->line('sub_title');?></label>
        <div>
            <input type="checkbox" name="sub_news" <?=set_checkbox('sub_news', 1, (bool)$user->sub_news);?> value="1" placeholder="" />
            <span><?=$this->lang->line('sub_news');?></span>
        </div>
        <div>
            <input type="checkbox" name="sub_transaction" <?=set_checkbox('sub_transaction', 1, (bool)$user->sub_transaction);?> value="1" placeholder="" />
            <span><?=$this->lang->line('sub_transaction');?></span>
        </div>
        <div>
            <input type="checkbox" name="sub_statistic" <?=set_checkbox('sub_statistic', 1, (bool)$user->sub_statistic);?> value="1" placeholder="" />
            <span><?=$this->lang->line('sub_statistic');?></span>
        </div>
        <div>
            <input type="checkbox" name="sub_notification" <?=set_checkbox('sub_notification', 1, (bool)$user->sub_notification);?> value="1" placeholder="" />
            <span><?=$this->lang->line('sub_other');?></span>
        </div>
    </div>

    <?php if($user->confirm != '') : ?>
    <div class="form-group">
        <input type="checkbox" name="resend_confirm" value="1" placeholder="" />
        <span><?=$this->lang->line('resend_confirm');?></span>
    </div>
    <?php endif; ?>

    <div class="form-group">
        <label for="soc_youtube">YouTube-channel</label>
        <input type="text" class="form-control" name="soc_youtube" value="<?=set_value('soc_youtube', $user->channel);?>" placeholder="UCSLkl3Jcgh2jFd1_Wg6eTQA" />
    </div>

    <div class="form-group">
        <label for="soc_vk">VK</label>
        <input type="text" class="form-control" name="soc_vk" value="<?=set_value('soc_vk', $user->soc_vk);?>" placeholder="https://vk.com/id123" />
    </div>
    <div class="form-group">
        <label for="soc_twitter">Twitter</label>
        <input type="text" class="form-control" name="soc_twitter" value="<?=set_value('soc_twitter', $user->soc_twitter);?>" placeholder="https://twitter.com/username" />
    </div>

    <?php if(false) : ?>
    <div class="form-group">
        <label for="soc_fb">Facebook</label>
        <input type="text" class="form-control" name="soc_fb" value="<?=set_value('soc_fb', $user->soc_fb);?>" placeholder="https://www.facebook.com/username" />
    </div>
    <?php endif; ?>

    <div class="form-group">
        <input type="submit" class="btn btn-default" value="<?=$this->lang->line('save');?>" />
    </div>
</form>