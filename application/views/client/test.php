<!DOCTYPE html>
<html>
<head>
	<title><?php echo $this->lang->line('tpl_waiting'); ?></title>

    <script src="/static/bower/jquery/dist/jquery.min.js"></script>
	<?php require_once(dirname(__FILE__).'/../_head.php'); ?>

	<style>
  html {width: 100%; height: 100%;}
	body {background: #f8f8f8; font-family: Arial; margin: 0; padding: 0; color: #000; font-size: 14px; height: 100%;}
  #player {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%; 
    height: 100%;
  }
	</style>
</head>
<body>
    <script>
      var vid = '<?php echo $vid; ?>';
      var user_id = <?=$this->user->id; ?>;
    </script>

    <!-- 1. The <iframe> (and video player) will replace this <div> tag. -->
    <div id="player"></div>

    <script src="/static/js/client_test_TqejR60O.js?<?=time();?>"></script>

    <?php if(false) : ?>
    <iframe allowfullscreen="" frameborder="0" height="270" src="https://www.youtube.com/live_chat?v=S0NYVwDbDMM&amp;embed_domain=ytuber.ru" width="480"></iframe>
	<?php endif; ?>
</body>
</html>