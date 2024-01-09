<style>
.panel-news hr {
    margin-top: 10px;
    margin-bottom: 10px;
}
.panel-heading h3 {
    font-size: 1.1em;
    font-weight: bold;
    margin: 0;
}
.panel-footer {
    background-color: #333333;
    border-top: 1px solid #000000;
    margin: -1px;
    color: #fff;
}
.panel-heading-icon {
    float: left;
    margin-right: 10px;
    margin-top: 3px;
}

span.list-group-item > span.cost {
    color: green;
}
span.list-group-item > span.cost-m {
    color: red;
}
</style>
<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-bank fa-3x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?=intval($user->balance);?></div>
                        <div><?=$this->lang->line('tpl_balance_tip');?></div>
                    </div>
                </div>
            </div>
            <a href="<?=site_url('payment/start');?>">
                <div class="panel-footer">
                    <span class="pull-left"><?=$this->lang->line('tpl_balance_details');?></span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-tasks fa-3x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?=$taskTotal;?></div>
                        <div><?=$this->lang->line('tpl_tasks_tip');?></div>
                    </div>
                </div>
            </div>
            <a href="<?=site_url('task/index');?>">
                <div class="panel-footer">
                    <span class="pull-left"><?=$this->lang->line('tpl_tasks_details');?></span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-check fa-3x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?=$user->done;?></div>
                        <div><?=$this->lang->line('tpl_done_tip');?></div>
                    </div>
                </div>
            </div>
            <a href="<?=site_url('work/like');?>">
                <div class="panel-footer">
                    <span class="pull-left"><?=$this->lang->line('tpl_done_details');?></span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-red2">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-users fa-3x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?=$referralsTotal;?></div>
                        <div><?=$this->lang->line('tpl_referrals_tip');?></div>
                    </div>
                </div>
            </div>
            <a href="<?=site_url('user/referrals');?>">
                <div class="panel-footer">
                    <span class="pull-left"><?=$this->lang->line('tpl_referrals_details');?></span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
</div>

<div class="row">

    <?php if(true) : ?>
    <div class="col-lg-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-heading-icon">
                    <i class="fa fa-gift fa-fw fa-2x"></i>
                </div>
                <h3><?=$this->lang->line('tpl_daily_bonus');?></h3>
                <small><?=$this->lang->line('tpl_daily_bonus_tip');?></small>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <?php if($this->user->daily_bonus_received) : ?>
                <div class="text-center">
                    <h4><?=$this->lang->line('tpl_you_have_bonus');?></h4>
                </div>
                <?php elseif($bonusTargetsReach) : ?>
                    <script src='https://www.google.com/recaptcha/api.js'></script>
                    <?=form_open('dashboard/get_bonus'); ?>
                    <div class="form-group">
                        <div class="g-recaptcha" data-sitekey="<?php echo recaptcha_pub(); ?>"></div>
                    </div>
                    <button type="submit" class="btn btn-default"><?=$this->lang->line('tpl_get_bonus');?></button>
                    </form>
                <?php else : ?>
                    <span><?php printf($this->lang->line('tpl_bonus_view'), $bonusData[TASK_VIEW]['target']); ?></span>
                    <div class="progress progress-xs">
                        <div class="progress-bar" style="width: <?=$bonusData[TASK_VIEW]['percent'];?>%;">
                            <?=$bonusData[TASK_VIEW]['total'];?>
                        </div>
                    </div>

                    <span><?php printf($this->lang->line('tpl_bonus_like'), $bonusData[TASK_LIKE]['target']); ?></span>
                    <div class="progress progress-xs">
                        <div class="progress-bar" style="width: <?=$bonusData[TASK_LIKE]['percent'];?>%;">
                            <?=$bonusData[TASK_LIKE]['total'];?>
                        </div>
                    </div>

                    <span><?php printf($this->lang->line('tpl_bonus_subscribe'), $bonusData[TASK_SUBSCRIBE]['target']); ?></span>
                    <div class="progress progress-xs">
                        <div class="progress-bar" style="width: <?=$bonusData[TASK_SUBSCRIBE]['percent'];?>%;">
                            <?=$bonusData[TASK_SUBSCRIBE]['total'];?>
                        </div>
                    </div>

                    <span><?php printf($this->lang->line('tpl_bonus_comment'), $bonusData[TASK_COMMENT]['target']); ?></span>
                    <div class="progress progress-xs">
                        <div class="progress-bar" style="width: <?=$bonusData[TASK_COMMENT]['percent'];?>%;">
                            <?=$bonusData[TASK_COMMENT]['total'];?>
                        </div>
                    </div>
                <?php endif;?>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <?php endif; ?>


    <?php if(false) : ?>
    <div class="col-lg-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-heading-icon">
                    <i class="fa fa-gift fa-fw fa-2x"></i>
                </div>
                <h3><?=$this->lang->line('tpl_daily_bonus');?></h3>
                <small><?=$this->lang->line('tpl_daily_bonus_tip');?></small>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <?php if($this->user->done_day >= 50 && $this->user->daily_bonus_received == 0) : ?>
                    <script src='https://www.google.com/recaptcha/api.js'></script>
                <?=form_open('dashboard/bonus'); ?>
                    <div class="form-group">
                        <div class="g-recaptcha" data-sitekey="<?php echo recaptcha_pub(); ?>"></div>
                    </div>
                    <button type="submit" class="btn btn-default"><?=$this->lang->line('tpl_get_bonus');?></button>
                    </form>
                <?php elseif($this->user->daily_bonus_received == 1) : ?>
                    <div class="text-center">
                        <h4><?=$this->lang->line('tpl_you_have_bonus');?></h4>
                    </div>
                <?php else: ?>
                    <div id="dashboard-donut-chart" style="height: 250px;"></div>
                <?php endif;?>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <?php endif; ?>

    <div class="col-lg-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-heading-icon">
                    <i class="fa fa-bar-chart-o fa-fw fa-2x"></i>
                </div>
                <h3><?=$this->lang->line('tpl_week_activity');?></h3>
                <small><?=$this->lang->line('tpl_week_activity_tip');?></small>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div id="dashboard-bar-chart" style="height: 250px;"></div>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>

    <div class="col-lg-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-heading-icon">
                    <i class="fa fa-users fa-fw fa-2x"></i>
                </div>
                <h3><?=$this->lang->line('tpl_referrals');?></h3>
                <small><?=$this->lang->line('tpl_referrals_text');?></small>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th style="width: 160px;"><?=$this->lang->line('tpl_referrals_date');?></th>
                                <th><?=$this->lang->line('tpl_referrals_name');?></th>
                                <th style="width: 100px;"><?=$this->lang->line('tpl_referrals_earn');?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($referrals) : ?> 
                            <?php foreach($referrals as $item) : ?>
                            <tr>
                                <td><?=strftime("%H:%M, %e %b", strtotime($item->time));?></td>
                                <td><?=htmlspecialchars($item->name);?></td>
                                <td><?=$item->earned;?></td>
                            </tr>
                            <?php endforeach; ?>
                            <?php else : ?>
                             <tr><td colspan="3" style="text-align: center;"><?=$this->lang->line('tpl_no_have_referrals');?> <br/> <?=anchor('promotion', $this->lang->line('tpl_how_to_attract')); ?></td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

</div>




<div class="row">

    <div class="col-lg-4">
        <div class="panel panel-success panel-news">
            <div class="panel-heading">
                <?=$this->lang->line('tpl_news');?>
            </div>
            <div class="panel-body">
                <?php foreach($news as $item) : ?>
                <?php
                    if(strtotime($item->date) > (time() - (86400 * 30))) 
                    {
                        $new = ' <sup style="color:red;">new</sup>';
                    }
                    else 
                    {
                        $new = '';
                    }
                ?>
                <label><?php echo date('d.m.Y', strtotime($item->date)).$new; ?></label>
                <?php echo $item->text; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- /.col-lg-4 -->
    <div class="col-lg-4">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <?=$this->lang->line('tpl_support');?>
            </div>
            <div class="panel-body">
                <?php if(validation_errors()) : ?>
                <div class="alert alert-danger">
                    <?=validation_errors(); ?>
                </div>
                <?php endif; ?>
                <?=form_open('dashboard'); ?>
                    <div class="form-group">
                        <?php $mail = !strpos($this->user->mail, '@pages.plusgoogle.com') ? $this->user->mail : $this->lang->line('support_email'); ?>
                        <input class="form-control" name="email" placeholder="<?=$mail;?>">
                    </div>
                    <div class="form-group">
                        <input class="form-control" name="subject" placeholder="<?=$this->lang->line('support_subject');?>">
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" name="text" placeholder="<?=$this->lang->line('support_text');?>" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-default"><?=$this->lang->line('tpl_support_submit');?></button>
                    <button type="reset" class="btn btn-default"><?=$this->lang->line('tpl_support_reset');?></button>
                </form>
            </div>
        </div>
    </div>
    <!-- /.col-lg-4 -->
    <div class="col-lg-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-bell fa-fw"></i> 
                <?=$this->lang->line('tpl_notifications');?>
            </div>
            <!-- /.panel-heading -->


            <div class="panel-body">
                <?php if($notification) : ?>
                <div class="list-group">
                    <?php foreach($notification as $item) : ?>
                    <span class="list-group-item">
                        <?php if($item->type == NOTY_DAILY_BONUS) : ?>
                            <i class="fa fa-gift fa-fw"></i> 
                            <span class="cost">+<?=number_format($item->cost, 2);?></span> 
                            <?=$this->lang->line('tpl_noty_daily_bonus');?>
                        <?php elseif($item->type == NOTY_PENALTY_SPAM) : ?>
                            <i class="fa fa-warning fa-fw"></i> 
                            <span class="cost-m">-<?=number_format($item->cost, 2);?></span> 
                            <?=sprintf($this->lang->line('tpl_noty_penalty_spam'), $item->data);?>

                        <?php elseif($item->type == NOTY_PENALTY_TASK) : ?>
                            <i class="fa fa-warning fa-fw"></i> 
                            <span class="cost-m">-<?=number_format($item->cost, 2);?></span> 
                            <?php if($item->task_type_id == TASK_LIKE) : ?>
                                <?=sprintf($this->lang->line('tpl_noty_penalty_task_v'), $item->data);?>
                            <?php elseif($item->task_type_id == TASK_SUBSCRIBE) : ?>
                                <?=sprintf($this->lang->line('tpl_noty_penalty_task_c'), $item->data);?>
                            <?php endif; ?>
                        <?php elseif($item->task_type_id == TASK_VIEW) : ?>
                            <i class="fa fa-video-camera fa-fw"></i> 
                            <span class="cost">+<?=number_format($item->cost, 2);?></span> 
                            <?=sprintf($this->lang->line('tpl_noty_viewed'), $item->task_time);?>

                        <?php elseif($item->task_type_id == TASK_LIKE) : ?>
                            <i class="fa fa-thumbs-o-up fa-fw"></i> 
                            <span class="cost">+<?=number_format($item->cost, 2);?></span>
                            <?=$this->lang->line('tpl_noty_liked');?> 

                        <?php elseif($item->task_type_id == TASK_COMMENT) : ?>
                            <i class="fa fa-comment fa-fw"></i> 
                            <span class="cost">+<?=number_format($item->cost, 2);?></span> 
                            <?=$this->lang->line('tpl_noty_commented');?> 

                        <?php elseif($item->task_type_id == TASK_COMMENT_LIKE) : ?>
                            <i class="fa fa-comment fa-fw"></i> 
                            <span class="cost">+<?=number_format($item->cost, 2);?></span> 
                            <?=$this->lang->line('tpl_noty_comment_like');?> 

                        <?php elseif($item->task_type_id == TASK_REPLY) : ?>
                            <i class="fa fa-comment fa-fw"></i> 
                            <span class="cost">+<?=number_format($item->cost, 2);?></span> 
                            <?=$this->lang->line('tpl_noty_reply');?> 

                        <?php elseif($item->task_type_id == TASK_SUBSCRIBE) : ?>
                            <i class="fa fa-users fa-fw"></i> 
                            <span class="cost">+<?=number_format($item->cost, 2);?></span> 
                            <?=$this->lang->line('tpl_noty_subscribed');?>

                        <?php elseif($item->task_type_id == TASK_GPSHARE) : ?>
                            <i class="fa fa-google-plus fa-fw"></i> 
                            <span class="cost">+<?=number_format($item->cost, 2);?></span> 
                            <?=$this->lang->line('tpl_noty_shared');?>

                        <?php elseif($item->task_type_id == TASK_SITE) : ?>
                            <i class="fa fa-files-o fa-fw"></i> 
                            <span class="cost">+<?=number_format($item->cost, 2);?></span> 
                            <?=$this->lang->line('tpl_noty_site_viewed');?> 

                        <?php elseif($item->task_type_id == TASK_VK_SHARE) : ?>
                            <i class="fa fa-share-square fa-fw"></i> 
                            <span class="cost">+<?=number_format($item->cost, 2);?></span> 
                            <?=$this->lang->line('tpl_noty_vk_share');?>
                        
                        <?php elseif($item->task_type_id == TASK_TWITTER_SHARE) : ?>
                            <i class="fa fa-share-square fa-fw"></i> 
                            <span class="cost">+<?=number_format($item->cost, 2);?></span> 
                            <?=$this->lang->line('tpl_noty_twitter_share');?>
                        <?php endif; ?>
                        <span class="pull-right text-muted small"><em><?=$item->time;?></em></span>
                    </span>
                    <?php endforeach; ?>
                </div>
                <?php else : ?>
                    <div class="text-center"><?=$this->lang->line('tpl_you_have_not_done_anything');?></div>
                <?php endif; ?>
                <!-- /.list-group -->
                <!--<a href="#" class="btn btn-default btn-block">View All Alerts</a>-->
            </div>
            <!-- /.panel-body -->
        </div>
    </div>
    <!-- /.col-lg-4 -->
</div>