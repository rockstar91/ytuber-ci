<!DOCTYPE html>
<html lang="ru">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title><?php echo $this->lang->line('tpl_waiting'); ?></title>
	<?php require_once(dirname(__FILE__).'/../_head.php'); ?>
	<style>
		body {background: #f8f8f8; font-family: Arial; margin: 0; padding: 0; color: #000; font-size: 14px; min-width: 500px; min-height: 300px;}
		.main {    
			height: 200px;
		    width: 400px;
		    position: absolute;
		    top: 50%;
		    left: 50%;
		    padding: 20px;
		    margin-top: -120px;
		    margin-left: -220px;
		    text-align: center;
		    background: #f8f8f8;
		    border-radius: 45px;
		}
	</style>
</head>
<body>
	<div class="main">
		<img src="/static/client_wait.gif" alt="" />
		<h2><?php echo $this->lang->line('tpl_waiting'); ?></h2>
		<p><?php echo $this->lang->line('tpl_search_videos_available'); ?></p>
		<p style="font-size: 12px; opacity: 0.7;"><?php echo $this->lang->line('tpl_restart_client'); ?></p>
	</div>
</body>
</html>