<?php
$isAdmin = isset($this->user->admin) ? $this->user->admin : null; 
$imageTypes = array('embeded');
$defaultTimeType = array('embeded');
?>

<div id="timer"></div>
<div id="player"></div>

    <div class="progress mb-4" id="progress-all">
        <div class="progress-bar" id="progress-bar" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
    </div>


<script>
    var tag = document.createElement("script");
    tag.src = "https://www.youtube.com/player_api";
    var firstScriptTag = document.getElementsByTagName("script")[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

	var current = 0;
    var timer;
	var max = 0;
    var player;
    
    function onYouTubePlayerAPIReady()
    {
        player = new YT.Player("player", {
            width:   640,
            height:  390,
			playerVars: { 'autoplay': 0, 'controls': 1 },
            videoId: "IUGzY-ihqWc",
			          events: {
            'onReady': onPlayerReady,
            'onStateChange': onPlayerStateChange
          }
        });
    }
    function onPlayerReady(event) {
        event.target.playVideo();
    }

    function onPlayerStateChange(event) {
        var running = false;
        clearInterval(timer);
        if (event.data == YT.PlayerState.PLAYING && !running) {
            timer = setInterval(timerDecrease, 1000);
            running = true;
			if(timer<=0){
			running = false;
			console.log("finished");
			}
        }
    }

    function timerDecrease() {
        var timer = document.getElementById("timer");
        timer.innerHTML = parseInt(timer.innerHTML) - 1;
		current = current +1;
		console.log("timer:"+current);
		console.log("max:"+max);
		if(parseInt(timer.innerHTML)){
		var percentage = Math.round(parseInt(timer.innerHTML) * 100 / max);
		var el = document.getElementById("progress-bar");
		el.style.width = percentage+"%";
		console.log(percentage+"%");
		if(percentage<=0){
		el.style.display = 'none';
		var el2 = document.getElementById("progress-all");
		el2.style.backgroundColor = 'green';
		setInterval(DisplayProgressOff, 3000);
		}
		else{
		el.style.display = '';	
		}
		}
		
    }
	function DisplayProgressOff(){
		var el2 = document.getElementById("progress-all");
		el2.style.display = 'none';
	}
	
    function stopVideo() {
        player.stopVideo();
    }

    function setVideoId(vid, timer) {
		max = timer;
        player.loadVideoById(vid);
        document.getElementById("timer").innerHTML = timer;
    }
</script>


<?php foreach($results as $item) : ?>



<?php endforeach; ?>

<div class="table-responsive">
<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>

            <?php if(in_array($action, $imageTypes)) : ?>
            <th style="width: 50px;"></th>
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

      <?php if(in_array($action, $imageTypes)) : ?>
      <td>
        <a href="#" onclick="setVideoId('<?=yt_vid($item->url);?>', <?php echo $time; ?>); return false;">
          <img src="https://img.youtube.com/vi/<?=yt_vid($item->url);?>/default.jpg" alt="" width="60" />
        </a>
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