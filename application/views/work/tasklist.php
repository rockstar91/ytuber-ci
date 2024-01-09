<div class="status"></div>
<?php 
$isAdmin = isset($this->user->admin) ? $this->user->admin : null; 
$imageTypes = array('view', 'like', 'comment', 'gpshare', 'vkshare', 'twittershare', 'reply', 'comment_like');
$defaultTimeType = array('view', 'like', 'comment', 'subscribe', 'reply', 'comment_like');

?>

<?php if($action == 'vkshare' OR $action == 'twittershare' OR $action == 'fbshare') : ?>
<div class="panel panel-info">
    <div class="panel-heading">
      <i class="fa fa-info-circle fa-1x"></i>
      <?php echo $this->lang->line('tpl_soc_tip'); ?></div>
</div>
<?php endif; ?>
<?php if($action == 'reply') : ?>
<div class="panel panel-info">
    <div class="panel-heading">
      <i class="fa fa-info-circle fa-1x"></i>
      <?php echo $this->lang->line('tpl_reply_tip'); ?></div>
</div>
<?php endif; ?>


<div class="table-responsive">
<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <?php if(false) : ?>
            <th style="width: 70px;">#</th>
            <?php endif; ?>

            <?php if(in_array($action, $imageTypes)) : ?>
            <th style="width: 50px;"></th>
            <?php endif; ?>

            <?php if($action == 'subscribe') : ?>
            <th style="width: 40px;"></th>
            <?php endif; ?>

            <th class="title"><?php echo $this->lang->line('tpl_name'); ?></th>
            <th style="width: 80px;"><?php echo $this->lang->line('tpl_action_cost'); ?></th>

            <?php if(in_array($action, $defaultTimeType)) : ?>
              <th style="width: 80px;"><?php echo $this->lang->line('tpl_time'); ?></th>
            <?php endif; ?>

            <?php if($action == 'like') : ?>
              <th style="width: 100px;"><?php echo $this->lang->line('tpl_like_type'); ?></th>

            <?php elseif($action == 'comment' OR $action == 'reply') : ?>
              <th style="width: 100px;"><?php echo $this->lang->line('tpl_yt_comment'); ?></th>
            <?php endif; ?>
<?php if($isAdmin) { ?>
            <th style="width: 100px;"><?php echo $this->lang->line('tpl_actions'); ?></th>
<?php } ?>
        </tr>
    </thead>
    <tbody>
  <?php if($results) : ?> 
  <?php foreach($results as $item) : ?>
    <?php 
    if(in_array($action, $defaultTimeType)) 
    {
      $time = isset($item->extend['time']) ? $item->extend['time'] : 30;
    }
    else 
    {
      $time = 0;
    }
    
    ?>
    <?php
      $category = $this->Category->getItem($item->category_id);
      $item->category = isset($category->name) ? $category->name : '-';
      
      $tr_class = '';
      if($item->c_status == COMPLETE_OPENED)
      {
          $tr_class = 'none';
      }
      else if($item->c_status == COMPLETE_WAITING)
      {
          $tr_class = 'waiting';
      }
      else if($item->c_status == COMPLETE_FAILED)
      {
          $tr_class = 'danger';
      }
      else if($item->c_status == COMPLETE_FINISHED OR $item->done)
      {
          $tr_class = 'success';
      }
    ?>
    <tr id="task_<?php echo $item->id; ?>"<?php echo ' class="'.$tr_class.'"'; ?>>
      <?php if(false) : ?>
      <td class="id"><?php echo $item->id; ?></a></td>
      <?php endif; ?>

      <?php if(in_array($action, $imageTypes)) : ?>
      <td>
        <a href="#" onclick="YT_TaskClick(<?php echo $item->id; ?>, <?php echo $time; ?>); return false;">
          <img src="https://img.youtube.com/vi/<?=yt_vid($item->url);?>/default.jpg" alt="" width="60" />
        </a>
      </td>
      <?php endif; ?>

      <?php if($action == 'subscribe') : ?>
      <td>
        <?php if(isset($item->youtube_extend['thumbnail'])) : ?>
        <a href="#" onclick="YT_TaskClick(<?php echo $item->id; ?>, <?php echo $time; ?>); return false;">
          <img src="<?php echo $item->youtube_extend['thumbnail']; ?>" alt="" width="60" />
        </a>
        <?php endif; ?>
      </td>
      <?php endif; ?>

      <td class="link title">
          <a href="#" onclick="YT_TaskClick(<?php echo $item->id; ?>, <?php echo $time; ?>); return false;"><?php echo htmlspecialchars($item->name); ?></a>

        <?php if($item->geo) {echo ' <sup style="color: green;">geo</sup>';} ?>

          <?php if($isAdmin) : ?>
          <p>
              youtube (i/l): <?=$item->youtube_initial; ?>/<?=$item->youtube; ?>,
              done: <?=$item->action_done; ?> (<?=$item->action_fail; ?>),
              бюджет: <?=$item->total_cost; ?>,
              <?=$item->added; ?>,
              <a href="<?=site_url('admin/user/'.$item->author_id);?>"><?=$item->author_id;?></a>
          </p>
          <?php endif; ?>

        <p style="margin: 0;"><?=$item->category; ?></p>
      </td>
      <td>
        <?php echo yt_cost($item->action_cost, 'user'); ?>
      </td>

      <?php if(in_array($action, $defaultTimeType)) : ?>
        <td class="time"><?php echo $time; ?></td>
      <?php endif; ?>

      <?php if($action == 'like') : ?>
        <td>
        <?php
        $type = isset($item->extend['type']) ? $item->extend['type'] : 1;
            switch($type) {
              case 1:
                echo $this->lang->line('tpl_like_like');
                break;
              case 2:
                echo $this->lang->line('tpl_like_dislike');
                break;
            }
          ?>
        </td>
      <?php elseif($action == 'comment' OR $action == 'reply') : ?>

        <?php 
        if($this->user->admin && false) 
        {
          echo "<td>";
          print_r($item->extend);
          echo "</td>";
        }
        ?>
        <td>
          <?php 

	          switch((int)$item->extend['comment_type']) {
	            case 1:
	              echo $this->lang->line('tpl_comment_positive');
	              break;
	            case 2:
	              echo $this->lang->line('tpl_comment_negative');
	              break;
	            case 3:
	              echo $this->lang->line('tpl_comment_custom');
	              break;
	            case 4:
	              echo '<a class="copy_clipboard btn btn-primary" data-clipboard-action="copy" data-task-id="'.$item->id.'" style="cursor: pointer;">'.$this->lang->line('tpl_comment_copy').'</a>';
	              //echo '<input type="text" class="form-control comment_text hide" id="comment_text_'.$item->id.'" value="" onclick="this.select();" />';
	              //echo '<input type="text" class="form-control" value="'.htmlspecialchars(yt_comment_cycle($item->extend['comment_text'], $item->action_done)).'" onclick="this.select();">';
	              break;
	            default:
	              echo $this->lang->line('tpl_comment_positive');
	              break;
	          }
          ?>
        </td>
      <?php endif; ?>

        <?php if($action != 'vkshare1' AND $action != 'twittershare1') : ?>
        <?php endif; ?>
            <?php if($isAdmin) { ?>
			      <td>
                <?php echo anchor('task/remove/'.$item->id, '<i class="glyphicon glyphicon-remove"></i>', 'class="btn btn-danger btn-circle" title="'.$this->lang->line('tpl_remove_task').'" onclick="return YT_ConfirmDelete();"'); ?>
				      </td>
            <?php } ?>
    </tr>
  <?php endforeach; ?>
  <?php else : ?>
    <tr><td colspan="7" style="text-align: center;"><?php echo $this->lang->line('tpl_no_task'); ?></td></tr>
  <?php endif; ?>
    </tbody>
</table>
</div>

<?php echo $pagination; ?>