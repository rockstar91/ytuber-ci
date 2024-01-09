<!DOCTYPE html>
<html>
<head>
<title><?php if(isset($pageTitle))  echo $pageTitle .' / '; ?><?php echo $this->config->item('sitename'); ?></title>

<link href="/static/bower/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/static/css/sb-admin-2.css" rel="stylesheet">
    <link href="/static/css/custom.css?v2" rel="stylesheet">
<link href="/static/bower/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

<?php if(false) : ?>
<link href="//www.ytmonster.net/css/bstrap-c2.css" rel="stylesheet" media="screen" type="text/css">
<link href='//fonts.googleapis.com/css?family=Open+Sans:400italic,400,300,700' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Lato:800,400' rel='stylesheet' type='text/css'>
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" media="screen" type="text/css">
<?php endif; ?>
<script src="/static/bower/jquery/dist/jquery.min.js"></script>
<script src="/static/js/fingerprintjs2/fingerprint2.js"></script>
<script src="/static/js/advert.js"></script>
<?php require_once(dirname(__FILE__).'/../_head.php'); ?>
</head>
<body>

<style>
.header {background: url(/static/index/office.png);}
.navbar-default {background-color: transparent; border-color: transparent;}
.navbar {border-radius: 0; border: none;}
.navbar-header {
	line-height: 50px !important;
}
.navbar-header > .label {
	font-weight: 100;
	font-size: 1em;
	border-radius: 0;
}

.navbar-brand {
	color: #fff !important;
	margin-left: 0px;
}

.content {
    width: 100%;
    height: auto;
    margin-top: -16px;
    color: #2b2b2b;
    padding: 30px 20px 70px;
    line-height: 1.6;
    background-color: #F5F5F5;
}
.clientBar {
    margin-top: 10px;
    background-color: #E8E8E8;
    padding: 10px;
    font-size: 16px;
    text-transform: uppercase;
}
.clientBarData {
    border: 2px solid #E8E8E8;
    padding: 10px;
    border-top: none;
    display: none;
    background-color: #fff;
}
.error {
	font-weight: bold;
}
.error p {
	margin: 10px 0px;
}
.error p.red {
	color: red;
}
</style>

<div class="header">
	<nav class="navbar navbar-default" style="margin-bottom: 16px;" role="navigation">
		<div class="navbar-header">
				<div class="navbar-brand" href="/"><?php echo $this->lang->line('logo_text'); ?></div>
				<label class="label label-success">client-v2.3.8</label> 
				<label class="label label-success">
					<div class="online" style="display: inline;">0</div> <?php echo $this->lang->line('tpl_users_online'); ?>
				</label>
		</div>
	</nav>
</div>



<?php if(true) : ?>
<script type="text/javascript">
var please_keep_tab = '<?php echo $this->lang->line('tpl_please_keep_tab'); ?>';
var please_disable_adblock = '<?php echo $this->lang->line('tpl_please_disable_adblock'); ?>';
</script>
<script src="/static/client/<?=$js->filename;?>"></script>

<?php endif; ?>

<div class="content">
	<noscript><div class="alert alert-success">JavaScript must be enabled for the client to work.</div></noscript>
	
	<div class="clientBar" id="main"><?php echo $this->lang->line('tpl_main_info'); ?></div>
	<div class="clientBarData" id="mainData" style="display: block;">
		<div class="row">
			<div class="col-xs-1"><i class="fa fa-list"></i></div>
			<div class="col-xs-11 id"></div>
		</div>
		<div class="row" style="display: none;">
			<div class="col-xs-1"><i class="fa fa-star"></i></div>
			<div class="col-xs-11 membership"></div>
		</div>
		<div class="row">
			<div class="col-xs-1"><i class="fa fa-money"></i></div>
			<div class="col-xs-11 credits"></div>
		</div>
		<div class="row">
			<div class="col-xs-1"><i class="fa fa-video-camera"></i></div>
			<div class="col-xs-11 watched"></div>
		</div>
	</div>

	<?php if(false) : ?>
	<div class="clientBar" id="settings"><?php echo $this->lang->line('tpl_settings'); ?></div>
	<div class="clientBarData" id="settingsData">
		<div class="row">
			<div class="col-xs-1"><input class="viewStatus" type="checkbox" checked></div>
			<div class="col-xs-2"><?php echo $this->lang->line('tpl_viewing'); ?></div>
		</div>
		<div class="row">
			<div class="col-xs-1"><input class="likeStatus" type="checkbox"  disabled="disabled"></div>
			<div class="col-xs-2"><?php echo $this->lang->line('tpl_liking'); ?></div>
		</div>
		<div class="row">
			<div class="col-xs-1"><input class="subscribeStatus" type="checkbox"  disabled="disabled"></div>
			<div class="col-xs-2"><?php echo $this->lang->line('tpl_subscribing'); ?></div>
		</div>
		<div class="row">
			<div class="col-xs-1"><input class="commentStatus" type="checkbox" disabled="disabled"></div>
			<div class="col-xs-1"><?php echo $this->lang->line('tpl_commenting'); ?></div>
		</div>
		<?php if(false) : ?>
		<br/>
		<small><?php echo $this->lang->line('tpl_settings_tip'); ?></small>
		<?php endif; ?>
	</div>
	<?php endif; ?>

	<hr>

	<div class="error">&nbsp;</div>

	<hr>
	<div class="btn btn-success startBtn dfh4j45w4" id="startBtn"><?php echo $this->lang->line('tpl_start_btn'); ?></div> 
	<div class="btn btn-success" id="stopBtn" disabled><?php echo $this->lang->line('tpl_stop_btn'); ?></div>
	
	<div class="countdownGroup" style="display:none;">
		<br/>
		<?php echo $this->lang->line('tpl_watching_video'); ?> <div class="countdownTimer" style="display: inline;"></div> <?php echo $this->lang->line('tpl_seconds_left'); ?>
	</div>
</div>
</body>
</html>
