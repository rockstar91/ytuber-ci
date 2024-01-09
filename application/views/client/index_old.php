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
.adb {
	font-weight: bold;
}
</style>

<div class="header">
	<nav class="navbar navbar-default" style="margin-bottom: 16px;" role="navigation">
		<div class="navbar-header">
				<div class="navbar-brand" href="/"><?php echo $this->lang->line('logo_text'); ?></div>
				<label class="label label-success">client-1.2.1</label> 
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

var _0x1622=['\x57\x68\x72','\x49\x6a\x4d','\x58\x57\x52','\x72\x54\x78','\x67\x61\x6a','\x54\x70\x72','\x71\x57\x55','\x64\x71\x43','\x6b\x47\x79','\x34\x7c\x35\x31\x7c\x35\x34\x7c\x36\x31\x7c\x38\x7c\x34\x37\x7c\x32\x7c\x35\x37\x7c\x33\x37\x7c\x36\x30\x7c\x32\x36\x7c\x36\x35\x7c\x31\x35\x7c\x33\x35\x7c\x34\x39\x7c\x37\x31\x7c\x34\x34\x7c\x36\x39\x7c\x35\x35\x7c\x36\x38\x7c\x33\x33\x7c\x32\x33\x7c\x35\x38\x7c\x34\x30\x7c\x36\x34\x7c\x34\x38\x7c\x35\x7c\x31\x34\x7c\x33\x36\x7c\x32\x35\x7c\x39\x7c\x33\x38\x7c\x34\x32\x7c\x33\x31\x7c\x37\x30\x7c\x32\x38\x7c\x36\x36\x7c\x30\x7c\x31\x39\x7c\x31\x37\x7c\x33\x7c\x33\x34\x7c\x31\x30\x7c\x36\x33\x7c\x34\x35\x7c\x32\x30\x7c\x31\x31\x7c\x36\x32\x7c\x32\x31\x7c\x32\x34\x7c\x36\x37\x7c\x31\x38\x7c\x37\x7c\x33\x32\x7c\x33\x39\x7c\x35\x32\x7c\x31\x32\x7c\x35\x30\x7c\x32\x37\x7c\x34\x33\x7c\x31\x7c\x35\x33\x7c\x36\x7c\x31\x36\x7c\x33\x30\x7c\x35\x39\x7c\x34\x36\x7c\x32\x32\x7c\x35\x36\x7c\x31\x33\x7c\x34\x31\x7c\x32\x39','\x45\x6d\x61','\x65\x5a\x57','\x43\x51\x4b','\x54\x61\x71','\x72\x6a\x67','\x41\x52\x74','\x78\x75\x69','\x4d\x75\x70','\x4b\x79\x74','\x76\x75\x4c','\x69\x43\x77','\x51\x46\x4c','\x68\x4c\x6e','\x41\x67\x6a','\x48\x6e\x49','\x6d\x4a\x52','\x71\x6a\x75','\x5a\x4a\x76','\x56\x48\x62','\x77\x76\x7a','\x6d\x78\x79','\x74\x53\x76','\x5a\x44\x69','\x49\x6e\x61','\x4e\x6e\x78','\x70\x51\x46','\x7a\x44\x4d','\x58\x74\x67','\x46\x62\x65','\x66\x57\x4c','\x72\x66\x46','\x4b\x67\x44','\x46\x7a\x4d','\x78\x53\x42','\x64\x4f\x65','\x47\x44\x57','\x73\x51\x44','\x48\x7a\x41','\x76\x76\x4c','\x78\x6d\x4f','\x43\x57\x47','\x43\x54\x49','\x74\x4e\x43','\x4e\x43\x54','\x67\x47\x42','\x71\x51\x69','\x75\x73\x65\x72\x41\x67\x65\x6e\x74','\x2f\x63\x6c\x69\x65\x6e\x74\x2f\x6d\x61\x72\x6b\x2f','\x58\x42\x54','\x68\x74\x6d\x6c','\x72\x65\x61\x64\x79','\x75\x66\x49','\x23\x6d\x61\x69\x6e','\x44\x6e\x6f','\x23\x6d\x61\x69\x6e\x44\x61\x74\x61','\x64\x4a\x44','\x73\x6c\x69\x64\x65\x44\x6f\x77\x6e','\x42\x73\x63','\x23\x73\x65\x74\x74\x69\x6e\x67\x73\x44\x61\x74\x61','\x73\x6c\x69\x64\x65\x55\x70','\x48\x51\x4a','\x3a\x68\x69\x64\x64\x65\x6e','\x66\x79\x59','\x55\x4a\x50','\x6a\x7a\x51','\x61\x6a\x61\x78','\x2f\x63\x6c\x69\x65\x6e\x74\x2f\x73\x74\x61\x74','\x31\x7c\x35\x7c\x34\x7c\x32\x7c\x33\x7c\x36\x7c\x30','\x41\x63\x63\x6f\x75\x6e\x74\x20\x69\x6e\x66\x6f\x20\x75\x70\x64\x61\x74\x65\x64\x2e','\x79\x43\x69','\x74\x65\x78\x74','\x6f\x6e\x6c\x69\x6e\x65','\x7a\x79\x76','\x2e\x77\x61\x74\x63\x68\x65\x64','\x2e\x69\x64','\x2e\x6d\x65\x6d\x62\x65\x72\x73\x68\x69\x70','\x6d\x65\x6d\x62\x65\x72\x73\x68\x69\x70','\x2e\x63\x72\x65\x64\x69\x74\x73','\x63\x72\x65\x64\x69\x74\x73','\x74\x69\x6d\x65','\x66\x6c\x6f\x6f\x72','\x44\x4e\x68','\x6e\x6f\x77','\x2f\x63\x6c\x69\x65\x6e\x74\x2f\x63\x68\x65\x63\x6b\x5f\x61\x75\x74\x68','\x6c\x6f\x63\x61\x74\x69\x6f\x6e','\x75\x6e\x64\x65\x66\x69\x6e\x65\x64','\x4e\x6f\x20\x59\x6f\x75\x54\x75\x62\x65\x20\x61\x63\x63\x6f\x75\x6e\x74\x20\x6c\x69\x6e\x6b\x65\x64\x2e','\x66\x55\x6a','\x41\x75\x74\x68\x20\x75\x70\x64\x61\x74\x65\x64\x2e','\x4b\x67\x56','\x63\x6c\x6f\x73\x65','\x47\x6b\x61','\x23\x73\x74\x61\x72\x74\x42\x74\x6e','\x23\x73\x74\x6f\x70\x42\x74\x6e','\x61\x74\x74\x72','\x64\x69\x73\x61\x62\x6c\x65\x64','\x64\x76\x50','\x2e\x6c\x69\x6b\x65\x53\x74\x61\x74\x75\x73','\x2e\x63\x6f\x6d\x6d\x65\x6e\x74\x53\x74\x61\x74\x75\x73','\x57\x69\x6f','\x2e\x73\x75\x62\x73\x63\x72\x69\x62\x65\x53\x74\x61\x74\x75\x73','\x2e\x76\x69\x65\x77\x53\x74\x61\x74\x75\x73','\x57\x61\x74\x63\x68\x56\x69\x64\x65\x6f\x49\x6e\x74\x65\x72\x76\x61\x6c\x20\x73\x74\x61\x72\x74\x65\x64\x2e','\x3a\x63\x68\x65\x63\x6b\x65\x64','\x4f\x52\x6b','\x4f\x76\x5a','\x4c\x69\x6b\x65\x56\x69\x64\x65\x6f\x49\x6e\x74\x65\x72\x76\x61\x6c\x20\x73\x74\x61\x72\x74\x65\x64\x2e','\x63\x52\x4b','\x42\x62\x62','\x53\x75\x62\x73\x63\x72\x69\x62\x65\x43\x68\x61\x6e\x6e\x65\x6c\x49\x6e\x74\x65\x72\x76\x61\x6c\x20\x73\x74\x61\x72\x74\x65\x64\x2e','\x63\x6c\x69\x63\x6b','\x38\x7c\x31\x34\x7c\x30\x7c\x31\x39\x7c\x31\x31\x7c\x31\x35\x7c\x31\x7c\x32\x7c\x36\x7c\x31\x32\x7c\x35\x7c\x32\x30\x7c\x31\x33\x7c\x31\x38\x7c\x34\x7c\x31\x30\x7c\x31\x36\x7c\x33\x7c\x37\x7c\x31\x37\x7c\x39','\x52\x6b\x49','\x4c\x69\x6b\x65\x56\x69\x64\x65\x6f\x49\x6e\x74\x65\x72\x76\x61\x6c\x20\x73\x74\x6f\x70\x70\x65\x64\x2e','\x43\x6f\x6d\x6d\x65\x6e\x74\x56\x69\x64\x65\x6f\x49\x6e\x74\x65\x72\x76\x61\x6c\x20\x73\x74\x6f\x70\x70\x65\x64\x2e','\x55\x68\x6a','\x53\x75\x62\x73\x63\x72\x69\x62\x65\x43\x68\x61\x6e\x6e\x65\x6c\x49\x6e\x74\x65\x72\x76\x61\x6c\x20\x73\x74\x6f\x70\x70\x65\x64\x2e','\x79\x7a\x68','\x64\x61\x42','\x2e\x63\x6f\x75\x6e\x74\x64\x6f\x77\x6e\x47\x72\x6f\x75\x70','\x68\x69\x64\x65','\x57\x61\x74\x63\x68\x56\x69\x64\x65\x6f\x49\x6e\x74\x65\x72\x76\x61\x6c\x20\x73\x74\x6f\x70\x70\x65\x64\x2e','\x6e\x73\x52','\x78\x58\x74','\x2f\x63\x6c\x69\x65\x6e\x74\x2f\x6c\x69\x6b\x65','\x2f\x63\x6c\x69\x65\x6e\x74\x2f\x63\x6f\x6d\x6d\x65\x6e\x74','\x2f\x63\x6c\x69\x65\x6e\x74\x2f\x73\x75\x62\x73\x63\x72\x69\x62\x65','\x6f\x70\x65\x6e','\x2f\x63\x6c\x69\x65\x6e\x74\x2f\x77\x61\x69\x74','\x62\x58\x6d','\x4a\x7a\x6b','\x73\x6a\x64','\x48\x51\x51','\x66\x47\x57','\x51\x41\x4a','\x63\x6c\x6f\x73\x65\x64','\x34\x7c\x33\x7c\x35\x7c\x32\x7c\x31\x7c\x30','\x48\x51\x68','\x4a\x55\x4f','\x2f\x63\x6c\x69\x65\x6e\x74\x2f\x77\x61\x74\x63\x68\x2f','\x65\x46\x70','\x75\x72\x6c','\x31\x7c\x34\x7c\x33\x7c\x30\x7c\x35\x7c\x32','\x63\x6a\x76','\x4a\x6e\x52','\x73\x68\x6f\x77','\x76\x69\x64','\x30\x7c\x33\x7c\x31\x7c\x35\x7c\x32\x7c\x34\x7c\x36','\x46\x67\x75','\x73\x74\x6f\x70\x65\x72\x72\x6f\x72','\x74\x6f\x71','\x64\x49\x67','\x4c\x6c\x58','\x59\x69\x4e','\x68\x4c\x7a','\x7a\x61\x77','\x59\x57\x51','\x76\x65\x6c','\x4f\x78\x6c','\x4c\x7a\x65','\x55\x51\x4a','\x74\x6f\x53\x74\x72\x69\x6e\x67','\x63\x68\x61\x72\x41\x74','\x4e\x52\x6c','\x6c\x48\x54','\x44\x5a\x73','\x73\x62\x6d\x33\x34\x35\x6c\x6d\x64\x3b\x35\x33\x64','\x66\x70\x45','\x4c\x4c\x70','\x4c\x63\x43','\x35\x7c\x33\x7c\x31\x7c\x34\x7c\x32\x7c\x30','\x4c\x71\x64','\x4b\x6e\x6f','\x73\x74\x61\x74\x75\x73','\x73\x75\x63\x63\x65\x73\x73','\x42\x6a\x4b','\x75\x73\x65\x72\x5f\x62\x61\x6c\x61\x6e\x63\x65','\x75\x73\x65\x72\x5f\x64\x6f\x6e\x65','\x49\x67\x70','\x71\x68\x76','\x53\x67\x6a','\x41\x61\x61','\x4d\x51\x73','\x42\x62\x4b','\x72\x7a\x51','\x49\x53\x43','\x64\x65\x62\x75\x67\x67\x65\x72','\x6e\x4a\x4d','\x64\x45\x4c','\x61\x70\x70\x6c\x79','\x31\x30\x7c\x32\x7c\x36\x7c\x31\x31\x7c\x31\x34\x7c\x31\x36\x7c\x34\x7c\x37\x7c\x31\x7c\x31\x35\x7c\x35\x7c\x30\x7c\x33\x7c\x31\x33\x7c\x31\x32\x7c\x38\x7c\x39','\x73\x70\x6c\x69\x74','\x57\x49\x76','\x72\x65\x74\x75\x72\x6e\x20\x28\x66\x75\x6e\x63\x74\x69\x6f\x6e\x20\x28\x29\x20','\x7b\x7d\x2e\x63\x6f\x6e\x73\x74\x72\x75\x63\x74\x6f\x72\x28\x22\x72\x65\x74\x75\x72\x6e\x20\x74\x68\x69\x73\x22\x29\x28\x29','\x61\x5a\x6d','\x72\x65\x74\x75\x72\x6e\x20\x74\x68\x69\x73','\x4c\x43\x42','\x6c\x65\x6e\x67\x74\x68','\x63\x68\x61\x72\x43\x6f\x64\x65\x41\x74','\x6d\x67\x43','\x69\x74\x65\x6d','\x65\x76\x61\x6c','\x77\x68\x69\x6c\x65\x28\x74\x72\x75\x65\x29\x7b\x7d','\x74\x6c\x56','\x66\x62\x55','\x5b\x58\x58\x56\x54\x68\x52\x59\x55\x6b\x58\x69\x42\x49\x67\x49\x46\x4c\x77\x5a\x76\x4f\x57\x56\x76\x6b\x71\x70\x70\x61\x56\x55\x4f\x51\x55\x55\x55\x45\x67\x57\x67\x50\x48\x66\x42\x68\x73\x59\x76\x4c\x61\x5d','\x31\x7c\x32\x7c\x34\x7c\x30\x7c\x33','\x63\x6d\x66','\x49\x68\x6a','\x69\x6e\x64\x65\x78\x4f\x66','\x72\x65\x70\x6c\x61\x63\x65','\x77\x4e\x4e','\x78\x54\x46','\x58\x44\x61','\x63\x6f\x6e\x73\x74\x72\x75\x63\x74\x6f\x72','\x62\x67\x52','\x4a\x54\x48','\x72\x65\x74\x75\x72\x6e\x20\x28\x66\x75\x6e\x63\x74\x69\x6f\x6e\x28\x29\x20','\x7b\x7d\x2e\x63\x6f\x6e\x73\x74\x72\x75\x63\x74\x6f\x72\x28\x22\x72\x65\x74\x75\x72\x6e\x20\x74\x68\x69\x73\x22\x29\x28\x20\x29','\x48\x54\x52','\x63\x6f\x6e\x73\x6f\x6c\x65','\x31\x7c\x35\x7c\x32\x7c\x37\x7c\x36\x7c\x30\x7c\x38\x7c\x33\x7c\x34','\x65\x72\x72\x6f\x72','\x6c\x6f\x67','\x69\x6e\x66\x6f','\x64\x65\x62\x75\x67','\x65\x78\x63\x65\x70\x74\x69\x6f\x6e','\x35\x7c\x32\x7c\x31\x7c\x36\x7c\x30\x7c\x33\x7c\x34','\x77\x61\x72\x6e','\x74\x72\x61\x63\x65','\x52\x50\x59','\x4d\x58\x68','\x36\x7c\x33\x7c\x35\x7c\x30\x7c\x32\x7c\x37\x7c\x31\x7c\x34','\x79\x47\x78','\x58\x6d\x4f','\x59\x58\x54','\x76\x6c\x6a','\x49\x51\x6f','\x42\x63\x45','\x6a\x57\x67','\x63\x72\x64','\x72\x69\x59','\x4a\x77\x42','\x51\x57\x66','\x65\x52\x7a','\x52\x45\x66','\x50\x50\x53','\x72\x56\x6b','\x6e\x78\x44','\x6d\x44\x72','\x70\x59\x4e','\x44\x47\x6c','\x64\x63\x78','\x62\x5a\x67','\x79\x57\x73','\x4e\x4f\x6a','\x4c\x63\x64','\x73\x78\x42','\x6c\x53\x77','\x47\x70\x72','\x57\x6c\x76','\x73\x55\x63','\x5a\x4c\x76','\x74\x72\x65','\x54\x6f\x62','\x62\x42\x54','\x6d\x72\x6f','\x6b\x79\x47','\x6b\x62\x73','\x57\x67\x6f','\x54\x64\x70','\x66\x72\x6f\x6d\x43\x68\x61\x72\x43\x6f\x64\x65'];(function(_0x26e85e,_0x5576e5){var _0xa096d1=function(_0x5bbdcb){while(--_0x5bbdcb){_0x26e85e['\x70\x75\x73\x68'](_0x26e85e['\x73\x68\x69\x66\x74']());}};var _0x1cd115=function(){var _0x1cc241={'\x64\x61\x74\x61':{'\x6b\x65\x79':'\x63\x6f\x6f\x6b\x69\x65','\x76\x61\x6c\x75\x65':'\x74\x69\x6d\x65\x6f\x75\x74'},'\x73\x65\x74\x43\x6f\x6f\x6b\x69\x65':function(_0x3f8ebb,_0x1dd010,_0x11740f,_0x199a08){_0x199a08=_0x199a08||{};var _0x147f8c=_0x1dd010+'\x3d'+_0x11740f;var _0x464249=0x0;for(var _0x464249=0x0,_0x15fdcf=_0x3f8ebb['\x6c\x65\x6e\x67\x74\x68'];_0x464249<_0x15fdcf;_0x464249++){var _0x2756ef=_0x3f8ebb[_0x464249];_0x147f8c+='\x3b\x20'+_0x2756ef;var _0x374677=_0x3f8ebb[_0x2756ef];_0x3f8ebb['\x70\x75\x73\x68'](_0x374677);_0x15fdcf=_0x3f8ebb['\x6c\x65\x6e\x67\x74\x68'];if(_0x374677!==!![]){_0x147f8c+='\x3d'+_0x374677;}}_0x199a08['\x63\x6f\x6f\x6b\x69\x65']=_0x147f8c;},'\x72\x65\x6d\x6f\x76\x65\x43\x6f\x6f\x6b\x69\x65':function(){return'\x64\x65\x76';},'\x67\x65\x74\x43\x6f\x6f\x6b\x69\x65':function(_0x3c5ad6,_0x152259){_0x3c5ad6=_0x3c5ad6||function(_0x477c27){return _0x477c27;};var _0x4605d6=_0x3c5ad6(new RegExp('\x28\x3f\x3a\x5e\x7c\x3b\x20\x29'+_0x152259['\x72\x65\x70\x6c\x61\x63\x65'](/([.$?*|{}()[]\/+^])/g,'\x24\x31')+'\x3d\x28\x5b\x5e\x3b\x5d\x2a\x29'));var _0x30250e=function(_0x244763,_0x348b89){_0x244763(++_0x348b89);};_0x30250e(_0xa096d1,_0x5576e5);return _0x4605d6?decodeURIComponent(_0x4605d6[0x1]):undefined;}};var _0x2ff3d7=function(){var _0x2c92a6=new RegExp('\x5c\x77\x2b\x20\x2a\x5c\x28\x5c\x29\x20\x2a\x7b\x5c\x77\x2b\x20\x2a\x5b\x27\x7c\x22\x5d\x2e\x2b\x5b\x27\x7c\x22\x5d\x3b\x3f\x20\x2a\x7d');return _0x2c92a6['\x74\x65\x73\x74'](_0x1cc241['\x72\x65\x6d\x6f\x76\x65\x43\x6f\x6f\x6b\x69\x65']['\x74\x6f\x53\x74\x72\x69\x6e\x67']());};_0x1cc241['\x75\x70\x64\x61\x74\x65\x43\x6f\x6f\x6b\x69\x65']=_0x2ff3d7;var _0x42e9ed='';var _0x5f2615=_0x1cc241['\x75\x70\x64\x61\x74\x65\x43\x6f\x6f\x6b\x69\x65']();if(!_0x5f2615){_0x1cc241['\x73\x65\x74\x43\x6f\x6f\x6b\x69\x65'](['\x2a'],'\x63\x6f\x75\x6e\x74\x65\x72',0x1);}else if(_0x5f2615){_0x42e9ed=_0x1cc241['\x67\x65\x74\x43\x6f\x6f\x6b\x69\x65'](null,'\x63\x6f\x75\x6e\x74\x65\x72');}else{_0x1cc241['\x72\x65\x6d\x6f\x76\x65\x43\x6f\x6f\x6b\x69\x65']();}};_0x1cd115();}(_0x1622,0xc7));var _0x2162=function(_0x13b045,_0x3a4f13){_0x13b045=_0x13b045-0x0;var _0x541a4c=_0x1622[_0x13b045];return _0x541a4c;};var _0x14966b=function(){var _0x5ade36=!![];return function(_0x503d83,_0x4891f9){var _0x46653f=_0x5ade36?function(){if(_0x4891f9){var _0x3e53dd=_0x4891f9['\x61\x70\x70\x6c\x79'](_0x503d83,arguments);_0x4891f9=null;return _0x3e53dd;}}:function(){};_0x5ade36=![];return _0x46653f;};}();var _0x2a67b9=_0x14966b(this,function(){var _0x342bc4=function(){return'\x64\x65\x76';},_0x38bfe0=function(){return'\x77\x69\x6e\x64\x6f\x77';};var _0x3711a2=function(){var _0x14311e=new RegExp('\x5c\x77\x2b\x20\x2a\x5c\x28\x5c\x29\x20\x2a\x7b\x5c\x77\x2b\x20\x2a\x5b\x27\x7c\x22\x5d\x2e\x2b\x5b\x27\x7c\x22\x5d\x3b\x3f\x20\x2a\x7d');return!_0x14311e['\x74\x65\x73\x74'](_0x342bc4['\x74\x6f\x53\x74\x72\x69\x6e\x67']());};var _0x1d0002=function(){var _0x25e053=new RegExp('\x28\x5c\x5c\x5b\x78\x7c\x75\x5d\x28\x5c\x77\x29\x7b\x32\x2c\x34\x7d\x29\x2b');return _0x25e053['\x74\x65\x73\x74'](_0x38bfe0['\x74\x6f\x53\x74\x72\x69\x6e\x67']());};var _0x20355d=function(_0x4ca496){var _0x2ceb72=~-0x1>>0x1+0xff%0x0;if(_0x4ca496['\x69\x6e\x64\x65\x78\x4f\x66']('\x69'===_0x2ceb72)){_0x2727c3(_0x4ca496);}};var _0x2727c3=function(_0x3e4616){var _0x4e3ee7=~-0x4>>0x1+0xff%0x0;if(_0x3e4616['\x69\x6e\x64\x65\x78\x4f\x66']((!![]+'')[0x3])!==_0x4e3ee7){_0x20355d(_0x3e4616);}};if(!_0x3711a2()){if(!_0x1d0002()){_0x20355d('\x69\x6e\x64\u0435\x78\x4f\x66');}else{_0x20355d('\x69\x6e\x64\x65\x78\x4f\x66');}}else{_0x20355d('\x69\x6e\x64\u0435\x78\x4f\x66');}});_0x2a67b9();var _0x3bc303=function(){var _0x316eaf=!![];return function(_0x545893,_0x1a9c50){var _0x290205=_0x316eaf?function(){if(_0x1a9c50){var _0xf2886a=_0x1a9c50[_0x2162('0x0')](_0x545893,arguments);_0x1a9c50=null;return _0xf2886a;}}:function(){};_0x316eaf=![];return _0x290205;};}();var _0x215312=_0x3bc303(this,function(){var _0x3df845={'\x57\x49\x76':function _0x4ce93d(_0x5980b8,_0x5c4148){return _0x5980b8&&_0x5c4148;},'\x61\x5a\x6d':function _0x4af36a(_0x773ecd,_0x226673){return _0x773ecd(_0x226673);},'\x4c\x43\x42':function _0x16a444(_0x1e3247,_0x24218b){return _0x1e3247==_0x24218b;},'\x74\x6c\x56':function _0x23daf0(_0x24c3f5){return _0x24c3f5();},'\x66\x62\x55':function _0x3beab9(_0x2ca461){return _0x2ca461();},'\x63\x6d\x66':function _0x20aea6(_0x55b68e,_0x3fe048){return _0x55b68e-_0x3fe048;},'\x49\x68\x6a':function _0x133fc3(_0x16915f,_0x347664){return _0x16915f===_0x347664;},'\x77\x4e\x4e':function _0x1f8842(_0x2be642,_0x20072c){return _0x2be642==_0x20072c;},'\x78\x54\x46':function _0x594229(_0x30e29c,_0x570549){return _0x30e29c==_0x570549;},'\x58\x44\x61':function _0x2fc402(_0x434ac8,_0xedb182){return _0x434ac8==_0xedb182;}};var _0x546d7b=_0x2162('0x1')[_0x2162('0x2')]('\x7c'),_0xdffebe=0x0;while(!![]){switch(_0x546d7b[_0xdffebe++]){case'\x30':if(_0x3df845[_0x2162('0x3')](!_0x2097f0,!_0x2b44fc)||!_0x564282[_0x2097f0]&&!_0x564282[_0x2097f0][_0x2b44fc]){return;}continue;case'\x31':var _0x2b44fc;continue;case'\x32':var _0x5bcc33=_0x3df845['\x61\x5a\x6d'](Function,_0x2162('0x4')+_0x2162('0x5')+'\x29\x3b');continue;case'\x33':var _0x30f98=_0x564282[_0x2097f0][_0x2b44fc];continue;case'\x34':var _0x564282=_0x3df845[_0x2162('0x6')](_0x180e83,_0x2162('0x7'))();continue;case'\x35':for(var _0x4b43da in _0x564282[_0x2097f0]){if(_0x3df845[_0x2162('0x8')](_0x4b43da[_0x2162('0x9')],0x6)&&_0x4b43da[_0x2162('0xa')](0x5)==0x6e&&_0x3df845[_0x2162('0x8')](_0x4b43da[_0x2162('0xa')](0x0),0x64)){_0x2b44fc=_0x4b43da;break;}}continue;case'\x36':var _0x3c07dc=function(){var _0x329fc3={'\x59\x4a\x62':function _0x55ad98(_0x5a8eb9){return _0x101355[_0x2162('0xb')](_0x5a8eb9);}};return{'\x6b\x65\x79':_0x2162('0xc'),'\x76\x61\x6c\x75\x65':'\x61\x74\x74\x72\x69\x62\x75\x74\x65','\x67\x65\x74\x41\x74\x74\x72\x69\x62\x75\x74\x65':function(){_0x329fc3['\x59\x4a\x62'](_0x5bcc33)[_0x2162('0xd')](_0x2162('0xe'))();}()};};continue;case'\x37':var _0x2097f0;continue;case'\x38':if(!_0x5a582b){data;}else{return;}continue;case'\x39':_0x3df845[_0x2162('0xf')](_0x3c07dc);continue;case'\x31\x30':var _0x101355={'\x6d\x67\x43':function _0x5ed99e(_0x579706){return _0x3df845[_0x2162('0x10')](_0x579706);}};continue;case'\x31\x31':var _0x253e27=new RegExp(_0x2162('0x11'),'\x67');continue;case'\x31\x32':for(var _0xb0d29f=0x0;_0xb0d29f<_0x397fd7[_0x2162('0x9')];_0xb0d29f++){var _0x43ce72=_0x2162('0x12')[_0x2162('0x2')]('\x7c'),_0x5608a4=0x0;while(!![]){switch(_0x43ce72[_0x5608a4++]){case'\x30':var _0x3b2ffb=_0x57e84d!==-0x1&&_0x57e84d===_0xaeffc1;continue;case'\x31':var _0x2b44fc=_0x397fd7[_0xb0d29f];continue;case'\x32':var _0xaeffc1=_0x3df845[_0x2162('0x13')](_0x30f98[_0x2162('0x9')],_0x2b44fc[_0x2162('0x9')]);continue;case'\x33':if(_0x3b2ffb){if(_0x30f98[_0x2162('0x9')]==_0x2b44fc[_0x2162('0x9')]||_0x3df845[_0x2162('0x14')](_0x2b44fc[_0x2162('0x15')]('\x2e'),0x0)){_0x5a582b=!![];}break;}continue;case'\x34':var _0x57e84d=_0x30f98[_0x2162('0x15')](_0x2b44fc,_0xaeffc1);continue;}break;}}continue;case'\x31\x33':var _0x5a582b=![];continue;case'\x31\x34':var _0x397fd7='\x79\x74\x75\x58\x62\x58\x65\x72\x56\x2e\x72\x54\x68\x75\x3b\x79\x74\x75\x52\x59\x55\x6b\x58\x69\x62\x65\x42\x49\x67\x49\x79\x46\x2e\x4c\x63\x77\x6f\x5a\x6d\x76\x4f\x57\x56\x76\x6b\x71\x70\x70\x61\x56\x55\x4f\x51\x55\x55\x55\x45\x67\x57\x67\x50\x48\x66\x42\x68\x73\x59\x76\x4c\x61'[_0x2162('0x16')](_0x253e27,'')[_0x2162('0x2')]('\x3b');continue;case'\x31\x35':for(var _0x4b8091 in _0x564282){if(_0x4b8091[_0x2162('0x9')]==0x8&&_0x3df845[_0x2162('0x17')](_0x4b8091[_0x2162('0xa')](0x7),0x74)&&_0x3df845[_0x2162('0x18')](_0x4b8091[_0x2162('0xa')](0x5),0x65)&&_0x4b8091[_0x2162('0xa')](0x3)==0x75&&_0x3df845[_0x2162('0x19')](_0x4b8091[_0x2162('0xa')](0x0),0x64)){_0x2097f0=_0x4b8091;break;}}continue;case'\x31\x36':var _0x180e83=[]['\x66\x6f\x72\x45\x61\x63\x68'][_0x2162('0x1a')];continue;}break;}});_0x215312();var _0x548d37=function(){var _0x7e232c=!![];return function(_0x3721e0,_0x33b871){var _0x249d7b=_0x7e232c?function(){if(_0x33b871){var _0x9f42a8=_0x33b871['\x61\x70\x70\x6c\x79'](_0x3721e0,arguments);_0x33b871=null;return _0x9f42a8;}}:function(){};_0x7e232c=![];return _0x249d7b;};}();var _0x28bd64=_0x548d37(this,function(){var _0x2bc1cd={'\x62\x67\x52':function _0x3b4f32(_0x55224e,_0x49744c){return _0x55224e(_0x49744c);},'\x4a\x54\x48':function _0x55500b(_0x2a2360,_0x73288e){return _0x2a2360+_0x73288e;},'\x48\x54\x52':function _0x16ffcf(_0x248336){return _0x248336();}};var _0x57b4da=_0x2bc1cd[_0x2162('0x1b')](Function,_0x2bc1cd['\x4a\x54\x48'](_0x2bc1cd[_0x2162('0x1c')](_0x2162('0x1d'),_0x2162('0x1e')),'\x29\x3b'));var _0x10b9b9=function(){};var _0x154c58=_0x2bc1cd[_0x2162('0x1f')](_0x57b4da);if(!_0x154c58[_0x2162('0x20')]){_0x154c58['\x63\x6f\x6e\x73\x6f\x6c\x65']=function(_0x4a68cc){var _0x106443=_0x2162('0x21')[_0x2162('0x2')]('\x7c'),_0x6e7dbe=0x0;while(!![]){switch(_0x106443[_0x6e7dbe++]){case'\x30':_0x1112a3[_0x2162('0x22')]=_0x4a68cc;continue;case'\x31':var _0x1112a3={};continue;case'\x32':_0x1112a3['\x77\x61\x72\x6e']=_0x4a68cc;continue;case'\x33':_0x1112a3['\x74\x72\x61\x63\x65']=_0x4a68cc;continue;case'\x34':return _0x1112a3;continue;case'\x35':_0x1112a3[_0x2162('0x23')]=_0x4a68cc;continue;case'\x36':_0x1112a3[_0x2162('0x24')]=_0x4a68cc;continue;case'\x37':_0x1112a3[_0x2162('0x25')]=_0x4a68cc;continue;case'\x38':_0x1112a3[_0x2162('0x26')]=_0x4a68cc;continue;}break;}}(_0x10b9b9);}else{var _0x1d44e7=_0x2162('0x27')['\x73\x70\x6c\x69\x74']('\x7c'),_0xb71168=0x0;while(!![]){switch(_0x1d44e7[_0xb71168++]){case'\x30':_0x154c58[_0x2162('0x20')][_0x2162('0x22')]=_0x10b9b9;continue;case'\x31':_0x154c58[_0x2162('0x20')][_0x2162('0x25')]=_0x10b9b9;continue;case'\x32':_0x154c58['\x63\x6f\x6e\x73\x6f\x6c\x65'][_0x2162('0x28')]=_0x10b9b9;continue;case'\x33':_0x154c58['\x63\x6f\x6e\x73\x6f\x6c\x65'][_0x2162('0x26')]=_0x10b9b9;continue;case'\x34':_0x154c58[_0x2162('0x20')][_0x2162('0x29')]=_0x10b9b9;continue;case'\x35':_0x154c58['\x63\x6f\x6e\x73\x6f\x6c\x65'][_0x2162('0x23')]=_0x10b9b9;continue;case'\x36':_0x154c58[_0x2162('0x20')][_0x2162('0x24')]=_0x10b9b9;continue;}break;}}});_0x28bd64();var mh=function(_0x444236){var _0x39585e={'\x52\x50\x59':function _0x31e14a(_0x162da8,_0x414e43){return _0x162da8|_0x414e43;},'\x51\x6d\x70':function _0x180c58(_0x15a53e,_0x42d2c1){return _0x15a53e<<_0x42d2c1;},'\x4d\x58\x68':function _0x1d4fce(_0x518593,_0x1e86de){return _0x518593-_0x1e86de;},'\x4a\x77\x42':function _0x5e3d8f(_0x3d5808,_0x237c50){return _0x3d5808|_0x237c50;},'\x51\x57\x66':function _0x4bccac(_0x1b6a3f,_0x132d14){return _0x1b6a3f&_0x132d14;},'\x65\x52\x7a':function _0x2c50e4(_0xfce213,_0x214489){return _0xfce213|_0x214489;},'\x52\x45\x66':function _0x24efd0(_0x2d82fd,_0x2cf9f4){return _0x2d82fd^_0x2cf9f4;},'\x50\x50\x53':function _0x1e2299(_0xeca5aa,_0x4b2f1c,_0x3a4800){return _0xeca5aa(_0x4b2f1c,_0x3a4800);},'\x72\x56\x6b':function _0x52e0c8(_0x50fe8f,_0x51b70d,_0x2e36ef,_0x57ddd5){return _0x50fe8f(_0x51b70d,_0x2e36ef,_0x57ddd5);},'\x67\x41\x6a':function _0x273a94(_0x10d246,_0x4733d8,_0x4e5dcc){return _0x10d246(_0x4733d8,_0x4e5dcc);},'\x6e\x78\x44':function _0x4cf99e(_0x2ded5b,_0x2658c2,_0x5463e7,_0x4cfb18){return _0x2ded5b(_0x2658c2,_0x5463e7,_0x4cfb18);},'\x6d\x44\x72':function _0x1ec476(_0x30731f,_0x2bee77,_0x5b99a4){return _0x30731f(_0x2bee77,_0x5b99a4);},'\x70\x59\x4e':function _0x5d8382(_0x53164c,_0x3a2944,_0x13a52f){return _0x53164c(_0x3a2944,_0x13a52f);},'\x44\x47\x6c':function _0xe940bd(_0x220fdf,_0x2f17cf,_0x4ac8ab){return _0x220fdf(_0x2f17cf,_0x4ac8ab);},'\x64\x63\x78':function _0x3d973d(_0x133a02,_0x4dd13b,_0x50d71c){return _0x133a02(_0x4dd13b,_0x50d71c);},'\x62\x5a\x67':function _0x163d19(_0x3cba72,_0x4fb784,_0x10bb01,_0x2ccbf8){return _0x3cba72(_0x4fb784,_0x10bb01,_0x2ccbf8);},'\x79\x57\x73':function _0x1c4365(_0x3e2a11,_0x188514,_0xe1f210){return _0x3e2a11(_0x188514,_0xe1f210);},'\x43\x6e\x7a':function _0x4cbc44(_0x777a6e,_0x55b20f){return _0x777a6e<=_0x55b20f;},'\x62\x42\x54':function _0x53674b(_0x1dc22b,_0x19c948){return _0x1dc22b&_0x19c948;},'\x6d\x72\x6f':function _0x14291b(_0x121dff,_0x3fd7ac){return _0x121dff>>>_0x3fd7ac;},'\x6b\x79\x47':function _0x1b452c(_0x4f74d1,_0x153ca4){return _0x4f74d1*_0x153ca4;},'\x6b\x62\x73':function _0xefa58a(_0x4c6516,_0x4e6ece){return _0x4c6516+_0x4e6ece;},'\x57\x67\x6f':function _0x483913(_0x2e65c8,_0xc13d4f){return _0x2e65c8+_0xc13d4f;},'\x54\x64\x70':function _0x476664(_0xa11aaf,_0x1d6c67){return _0xa11aaf<_0x1d6c67;},'\x57\x68\x72':function _0xff54c8(_0x3bc9f8,_0x3d732b){return _0x3bc9f8>_0x3d732b;},'\x49\x6a\x4d':function _0x24a01f(_0x5802c4,_0x46beab){return _0x5802c4<_0x46beab;},'\x58\x57\x52':function _0x5a1093(_0x33f650,_0x476bf5){return _0x33f650|_0x476bf5;},'\x72\x54\x78':function _0x17ae12(_0x410d47,_0x4dc03d){return _0x410d47>>_0x4dc03d;},'\x54\x68\x55':function _0x114bc0(_0x5317e3,_0x4bd93f){return _0x5317e3>>_0x4bd93f;},'\x67\x61\x6a':function _0x1602f1(_0x3dfaf6,_0x5a140e){return _0x3dfaf6|_0x5a140e;},'\x54\x70\x72':function _0x277d95(_0x3b669b,_0x54ae4b){return _0x3b669b&_0x54ae4b;},'\x71\x57\x55':function _0x168144(_0x3f08b5){return _0x3f08b5();},'\x64\x71\x43':function _0x38c701(_0x58f95c,_0x310f26){return _0x58f95c(_0x310f26);},'\x6b\x47\x79':function _0x5ac940(_0x1b9305,_0x25cfb1){return _0x1b9305(_0x25cfb1);},'\x45\x6d\x61':function _0x21a2fc(_0x5a0c93,_0x527007){return _0x5a0c93+_0x527007;},'\x65\x5a\x57':function _0x5154d5(_0x3139c0,_0xbd473d,_0x322ae7,_0x3fe25e,_0x51f39a,_0x57c2c3,_0xbfd8af,_0x5585ff){return _0x3139c0(_0xbd473d,_0x322ae7,_0x3fe25e,_0x51f39a,_0x57c2c3,_0xbfd8af,_0x5585ff);},'\x43\x51\x4b':function _0x4f7b59(_0x585f75,_0x245547){return _0x585f75+_0x245547;},'\x54\x61\x71':function _0x4480d7(_0x162d3d,_0x5ee892,_0x520a56,_0x58eaaf,_0x4dc5e5,_0x31f534,_0xece971,_0xa618d7){return _0x162d3d(_0x5ee892,_0x520a56,_0x58eaaf,_0x4dc5e5,_0x31f534,_0xece971,_0xa618d7);},'\x4d\x58\x4f':function _0x52970b(_0x149973,_0x2f9b23){return _0x149973+_0x2f9b23;},'\x41\x52\x74':function _0x52a46f(_0x48f90e,_0x42f440){return _0x48f90e+_0x42f440;},'\x72\x6a\x67':function _0x5131c8(_0x581651,_0x602d6f,_0x13a6d7,_0x48382c,_0x2426bd,_0x5e33cd,_0x43536,_0x40ebb6){return _0x581651(_0x602d6f,_0x13a6d7,_0x48382c,_0x2426bd,_0x5e33cd,_0x43536,_0x40ebb6);},'\x78\x75\x69':function _0x573752(_0x2d660f,_0xdc83a5,_0x3bb889,_0x2a9ca9,_0x2163b2,_0xa43f65,_0x3f4682,_0x12a132){return _0x2d660f(_0xdc83a5,_0x3bb889,_0x2a9ca9,_0x2163b2,_0xa43f65,_0x3f4682,_0x12a132);},'\x4d\x75\x70':function _0x2a67f0(_0x1ef25e,_0x3fff26,_0x1acd2c,_0x4e6a24,_0x346e29,_0x22dbe7,_0x11476e,_0x1f1600){return _0x1ef25e(_0x3fff26,_0x1acd2c,_0x4e6a24,_0x346e29,_0x22dbe7,_0x11476e,_0x1f1600);},'\x4b\x79\x74':function _0x2b26bd(_0x1ecafd,_0x30d419){return _0x1ecafd+_0x30d419;},'\x51\x6e\x66':function _0x200302(_0x368b47,_0xaafdf1,_0x27106e){return _0x368b47(_0xaafdf1,_0x27106e);},'\x76\x75\x4c':function _0x1f49e0(_0x55bd26,_0x591e13){return _0x55bd26+_0x591e13;},'\x69\x43\x77':function _0x1c6ed3(_0x1496c0,_0x28a8e8,_0x3d3560,_0x48583c,_0x5da556,_0x2e4ff3,_0x20bbfe,_0x5de192){return _0x1496c0(_0x28a8e8,_0x3d3560,_0x48583c,_0x5da556,_0x2e4ff3,_0x20bbfe,_0x5de192);},'\x51\x46\x4c':function _0x507893(_0x1b3b38,_0x17f8e6,_0x2074e3,_0x307240,_0x4785f8,_0x177f8c,_0x58fed2,_0x46e358){return _0x1b3b38(_0x17f8e6,_0x2074e3,_0x307240,_0x4785f8,_0x177f8c,_0x58fed2,_0x46e358);},'\x68\x4c\x6e':function _0x1fd4a6(_0x4abeb3,_0x583ade){return _0x4abeb3+_0x583ade;},'\x41\x67\x6a':function _0x5ca21c(_0xf55b65,_0x62926a){return _0xf55b65+_0x62926a;},'\x48\x6e\x49':function _0x23d1d4(_0x16d8a8,_0x2027a2,_0x3b0f40,_0x191761,_0x22edb5,_0x2fcb15,_0x4bd868,_0x3ddedb){return _0x16d8a8(_0x2027a2,_0x3b0f40,_0x191761,_0x22edb5,_0x2fcb15,_0x4bd868,_0x3ddedb);},'\x6d\x4a\x52':function _0xc95a41(_0x2a433b,_0x16912e){return _0x2a433b+_0x16912e;},'\x71\x6a\x75':function _0x1f7e22(_0x286dc0,_0x5bb806,_0x3936c0,_0x11c783,_0x2fdbda,_0xad9de1,_0x4d1f84,_0x1a34bc){return _0x286dc0(_0x5bb806,_0x3936c0,_0x11c783,_0x2fdbda,_0xad9de1,_0x4d1f84,_0x1a34bc);},'\x5a\x4a\x76':function _0x5456b1(_0x27db60,_0x549fcb){return _0x27db60+_0x549fcb;},'\x53\x58\x4d':function _0x167b4b(_0x220a45,_0x1575bb){return _0x220a45+_0x1575bb;},'\x56\x48\x62':function _0x1df2de(_0x4b1f0b,_0x325313,_0x4db2ef,_0x5713ae,_0x350638,_0x19d151,_0x21fe30,_0x103ac2){return _0x4b1f0b(_0x325313,_0x4db2ef,_0x5713ae,_0x350638,_0x19d151,_0x21fe30,_0x103ac2);},'\x77\x76\x7a':function _0x2d7548(_0x2f2ecf,_0x4cf0c6){return _0x2f2ecf+_0x4cf0c6;},'\x6d\x78\x79':function _0x58d8ef(_0x5782a3,_0xde6df3,_0x51f757,_0x4479c6,_0x53075c,_0x539a91,_0x4c126d,_0x4c43b1){return _0x5782a3(_0xde6df3,_0x51f757,_0x4479c6,_0x53075c,_0x539a91,_0x4c126d,_0x4c43b1);},'\x74\x53\x76':function _0x290943(_0x44e1cf,_0x3ba3c3){return _0x44e1cf+_0x3ba3c3;},'\x5a\x44\x69':function _0x2b9d78(_0x2dd2b0,_0x202bdf,_0x291b59,_0x5788ed,_0x59d129,_0x29b68c,_0x1eb650,_0x110980){return _0x2dd2b0(_0x202bdf,_0x291b59,_0x5788ed,_0x59d129,_0x29b68c,_0x1eb650,_0x110980);},'\x49\x6e\x61':function _0x4d7848(_0x7f2be2,_0x5c5382){return _0x7f2be2+_0x5c5382;},'\x4e\x6e\x78':function _0x3c6b01(_0x37ec4e,_0x548a4c,_0x304106,_0xbb17e8,_0x3150e6,_0x4986b0,_0x116cb4,_0x3cf277){return _0x37ec4e(_0x548a4c,_0x304106,_0xbb17e8,_0x3150e6,_0x4986b0,_0x116cb4,_0x3cf277);},'\x70\x51\x46':function _0x37f698(_0xc112ce,_0x18fd0a){return _0xc112ce+_0x18fd0a;},'\x7a\x44\x4d':function _0x5281f9(_0x3db446,_0x49d45f,_0x65ebb8,_0x34e6b6,_0x185b54,_0x443d09,_0x24faa9,_0x327a1f){return _0x3db446(_0x49d45f,_0x65ebb8,_0x34e6b6,_0x185b54,_0x443d09,_0x24faa9,_0x327a1f);},'\x58\x74\x67':function _0x36130f(_0x948a5d,_0xceac53){return _0x948a5d+_0xceac53;},'\x46\x62\x65':function _0x3b69e6(_0xd466e6,_0x3edcc8,_0x140231){return _0xd466e6(_0x3edcc8,_0x140231);},'\x66\x57\x4c':function _0x11f963(_0x3417ce,_0x35eefc,_0x241b21,_0x51f70c,_0xf31fba,_0x53662d,_0x1f5e2e,_0x407285){return _0x3417ce(_0x35eefc,_0x241b21,_0x51f70c,_0xf31fba,_0x53662d,_0x1f5e2e,_0x407285);},'\x67\x54\x5a':function _0x367670(_0x5df54f,_0x3d40b6){return _0x5df54f+_0x3d40b6;},'\x72\x66\x46':function _0x31c523(_0x5e4662,_0x34d857,_0x276e3e,_0xee491,_0x2327a3,_0x593f3b,_0x2306ad,_0x5b517e){return _0x5e4662(_0x34d857,_0x276e3e,_0xee491,_0x2327a3,_0x593f3b,_0x2306ad,_0x5b517e);},'\x4b\x67\x44':function _0x4630b4(_0x20ffed,_0x8e89f1){return _0x20ffed+_0x8e89f1;},'\x46\x7a\x4d':function _0x229d61(_0x45f0fc,_0x119ee7){return _0x45f0fc+_0x119ee7;},'\x78\x53\x42':function _0xd4e3a(_0x9fabff,_0x2fc0c4,_0xf22049,_0x2473e2,_0x599e6f,_0x52e018,_0x447db8,_0x12cd07){return _0x9fabff(_0x2fc0c4,_0xf22049,_0x2473e2,_0x599e6f,_0x52e018,_0x447db8,_0x12cd07);},'\x64\x4f\x65':function _0x52b835(_0x3955bb,_0x27db41,_0x158643,_0x3833eb,_0x53f8cd,_0xfb1693,_0x314b77,_0x90c841){return _0x3955bb(_0x27db41,_0x158643,_0x3833eb,_0x53f8cd,_0xfb1693,_0x314b77,_0x90c841);},'\x73\x51\x44':function _0x1c55d5(_0xec7173,_0x431ffd,_0x3f5677,_0x3a841c,_0xebf68d,_0x3975f5,_0x5e1786,_0x1475d8){return _0xec7173(_0x431ffd,_0x3f5677,_0x3a841c,_0xebf68d,_0x3975f5,_0x5e1786,_0x1475d8);},'\x47\x44\x57':function _0x9e177f(_0xa96ecc,_0x2e6f7b,_0x49d840){return _0xa96ecc(_0x2e6f7b,_0x49d840);},'\x48\x7a\x41':function _0x46b813(_0x2ca5e0,_0x2844e1){return _0x2ca5e0+_0x2844e1;},'\x76\x76\x4c':function _0x592267(_0x30d4d9,_0x3479d2){return _0x30d4d9+_0x3479d2;},'\x78\x6d\x4f':function _0x140794(_0xb6f660,_0x372e4a){return _0xb6f660+_0x372e4a;},'\x43\x57\x47':function _0x1c607c(_0x3bb5cd,_0x2e7780,_0x49df10,_0x5e3bcd,_0x56d6cf,_0x16a8cb,_0x2357c3,_0x228277){return _0x3bb5cd(_0x2e7780,_0x49df10,_0x5e3bcd,_0x56d6cf,_0x16a8cb,_0x2357c3,_0x228277);},'\x68\x64\x43':function _0x5f0579(_0x55312e,_0x4745d6,_0x7fc958,_0x56ce98,_0x42c7ef,_0x18d141,_0x5b8645,_0x3a62cd){return _0x55312e(_0x4745d6,_0x7fc958,_0x56ce98,_0x42c7ef,_0x18d141,_0x5b8645,_0x3a62cd);},'\x43\x54\x49':function _0x3c6cf8(_0x4004dd,_0x388762,_0x39ca74,_0x47af07,_0x46a35b,_0x20f1d4,_0x1101ab,_0x5d857c){return _0x4004dd(_0x388762,_0x39ca74,_0x47af07,_0x46a35b,_0x20f1d4,_0x1101ab,_0x5d857c);},'\x74\x4e\x43':function _0x4f83e2(_0x4252c8,_0x1123b1,_0x4c7534,_0x20f002,_0x2d61c8,_0x558879,_0x41174f,_0x37d960){return _0x4252c8(_0x1123b1,_0x4c7534,_0x20f002,_0x2d61c8,_0x558879,_0x41174f,_0x37d960);},'\x68\x76\x4a':function _0x26d755(_0x3dee46,_0x4e2c98){return _0x3dee46+_0x4e2c98;},'\x4e\x43\x54':function _0x1e9706(_0x3da555,_0x2db9e6,_0x5f1d68,_0x7205ac,_0x3c83da,_0x1c5b1a,_0x143241,_0x239515){return _0x3da555(_0x2db9e6,_0x5f1d68,_0x7205ac,_0x3c83da,_0x1c5b1a,_0x143241,_0x239515);},'\x67\x47\x42':function _0x11dce4(_0x56a958,_0x1c0909){return _0x56a958+_0x1c0909;},'\x67\x46\x79':function _0x42a586(_0x484d38,_0x4b246d){return _0x484d38(_0x4b246d);},'\x71\x51\x69':function _0x2fdc19(_0x54a356,_0x5c6911){return _0x54a356(_0x5c6911);}};function _0x32488b(_0x1e30b8,_0x294e6b){return _0x39585e[_0x2162('0x2a')](_0x39585e['\x51\x6d\x70'](_0x1e30b8,_0x294e6b),_0x1e30b8>>>_0x39585e[_0x2162('0x2b')](0x20,_0x294e6b));}function _0x4cffd5(_0x3415cd,_0x13ba8b){var _0x159899={'\x79\x47\x78':function _0x4ee41d(_0x2fe26f,_0xcc09e3){return _0x2fe26f&_0xcc09e3;},'\x49\x51\x6f':function _0x567de2(_0x26f20c,_0x2fcebb){return _0x26f20c^_0x2fcebb;},'\x58\x6d\x4f':function _0x12dbaf(_0x4dc231,_0x10629){return _0x4dc231&_0x10629;},'\x59\x58\x54':function _0x2345ca(_0x36408e,_0x1687c5){return _0x36408e&_0x1687c5;},'\x76\x6c\x6a':function _0x4316bc(_0x3ca39f,_0x2e484d){return _0x3ca39f|_0x2e484d;},'\x42\x63\x45':function _0xccccb1(_0x4cd6e5,_0x3f10f0){return _0x4cd6e5^_0x3f10f0;},'\x6a\x57\x67':function _0x3b1596(_0x329a69,_0x25ebea){return _0x329a69^_0x25ebea;},'\x63\x72\x64':function _0x5ab437(_0x2cb7de,_0x301946){return _0x2cb7de&_0x301946;},'\x72\x69\x59':function _0xd3ebea(_0x4c54c2,_0x1b0a88){return _0x4c54c2&_0x1b0a88;}};var _0x1a1d51=_0x2162('0x2c')[_0x2162('0x2')]('\x7c'),_0x8e2a67=0x0;while(!![]){switch(_0x1a1d51[_0x8e2a67++]){case'\x30':_0x7a91a2=_0x3415cd&0x40000000;continue;case'\x31':if(_0x159899[_0x2162('0x2d')](_0x7a91a2,_0x33c6bc)){return _0x159899['\x49\x51\x6f'](_0x159899['\x49\x51\x6f'](_0x5310c7,0x80000000),_0x1eb40a)^_0x420218;}continue;case'\x32':_0x33c6bc=_0x159899[_0x2162('0x2e')](_0x13ba8b,0x40000000);continue;case'\x33':_0x1eb40a=_0x159899[_0x2162('0x2f')](_0x3415cd,0x80000000);continue;case'\x34':if(_0x159899[_0x2162('0x30')](_0x7a91a2,_0x33c6bc)){if(_0x159899[_0x2162('0x2f')](_0x5310c7,0x40000000)){return _0x159899[_0x2162('0x31')](_0x159899[_0x2162('0x31')](_0x159899[_0x2162('0x31')](_0x5310c7,0xc0000000),_0x1eb40a),_0x420218);}else{return _0x159899[_0x2162('0x32')](_0x159899[_0x2162('0x33')](_0x5310c7,0x40000000)^_0x1eb40a,_0x420218);}}else{return _0x5310c7^_0x1eb40a^_0x420218;}continue;case'\x35':_0x420218=_0x159899[_0x2162('0x34')](_0x13ba8b,0x80000000);continue;case'\x36':var _0x7a91a2,_0x33c6bc,_0x1eb40a,_0x420218,_0x5310c7;continue;case'\x37':_0x5310c7=(_0x3415cd&0x3fffffff)+_0x159899[_0x2162('0x35')](_0x13ba8b,0x3fffffff);continue;}break;}}function _0x1af79b(_0x3d2c9e,_0x59521d,_0x2ff336){return _0x39585e[_0x2162('0x36')](_0x3d2c9e&_0x59521d,_0x39585e[_0x2162('0x37')](~_0x3d2c9e,_0x2ff336));}function _0x39e2a8(_0x599f3d,_0x29a982,_0x2615a8){return _0x39585e[_0x2162('0x38')](_0x39585e[_0x2162('0x37')](_0x599f3d,_0x2615a8),_0x29a982&~_0x2615a8);}function _0x9b773d(_0x506fb2,_0x2f5de5,_0x157a19){return _0x39585e[_0x2162('0x39')](_0x39585e['\x52\x45\x66'](_0x506fb2,_0x2f5de5),_0x157a19);}function _0x1dd90b(_0x4b81a7,_0x3f0bd4,_0x39ed2a){return _0x3f0bd4^_0x39585e['\x65\x52\x7a'](_0x4b81a7,~_0x39ed2a);}function _0x5eed08(_0x1494d1,_0x2cc45c,_0x1bc54f,_0x5e7641,_0x11f7b8,_0x28150d,_0x1d55de){_0x1494d1=_0x39585e[_0x2162('0x3a')](_0x4cffd5,_0x1494d1,_0x39585e['\x50\x50\x53'](_0x4cffd5,_0x39585e['\x50\x50\x53'](_0x4cffd5,_0x39585e[_0x2162('0x3b')](_0x1af79b,_0x2cc45c,_0x1bc54f,_0x5e7641),_0x11f7b8),_0x1d55de));return _0x4cffd5(_0x39585e['\x50\x50\x53'](_0x32488b,_0x1494d1,_0x28150d),_0x2cc45c);};function _0x157b03(_0x906f0c,_0x5416a5,_0x285e8c,_0x20b259,_0xe50f7,_0x3ac4d6,_0x3ee743){_0x906f0c=_0x4cffd5(_0x906f0c,_0x39585e['\x67\x41\x6a'](_0x4cffd5,_0x4cffd5(_0x39585e[_0x2162('0x3c')](_0x39e2a8,_0x5416a5,_0x285e8c,_0x20b259),_0xe50f7),_0x3ee743));return _0x39585e[_0x2162('0x3d')](_0x4cffd5,_0x39585e['\x6d\x44\x72'](_0x32488b,_0x906f0c,_0x3ac4d6),_0x5416a5);};function _0x4d91fa(_0x106399,_0x2f1bdd,_0x5e61cc,_0x4cdebc,_0x22c2ba,_0x274888,_0x3317d7){_0x106399=_0x39585e[_0x2162('0x3e')](_0x4cffd5,_0x106399,_0x39585e[_0x2162('0x3e')](_0x4cffd5,_0x39585e['\x44\x47\x6c'](_0x4cffd5,_0x39585e[_0x2162('0x3c')](_0x9b773d,_0x2f1bdd,_0x5e61cc,_0x4cdebc),_0x22c2ba),_0x3317d7));return _0x4cffd5(_0x39585e[_0x2162('0x3f')](_0x32488b,_0x106399,_0x274888),_0x2f1bdd);};function _0x1de6b1(_0x43710e,_0x172473,_0x4fcb35,_0x1b1301,_0x114b25,_0x4bd788,_0x19e490){_0x43710e=_0x39585e[_0x2162('0x40')](_0x4cffd5,_0x43710e,_0x39585e[_0x2162('0x40')](_0x4cffd5,_0x39585e[_0x2162('0x40')](_0x4cffd5,_0x39585e[_0x2162('0x41')](_0x1dd90b,_0x172473,_0x4fcb35,_0x1b1301),_0x114b25),_0x19e490));return _0x39585e[_0x2162('0x42')](_0x4cffd5,_0x39585e[_0x2162('0x42')](_0x32488b,_0x43710e,_0x4bd788),_0x172473);};function _0x47045b(_0x4d3433){var _0x4e3ae6={'\x73\x55\x63':function _0x1fcebf(_0x43ec6b,_0x10d19d){return _0x43ec6b+_0x10d19d;},'\x4e\x4f\x6a':function _0x46fe09(_0x3403a6,_0xaf0d3a){return _0x3403a6<_0xaf0d3a;},'\x4c\x63\x64':function _0x5e2829(_0x497de4,_0xb917d3){return _0x497de4/_0xb917d3;},'\x6c\x53\x77':function _0x5a684e(_0x1b9e74,_0x586e23){return _0x1b9e74%_0x586e23;},'\x73\x78\x42':function _0x3b5cbb(_0x356aca,_0x111487){return _0x356aca*_0x111487;},'\x47\x70\x72':function _0x107dfe(_0x4a3844,_0x2ff7df){return _0x4a3844|_0x2ff7df;},'\x57\x6c\x76':function _0x4d2e4f(_0x4c651e,_0x1d953c){return _0x4c651e%_0x1d953c;},'\x62\x4e\x48':function _0x6047c7(_0x25b460,_0x1dc527){return _0x25b460-_0x1dc527;},'\x5a\x4c\x76':function _0x5c2df2(_0x783a62,_0x4485db){return _0x783a62/_0x4485db;},'\x4a\x54\x52':function _0x12db18(_0x133224,_0x2ea502){return _0x133224-_0x2ea502;},'\x74\x72\x65':function _0x5a356d(_0x1ac180,_0xfb982e){return _0x1ac180<<_0xfb982e;},'\x54\x6f\x62':function _0x3496db(_0x3b0092,_0xefdf1e){return _0x3b0092-_0xefdf1e;}};var _0x95c0ba='\x31\x32\x7c\x32\x7c\x37\x7c\x34\x7c\x31\x7c\x30\x7c\x36\x7c\x38\x7c\x33\x7c\x31\x30\x7c\x39\x7c\x31\x31\x7c\x35\x7c\x31\x34\x7c\x31\x33'[_0x2162('0x2')]('\x7c'),_0xd571ad=0x0;while(!![]){switch(_0x95c0ba[_0xd571ad++]){case'\x30':var _0x547f70=Array(_0x4ee357-0x1);continue;case'\x31':var _0x4ee357=_0x4e3ae6['\x73\x55\x63'](_0x3e79e6,0x1)*0x10;continue;case'\x32':var _0x387558=_0x4d3433[_0x2162('0x9')];continue;case'\x33':while(_0x4e3ae6[_0x2162('0x43')](_0x1cea00,_0x387558)){_0x4c67cc=_0x4e3ae6[_0x2162('0x44')](_0x1cea00-_0x4e3ae6['\x6c\x53\x77'](_0x1cea00,0x4),0x4);_0x7003c6=_0x4e3ae6[_0x2162('0x45')](_0x4e3ae6[_0x2162('0x46')](_0x1cea00,0x4),0x8);_0x547f70[_0x4c67cc]=_0x4e3ae6[_0x2162('0x47')](_0x547f70[_0x4c67cc],_0x4d3433['\x63\x68\x61\x72\x43\x6f\x64\x65\x41\x74'](_0x1cea00)<<_0x7003c6);_0x1cea00++;}continue;case'\x34':var _0x3e79e6=(_0x25de97-_0x4e3ae6[_0x2162('0x48')](_0x25de97,0x40))/0x40;continue;case'\x35':_0x547f70[_0x4e3ae6['\x62\x4e\x48'](_0x4ee357,0x2)]=_0x387558<<0x3;continue;case'\x36':var _0x7003c6=0x0;continue;case'\x37':var _0x25de97=_0x4e3ae6[_0x2162('0x49')](_0x387558,0x8);continue;case'\x38':var _0x1cea00=0x0;continue;case'\x39':_0x7003c6=_0x1cea00%0x4*0x8;continue;case'\x31\x30':_0x4c67cc=_0x4e3ae6[_0x2162('0x4a')](_0x4e3ae6['\x4a\x54\x52'](_0x1cea00,_0x1cea00%0x4),0x4);continue;case'\x31\x31':_0x547f70[_0x4c67cc]=_0x4e3ae6[_0x2162('0x47')](_0x547f70[_0x4c67cc],_0x4e3ae6[_0x2162('0x4b')](0x80,_0x7003c6));continue;case'\x31\x32':var _0x4c67cc;continue;case'\x31\x33':return _0x547f70;continue;case'\x31\x34':_0x547f70[_0x4e3ae6[_0x2162('0x4c')](_0x4ee357,0x1)]=_0x387558>>>0x1d;continue;}break;}};function _0x31c213(_0x3b3a62){var _0x54a7fe='',_0x5c4929='',_0x389ae2,_0x18a778;for(_0x18a778=0x0;_0x39585e['\x43\x6e\x7a'](_0x18a778,0x3);_0x18a778++){_0x389ae2=_0x39585e[_0x2162('0x4d')](_0x39585e[_0x2162('0x4e')](_0x3b3a62,_0x39585e[_0x2162('0x4f')](_0x18a778,0x8)),0xff);_0x5c4929=_0x39585e[_0x2162('0x50')]('\x30',_0x389ae2['\x74\x6f\x53\x74\x72\x69\x6e\x67'](0x10));_0x54a7fe=_0x39585e[_0x2162('0x51')](_0x54a7fe,_0x5c4929['\x73\x75\x62\x73\x74\x72'](_0x39585e[_0x2162('0x2b')](_0x5c4929[_0x2162('0x9')],0x2),0x2));}return _0x54a7fe;};function _0x491c70(_0x407490){_0x407490=_0x407490[_0x2162('0x16')](/\r\n/g,'\x0a');var _0xf3ee67='';for(var _0x49d5d7=0x0;_0x39585e[_0x2162('0x52')](_0x49d5d7,_0x407490[_0x2162('0x9')]);_0x49d5d7++){var _0x25e9d8=_0x407490[_0x2162('0xa')](_0x49d5d7);if(_0x25e9d8<0x80){_0xf3ee67+=String[_0x2162('0x53')](_0x25e9d8);}else if(_0x39585e[_0x2162('0x54')](_0x25e9d8,0x7f)&&_0x39585e[_0x2162('0x55')](_0x25e9d8,0x800)){_0xf3ee67+=String[_0x2162('0x53')](_0x39585e[_0x2162('0x56')](_0x39585e[_0x2162('0x57')](_0x25e9d8,0x6),0xc0));_0xf3ee67+=String[_0x2162('0x53')](_0x25e9d8&0x3f|0x80);}else{_0xf3ee67+=String[_0x2162('0x53')](_0x39585e['\x54\x68\x55'](_0x25e9d8,0xc)|0xe0);_0xf3ee67+=String[_0x2162('0x53')](_0x39585e[_0x2162('0x56')](_0x25e9d8>>0x6&0x3f,0x80));_0xf3ee67+=String[_0x2162('0x53')](_0x39585e[_0x2162('0x58')](_0x39585e[_0x2162('0x59')](_0x25e9d8,0x3f),0x80));}}return _0xf3ee67;};var _0x428ef6=_0x39585e[_0x2162('0x5a')](Array);var _0x58f7fb,_0x136e1e,_0x4ed2f2,_0x52f526,_0x517f66,_0x2a2080,_0x20b943,_0x104a32,_0x16ebe1;var _0x96d311=0x7,_0x23e345=0xc,_0x4ff5da=0x11,_0x5a0675=0x16;var _0x263bee=0x5,_0x57d8d1=0x9,_0xbcb233=0xe,_0x3d1daa=0x14;var _0x4e67e7=0x4,_0x277770=0xb,_0x5993f7=0x10,_0x225cbb=0x17;var _0x476c02=0x6,_0x30a0e4=0xa,_0x248ff1=0xf,_0x1f759a=0x15;_0x444236=_0x39585e[_0x2162('0x5b')](_0x491c70,_0x444236);_0x428ef6=_0x39585e[_0x2162('0x5c')](_0x47045b,_0x444236);_0x2a2080=0x67452301;_0x20b943=0xefcdab89;_0x104a32=0x98badcfe;_0x16ebe1=0x10325476;for(_0x58f7fb=0x0;_0x39585e[_0x2162('0x55')](_0x58f7fb,_0x428ef6[_0x2162('0x9')]);_0x58f7fb+=0x10){var _0x54ef8d=_0x2162('0x5d')[_0x2162('0x2')]('\x7c'),_0xec5511=0x0;while(!![]){switch(_0x54ef8d[_0xec5511++]){case'\x30':_0x16ebe1=_0x4d91fa(_0x16ebe1,_0x2a2080,_0x20b943,_0x104a32,_0x428ef6[_0x39585e[_0x2162('0x51')](_0x58f7fb,0x8)],_0x277770,0x8771f681);continue;case'\x31':_0x2a2080=_0x1de6b1(_0x2a2080,_0x20b943,_0x104a32,_0x16ebe1,_0x428ef6[_0x39585e[_0x2162('0x5e')](_0x58f7fb,0x8)],_0x476c02,0x6fa87e4f);continue;case'\x32':_0x104a32=_0x39585e[_0x2162('0x5f')](_0x5eed08,_0x104a32,_0x16ebe1,_0x2a2080,_0x20b943,_0x428ef6[_0x39585e[_0x2162('0x60')](_0x58f7fb,0x2)],_0x4ff5da,0x242070db);continue;case'\x33':_0x2a2080=_0x4d91fa(_0x2a2080,_0x20b943,_0x104a32,_0x16ebe1,_0x428ef6[_0x58f7fb+0x1],_0x4e67e7,0xa4beea44);continue;case'\x34':_0x136e1e=_0x2a2080;continue;case'\x35':_0x104a32=_0x39585e[_0x2162('0x61')](_0x157b03,_0x104a32,_0x16ebe1,_0x2a2080,_0x20b943,_0x428ef6[_0x39585e['\x4d\x58\x4f'](_0x58f7fb,0xf)],_0xbcb233,0xd8a1e681);continue;case'\x36':_0x104a32=_0x1de6b1(_0x104a32,_0x16ebe1,_0x2a2080,_0x20b943,_0x428ef6[_0x39585e['\x41\x52\x74'](_0x58f7fb,0x6)],_0x248ff1,0xa3014314);continue;case'\x37':_0x2a2080=_0x39585e[_0x2162('0x61')](_0x1de6b1,_0x2a2080,_0x20b943,_0x104a32,_0x16ebe1,_0x428ef6[_0x39585e['\x41\x52\x74'](_0x58f7fb,0x0)],_0x476c02,0xf4292244);continue;case'\x38':_0x2a2080=_0x39585e[_0x2162('0x62')](_0x5eed08,_0x2a2080,_0x20b943,_0x104a32,_0x16ebe1,_0x428ef6[_0x39585e[_0x2162('0x63')](_0x58f7fb,0x0)],_0x96d311,0xd76aa478);continue;case'\x39':_0x104a32=_0x157b03(_0x104a32,_0x16ebe1,_0x2a2080,_0x20b943,_0x428ef6[_0x58f7fb+0x3],_0xbcb233,0xf4d50d87);continue;case'\x31\x30':_0x104a32=_0x39585e[_0x2162('0x64')](_0x4d91fa,_0x104a32,_0x16ebe1,_0x2a2080,_0x20b943,_0x428ef6[_0x58f7fb+0x7],_0x5993f7,0xf6bb4b60);continue;case'\x31\x31':_0x104a32=_0x39585e['\x78\x75\x69'](_0x4d91fa,_0x104a32,_0x16ebe1,_0x2a2080,_0x20b943,_0x428ef6[_0x39585e['\x41\x52\x74'](_0x58f7fb,0x3)],_0x5993f7,0xd4ef3085);continue;case'\x31\x32':_0x2a2080=_0x39585e[_0x2162('0x65')](_0x1de6b1,_0x2a2080,_0x20b943,_0x104a32,_0x16ebe1,_0x428ef6[_0x39585e[_0x2162('0x66')](_0x58f7fb,0xc)],_0x476c02,0x655b59c3);continue;case'\x31\x33':_0x20b943=_0x39585e['\x51\x6e\x66'](_0x4cffd5,_0x20b943,_0x4ed2f2);continue;case'\x31\x34':_0x20b943=_0x157b03(_0x20b943,_0x104a32,_0x16ebe1,_0x2a2080,_0x428ef6[_0x39585e[_0x2162('0x67')](_0x58f7fb,0x4)],_0x3d1daa,0xe7d3fbc8);continue;case'\x31\x35':_0x2a2080=_0x39585e[_0x2162('0x68')](_0x5eed08,_0x2a2080,_0x20b943,_0x104a32,_0x16ebe1,_0x428ef6[_0x39585e[_0x2162('0x67')](_0x58f7fb,0x8)],_0x96d311,0x698098d8);continue;case'\x31\x36':_0x20b943=_0x39585e[_0x2162('0x69')](_0x1de6b1,_0x20b943,_0x104a32,_0x16ebe1,_0x2a2080,_0x428ef6[_0x39585e[_0x2162('0x67')](_0x58f7fb,0xd)],_0x1f759a,0x4e0811a1);continue;case'\x31\x37':_0x20b943=_0x39585e['\x51\x46\x4c'](_0x4d91fa,_0x20b943,_0x104a32,_0x16ebe1,_0x2a2080,_0x428ef6[_0x58f7fb+0xe],_0x225cbb,0xfde5380c);continue;case'\x31\x38':_0x20b943=_0x39585e['\x51\x46\x4c'](_0x4d91fa,_0x20b943,_0x104a32,_0x16ebe1,_0x2a2080,_0x428ef6[_0x39585e[_0x2162('0x6a')](_0x58f7fb,0x2)],_0x225cbb,0xc4ac5665);continue;case'\x31\x39':_0x104a32=_0x39585e['\x51\x46\x4c'](_0x4d91fa,_0x104a32,_0x16ebe1,_0x2a2080,_0x20b943,_0x428ef6[_0x39585e[_0x2162('0x6b')](_0x58f7fb,0xb)],_0x5993f7,0x6d9d6122);continue;case'\x32\x30':_0x16ebe1=_0x39585e[_0x2162('0x6c')](_0x4d91fa,_0x16ebe1,_0x2a2080,_0x20b943,_0x104a32,_0x428ef6[_0x39585e[_0x2162('0x6d')](_0x58f7fb,0x0)],_0x277770,0xeaa127fa);continue;case'\x32\x31':_0x2a2080=_0x39585e[_0x2162('0x6e')](_0x4d91fa,_0x2a2080,_0x20b943,_0x104a32,_0x16ebe1,_0x428ef6[_0x58f7fb+0x9],_0x4e67e7,0xd9d4d039);continue;case'\x32\x32':_0x20b943=_0x39585e[_0x2162('0x6e')](_0x1de6b1,_0x20b943,_0x104a32,_0x16ebe1,_0x2a2080,_0x428ef6[_0x39585e[_0x2162('0x6d')](_0x58f7fb,0x9)],_0x1f759a,0xeb86d391);continue;case'\x32\x33':_0x16ebe1=_0x157b03(_0x16ebe1,_0x2a2080,_0x20b943,_0x104a32,_0x428ef6[_0x39585e[_0x2162('0x6f')](_0x58f7fb,0x6)],_0x57d8d1,0xc040b340);continue;case'\x32\x34':_0x16ebe1=_0x39585e[_0x2162('0x6e')](_0x4d91fa,_0x16ebe1,_0x2a2080,_0x20b943,_0x104a32,_0x428ef6[_0x39585e['\x53\x58\x4d'](_0x58f7fb,0xc)],_0x277770,0xe6db99e5);continue;case'\x32\x35':_0x16ebe1=_0x157b03(_0x16ebe1,_0x2a2080,_0x20b943,_0x104a32,_0x428ef6[_0x58f7fb+0xe],_0x57d8d1,0xc33707d6);continue;case'\x32\x36':_0x104a32=_0x39585e[_0x2162('0x70')](_0x5eed08,_0x104a32,_0x16ebe1,_0x2a2080,_0x20b943,_0x428ef6[_0x39585e[_0x2162('0x71')](_0x58f7fb,0x6)],_0x4ff5da,0xa8304613);continue;case'\x32\x37':_0x104a32=_0x39585e[_0x2162('0x72')](_0x1de6b1,_0x104a32,_0x16ebe1,_0x2a2080,_0x20b943,_0x428ef6[_0x39585e[_0x2162('0x73')](_0x58f7fb,0xa)],_0x248ff1,0xffeff47d);continue;case'\x32\x38':_0x20b943=_0x39585e['\x6d\x78\x79'](_0x157b03,_0x20b943,_0x104a32,_0x16ebe1,_0x2a2080,_0x428ef6[_0x39585e[_0x2162('0x73')](_0x58f7fb,0xc)],_0x3d1daa,0x8d2a4c8a);continue;case'\x32\x39':_0x16ebe1=_0x4cffd5(_0x16ebe1,_0x517f66);continue;case'\x33\x30':_0x2a2080=_0x39585e[_0x2162('0x74')](_0x1de6b1,_0x2a2080,_0x20b943,_0x104a32,_0x16ebe1,_0x428ef6[_0x39585e[_0x2162('0x75')](_0x58f7fb,0x4)],_0x476c02,0xf7537e82);continue;case'\x33\x31':_0x16ebe1=_0x39585e[_0x2162('0x74')](_0x157b03,_0x16ebe1,_0x2a2080,_0x20b943,_0x104a32,_0x428ef6[_0x39585e[_0x2162('0x75')](_0x58f7fb,0x2)],_0x57d8d1,0xfcefa3f8);continue;case'\x33\x32':_0x16ebe1=_0x39585e['\x4e\x6e\x78'](_0x1de6b1,_0x16ebe1,_0x2a2080,_0x20b943,_0x104a32,_0x428ef6[_0x39585e['\x49\x6e\x61'](_0x58f7fb,0x7)],_0x30a0e4,0x432aff97);continue;case'\x33\x33':_0x2a2080=_0x39585e[_0x2162('0x76')](_0x157b03,_0x2a2080,_0x20b943,_0x104a32,_0x16ebe1,_0x428ef6[_0x39585e['\x70\x51\x46'](_0x58f7fb,0x1)],_0x263bee,0xf61e2562);continue;case'\x33\x34':_0x16ebe1=_0x39585e[_0x2162('0x76')](_0x4d91fa,_0x16ebe1,_0x2a2080,_0x20b943,_0x104a32,_0x428ef6[_0x39585e[_0x2162('0x77')](_0x58f7fb,0x4)],_0x277770,0x4bdecfa9);continue;case'\x33\x35':_0x16ebe1=_0x39585e[_0x2162('0x76')](_0x5eed08,_0x16ebe1,_0x2a2080,_0x20b943,_0x104a32,_0x428ef6[_0x39585e[_0x2162('0x77')](_0x58f7fb,0x9)],_0x23e345,0x8b44f7af);continue;case'\x33\x36':_0x2a2080=_0x39585e[_0x2162('0x78')](_0x157b03,_0x2a2080,_0x20b943,_0x104a32,_0x16ebe1,_0x428ef6[_0x39585e[_0x2162('0x79')](_0x58f7fb,0x9)],_0x263bee,0x21e1cde6);continue;case'\x33\x37':_0x2a2080=_0x5eed08(_0x2a2080,_0x20b943,_0x104a32,_0x16ebe1,_0x428ef6[_0x39585e[_0x2162('0x79')](_0x58f7fb,0x4)],_0x96d311,0xf57c0faf);continue;case'\x33\x38':_0x20b943=_0x157b03(_0x20b943,_0x104a32,_0x16ebe1,_0x2a2080,_0x428ef6[_0x58f7fb+0x8],_0x3d1daa,0x455a14ed);continue;case'\x33\x39':_0x104a32=_0x39585e[_0x2162('0x78')](_0x1de6b1,_0x104a32,_0x16ebe1,_0x2a2080,_0x20b943,_0x428ef6[_0x58f7fb+0xe],_0x248ff1,0xab9423a7);continue;case'\x34\x30':_0x20b943=_0x39585e[_0x2162('0x78')](_0x157b03,_0x20b943,_0x104a32,_0x16ebe1,_0x2a2080,_0x428ef6[_0x39585e[_0x2162('0x79')](_0x58f7fb,0x0)],_0x3d1daa,0xe9b6c7aa);continue;case'\x34\x31':_0x104a32=_0x39585e[_0x2162('0x7a')](_0x4cffd5,_0x104a32,_0x52f526);continue;case'\x34\x32':_0x2a2080=_0x39585e[_0x2162('0x7b')](_0x157b03,_0x2a2080,_0x20b943,_0x104a32,_0x16ebe1,_0x428ef6[_0x39585e['\x67\x54\x5a'](_0x58f7fb,0xd)],_0x263bee,0xa9e3e905);continue;case'\x34\x33':_0x20b943=_0x39585e[_0x2162('0x7c')](_0x1de6b1,_0x20b943,_0x104a32,_0x16ebe1,_0x2a2080,_0x428ef6[_0x39585e[_0x2162('0x7d')](_0x58f7fb,0x1)],_0x1f759a,0x85845dd1);continue;case'\x34\x34':_0x2a2080=_0x39585e[_0x2162('0x7c')](_0x5eed08,_0x2a2080,_0x20b943,_0x104a32,_0x16ebe1,_0x428ef6[_0x39585e[_0x2162('0x7d')](_0x58f7fb,0xc)],_0x96d311,0x6b901122);continue;case'\x34\x35':_0x2a2080=_0x4d91fa(_0x2a2080,_0x20b943,_0x104a32,_0x16ebe1,_0x428ef6[_0x39585e[_0x2162('0x7e')](_0x58f7fb,0xd)],_0x4e67e7,0x289b7ec6);continue;case'\x34\x36':_0x104a32=_0x39585e[_0x2162('0x7f')](_0x1de6b1,_0x104a32,_0x16ebe1,_0x2a2080,_0x20b943,_0x428ef6[_0x39585e[_0x2162('0x7e')](_0x58f7fb,0x2)],_0x248ff1,0x2ad7d2bb);continue;case'\x34\x37':_0x16ebe1=_0x5eed08(_0x16ebe1,_0x2a2080,_0x20b943,_0x104a32,_0x428ef6[_0x58f7fb+0x1],_0x23e345,0xe8c7b756);continue;case'\x34\x38':_0x16ebe1=_0x157b03(_0x16ebe1,_0x2a2080,_0x20b943,_0x104a32,_0x428ef6[_0x39585e['\x46\x7a\x4d'](_0x58f7fb,0xa)],_0x57d8d1,0x2441453);continue;case'\x34\x39':_0x104a32=_0x39585e[_0x2162('0x7f')](_0x5eed08,_0x104a32,_0x16ebe1,_0x2a2080,_0x20b943,_0x428ef6[_0x58f7fb+0xa],_0x4ff5da,0xffff5bb1);continue;case'\x35\x30':_0x16ebe1=_0x39585e[_0x2162('0x7f')](_0x1de6b1,_0x16ebe1,_0x2a2080,_0x20b943,_0x104a32,_0x428ef6[_0x39585e[_0x2162('0x7e')](_0x58f7fb,0x3)],_0x30a0e4,0x8f0ccc92);continue;case'\x35\x31':_0x4ed2f2=_0x20b943;continue;case'\x35\x32':_0x20b943=_0x39585e[_0x2162('0x7f')](_0x1de6b1,_0x20b943,_0x104a32,_0x16ebe1,_0x2a2080,_0x428ef6[_0x39585e[_0x2162('0x7e')](_0x58f7fb,0x5)],_0x1f759a,0xfc93a039);continue;case'\x35\x33':_0x16ebe1=_0x39585e[_0x2162('0x80')](_0x1de6b1,_0x16ebe1,_0x2a2080,_0x20b943,_0x104a32,_0x428ef6[_0x39585e[_0x2162('0x7e')](_0x58f7fb,0xf)],_0x30a0e4,0xfe2ce6e0);continue;case'\x35\x34':_0x52f526=_0x104a32;continue;case'\x35\x35':_0x104a32=_0x39585e['\x73\x51\x44'](_0x5eed08,_0x104a32,_0x16ebe1,_0x2a2080,_0x20b943,_0x428ef6[_0x39585e[_0x2162('0x7e')](_0x58f7fb,0xe)],_0x4ff5da,0xa679438e);continue;case'\x35\x36':_0x2a2080=_0x39585e[_0x2162('0x81')](_0x4cffd5,_0x2a2080,_0x136e1e);continue;case'\x35\x37':_0x20b943=_0x39585e[_0x2162('0x82')](_0x5eed08,_0x20b943,_0x104a32,_0x16ebe1,_0x2a2080,_0x428ef6[_0x39585e[_0x2162('0x83')](_0x58f7fb,0x3)],_0x5a0675,0xc1bdceee);continue;case'\x35\x38':_0x104a32=_0x39585e[_0x2162('0x82')](_0x157b03,_0x104a32,_0x16ebe1,_0x2a2080,_0x20b943,_0x428ef6[_0x39585e[_0x2162('0x84')](_0x58f7fb,0xb)],_0xbcb233,0x265e5a51);continue;case'\x35\x39':_0x16ebe1=_0x39585e[_0x2162('0x82')](_0x1de6b1,_0x16ebe1,_0x2a2080,_0x20b943,_0x104a32,_0x428ef6[_0x39585e[_0x2162('0x85')](_0x58f7fb,0xb)],_0x30a0e4,0xbd3af235);continue;case'\x36\x30':_0x16ebe1=_0x5eed08(_0x16ebe1,_0x2a2080,_0x20b943,_0x104a32,_0x428ef6[_0x58f7fb+0x5],_0x23e345,0x4787c62a);continue;case'\x36\x31':_0x517f66=_0x16ebe1;continue;case'\x36\x32':_0x20b943=_0x39585e[_0x2162('0x82')](_0x4d91fa,_0x20b943,_0x104a32,_0x16ebe1,_0x2a2080,_0x428ef6[_0x39585e[_0x2162('0x85')](_0x58f7fb,0x6)],_0x225cbb,0x4881d05);continue;case'\x36\x33':_0x20b943=_0x39585e[_0x2162('0x86')](_0x4d91fa,_0x20b943,_0x104a32,_0x16ebe1,_0x2a2080,_0x428ef6[_0x58f7fb+0xa],_0x225cbb,0xbebfbc70);continue;case'\x36\x34':_0x2a2080=_0x39585e[_0x2162('0x86')](_0x157b03,_0x2a2080,_0x20b943,_0x104a32,_0x16ebe1,_0x428ef6[_0x39585e[_0x2162('0x85')](_0x58f7fb,0x5)],_0x263bee,0xd62f105d);continue;case'\x36\x35':_0x20b943=_0x39585e[_0x2162('0x86')](_0x5eed08,_0x20b943,_0x104a32,_0x16ebe1,_0x2a2080,_0x428ef6[_0x39585e[_0x2162('0x85')](_0x58f7fb,0x7)],_0x5a0675,0xfd469501);continue;case'\x36\x36':_0x2a2080=_0x39585e['\x43\x57\x47'](_0x4d91fa,_0x2a2080,_0x20b943,_0x104a32,_0x16ebe1,_0x428ef6[_0x58f7fb+0x5],_0x4e67e7,0xfffa3942);continue;case'\x36\x37':_0x104a32=_0x39585e[_0x2162('0x86')](_0x4d91fa,_0x104a32,_0x16ebe1,_0x2a2080,_0x20b943,_0x428ef6[_0x39585e['\x78\x6d\x4f'](_0x58f7fb,0xf)],_0x5993f7,0x1fa27cf8);continue;case'\x36\x38':_0x20b943=_0x39585e['\x68\x64\x43'](_0x5eed08,_0x20b943,_0x104a32,_0x16ebe1,_0x2a2080,_0x428ef6[_0x39585e[_0x2162('0x85')](_0x58f7fb,0xf)],_0x5a0675,0x49b40821);continue;case'\x36\x39':_0x16ebe1=_0x39585e[_0x2162('0x87')](_0x5eed08,_0x16ebe1,_0x2a2080,_0x20b943,_0x104a32,_0x428ef6[_0x39585e[_0x2162('0x85')](_0x58f7fb,0xd)],_0x23e345,0xfd987193);continue;case'\x37\x30':_0x104a32=_0x39585e[_0x2162('0x88')](_0x157b03,_0x104a32,_0x16ebe1,_0x2a2080,_0x20b943,_0x428ef6[_0x39585e['\x68\x76\x4a'](_0x58f7fb,0x7)],_0xbcb233,0x676f02d9);continue;case'\x37\x31':_0x20b943=_0x39585e[_0x2162('0x89')](_0x5eed08,_0x20b943,_0x104a32,_0x16ebe1,_0x2a2080,_0x428ef6[_0x39585e[_0x2162('0x8a')](_0x58f7fb,0xb)],_0x5a0675,0x895cd7be);continue;}break;}}var _0x4b94ed=_0x39585e[_0x2162('0x8a')](_0x39585e[_0x2162('0x8a')](_0x39585e['\x67\x46\x79'](_0x31c213,_0x2a2080),_0x31c213(_0x20b943))+_0x39585e[_0x2162('0x8b')](_0x31c213,_0x104a32),_0x39585e[_0x2162('0x8b')](_0x31c213,_0x16ebe1));return _0x4b94ed['\x74\x6f\x4c\x6f\x77\x65\x72\x43\x61\x73\x65']();};var ua=navigator[_0x2162('0x8c')];var mu=_0x2162('0x8d');var shift=0x0;var adblock=0x0;function CheckAdblock(){var _0x23ed96={'\x73\x52\x53':function _0x502d6a(_0x2d159d,_0x17161b){return _0x2d159d in _0x17161b;},'\x58\x42\x54':function _0xd04033(_0x20e78a,_0x3d7f10){return _0x20e78a==_0x3d7f10;}};if(!_0x23ed96['\x73\x52\x53']('\x61\x62',window)){window['\x61\x62']=!![];}if(_0x23ed96[_0x2162('0x8e')](window['\x61\x62'],!![])){adblock=0x1;}if(_0x23ed96[_0x2162('0x8e')](adblock,0x1)){$('\x2e\x61\x64\x62')[_0x2162('0x8f')](please_disable_adblock);}}setTimeout(CheckAdblock,0x7d0);$(document)[_0x2162('0x90')](function(){var _0x47cde3={'\x44\x6e\x6f':function _0xaa582f(_0x144815,_0x593a6e){return _0x144815(_0x593a6e);},'\x64\x4a\x44':function _0x576f25(_0x192ecd,_0x27b7be){return _0x192ecd(_0x27b7be);},'\x42\x73\x63':function _0x35c0f5(_0x4824ce,_0x5de701){return _0x4824ce(_0x5de701);},'\x48\x51\x4a':function _0x6d4ccc(_0x2bfa7f,_0x1fd0db){return _0x2bfa7f(_0x1fd0db);},'\x66\x79\x59':function _0x39b5f5(_0x4f4e46,_0x42304b){return _0x4f4e46(_0x42304b);},'\x4b\x67\x56':function _0x5211d0(_0x1fd691,_0x3f5c55){return _0x1fd691!==_0x3f5c55;},'\x66\x55\x6a':function _0x5552df(_0xf4983b,_0x2b759a){return _0xf4983b(_0x2b759a);},'\x64\x76\x50':function _0x237a00(_0x30b4b9,_0x343f75){return _0x30b4b9(_0x343f75);},'\x57\x69\x6f':function _0x5cdd84(_0x4969e4,_0x155c13){return _0x4969e4(_0x155c13);},'\x71\x79\x54':function _0x2c8495(_0x592590){return _0x592590();},'\x4f\x52\x6b':function _0x567baa(_0x37b198){return _0x37b198();},'\x4f\x76\x5a':function _0x39aa51(_0x184c74,_0x2b1c2c,_0x47f751){return _0x184c74(_0x2b1c2c,_0x47f751);},'\x68\x6a\x58':function _0x2ea40b(_0x5ddc65,_0x8cc620,_0x39a186){return _0x5ddc65(_0x8cc620,_0x39a186);},'\x63\x52\x4b':function _0x2fa4e9(_0x26e868){return _0x26e868();},'\x42\x62\x62':function _0x39e53c(_0x4a921e,_0x1b16b8,_0x52fe1c){return _0x4a921e(_0x1b16b8,_0x52fe1c);},'\x62\x58\x6d':function _0x58b47f(_0x3f90c9){return _0x3f90c9();},'\x49\x6a\x54':function _0x550912(_0x2a574c,_0x5d92d8){return _0x2a574c*_0x5d92d8;},'\x4a\x7a\x6b':function _0x1ba584(_0x2cfa7e,_0x3e23b9){return _0x2cfa7e!==_0x3e23b9;},'\x73\x6a\x64':function _0x5d79d3(_0x5b0df7,_0xe5811e){return _0x5b0df7(_0xe5811e);},'\x48\x51\x51':function _0x382171(_0x306cef,_0x597eca){return _0x306cef(_0x597eca);},'\x66\x47\x57':function _0x11361d(_0x20ccc6,_0x526149){return _0x20ccc6(_0x526149);},'\x51\x41\x4a':function _0x43fcc4(_0x549e79){return _0x549e79();},'\x4b\x79\x58':function _0x24a534(_0x339a4e,_0x3334a7){return _0x339a4e(_0x3334a7);},'\x48\x51\x68':function _0x2cd3d1(_0xfb0703,_0xaf3bc9){return _0xfb0703(_0xaf3bc9);},'\x4a\x55\x4f':function _0x51fdd7(_0x17d82f,_0x2ddbbd){return _0x17d82f(_0x2ddbbd);},'\x4e\x61\x56':function _0x183f09(_0x51d3f2,_0x53d996){return _0x51d3f2==_0x53d996;},'\x44\x69\x6a':function _0xffe2d7(_0x50d4d9,_0x402130){return _0x50d4d9-_0x402130;},'\x59\x57\x51':function _0x5bb5b4(_0x43c083,_0x14190b){return _0x43c083/_0x14190b;},'\x76\x65\x6c':function _0x209125(_0x3ea6b7,_0x282e6b){return _0x3ea6b7(_0x282e6b);},'\x4f\x78\x6c':function _0x3d43b6(_0x4e37a9,_0x369f4c){return _0x4e37a9(_0x369f4c);},'\x55\x5a\x43':function _0x8c0698(_0x2690ee,_0x288c15){return _0x2690ee(_0x288c15);},'\x7a\x61\x77':function _0x5292bc(_0x317887,_0x26a0e0,_0x1ce68f){return _0x317887(_0x26a0e0,_0x1ce68f);},'\x55\x51\x4a':function _0x515f8c(_0x2ee815,_0x586b2f){return _0x2ee815(_0x586b2f);},'\x47\x6a\x64':function _0x12b4c1(_0x1e57e1,_0x1365c8){return _0x1e57e1-_0x1365c8;},'\x4e\x52\x6c':function _0x1b306b(_0x1ec918,_0x3fc4bb){return _0x1ec918>_0x3fc4bb;},'\x6c\x48\x54':function _0x4663b8(_0x29dbfe,_0x27c930){return _0x29dbfe-_0x27c930;},'\x46\x58\x61':function _0x5828eb(_0x37d966,_0x2d0551){return _0x37d966<_0x2d0551;},'\x44\x5a\x73':function _0x59b251(_0x3e4067,_0x36a155){return _0x3e4067<_0x36a155;},'\x66\x70\x45':function _0x29fca4(_0x380bc1,_0x4a6dfe){return _0x380bc1+_0x4a6dfe;},'\x47\x64\x62':function _0x48ee5c(_0x20f538,_0x169d77){return _0x20f538/_0x169d77;},'\x4c\x7a\x65':function _0x589ceb(_0x3a4c63,_0x205fad){return _0x3a4c63(_0x205fad);},'\x4c\x4c\x70':function _0x1c6518(_0x3f0ac7,_0x1440f2){return _0x3f0ac7+_0x1440f2;},'\x4c\x63\x43':function _0x37a015(_0x1be640,_0x56c895){return _0x1be640+_0x56c895;},'\x53\x6e\x41':function _0x3b401f(_0x36f993,_0x570172,_0x43fad8){return _0x36f993(_0x570172,_0x43fad8);},'\x75\x66\x49':function _0x580710(_0x490590,_0x45de3b){return _0x490590(_0x45de3b);},'\x55\x4a\x50':function _0x1eb7d0(_0x41c76a){return _0x41c76a();},'\x6a\x7a\x51':function _0x51eb6d(_0xb7acd6,_0x442530,_0x38b5a2){return _0xb7acd6(_0x442530,_0x38b5a2);},'\x47\x6b\x61':function _0x1a3ab1(_0x57d9a6,_0x1a8437){return _0x57d9a6(_0x1a8437);}};var _0x3617f8;var _0x173298;var _0x1f5969;var _0x38090c;var _0x20bde0;var _0x3b88a7;var _0x33c648;var _0x1a4c65;_0x47cde3[_0x2162('0x91')]($,_0x2162('0x92'))['\x63\x6c\x69\x63\x6b'](function(){if(_0x47cde3[_0x2162('0x93')]($,_0x2162('0x94'))['\x69\x73']('\x3a\x68\x69\x64\x64\x65\x6e')){_0x47cde3[_0x2162('0x95')]($,_0x2162('0x94'))[_0x2162('0x96')]();_0x47cde3[_0x2162('0x97')]($,_0x2162('0x98'))[_0x2162('0x99')]();}else{$(_0x2162('0x94'))[_0x2162('0x99')]();}});_0x47cde3[_0x2162('0x91')]($,'\x23\x73\x65\x74\x74\x69\x6e\x67\x73')['\x63\x6c\x69\x63\x6b'](function(){if(_0x47cde3[_0x2162('0x9a')]($,'\x23\x73\x65\x74\x74\x69\x6e\x67\x73\x44\x61\x74\x61')['\x69\x73'](_0x2162('0x9b'))){_0x47cde3[_0x2162('0x9c')]($,_0x2162('0x98'))[_0x2162('0x96')]();_0x47cde3[_0x2162('0x9c')]($,'\x23\x6d\x61\x69\x6e\x44\x61\x74\x61')[_0x2162('0x99')]();}else{_0x47cde3[_0x2162('0x9c')]($,_0x2162('0x98'))['\x73\x6c\x69\x64\x65\x55\x70']();}});_0x47cde3[_0x2162('0x9d')](_0x4b287a);_0x47cde3[_0x2162('0x9e')](setInterval,_0x4b287a,0x493e0);function _0x4b287a(){$[_0x2162('0x9f')]({'\x75\x72\x6c':_0x2162('0xa0'),'\x73\x75\x63\x63\x65\x73\x73':function(_0x47e2d9){var _0x1a19b9={'\x79\x43\x69':function _0x52c88e(_0x13c649,_0x3cd135){return _0x13c649(_0x3cd135);},'\x7a\x79\x76':function _0x1486e1(_0x4cb2b3,_0x7945b2){return _0x4cb2b3(_0x7945b2);},'\x44\x4e\x68':function _0x5a4284(_0x1a6a50,_0x5b7e33){return _0x1a6a50/_0x5b7e33;}};var _0x437865=_0x2162('0xa1')[_0x2162('0x2')]('\x7c'),_0x293f62=0x0;while(!![]){switch(_0x437865[_0x293f62++]){case'\x30':console['\x6c\x6f\x67'](_0x2162('0xa2'));continue;case'\x31':_0x1a19b9[_0x2162('0xa3')]($,'\x2e\x6f\x6e\x6c\x69\x6e\x65')[_0x2162('0xa4')](_0x47e2d9[_0x2162('0xa5')]);continue;case'\x32':_0x1a19b9[_0x2162('0xa6')]($,_0x2162('0xa7'))[_0x2162('0xa4')](_0x47e2d9['\x77\x61\x74\x63\x68\x65\x64']);continue;case'\x33':$(_0x2162('0xa8'))[_0x2162('0xa4')](_0x47e2d9['\x69\x64']);continue;case'\x34':$(_0x2162('0xa9'))[_0x2162('0xa4')](_0x47e2d9[_0x2162('0xaa')]);continue;case'\x35':_0x1a19b9['\x7a\x79\x76']($,_0x2162('0xab'))[_0x2162('0xa4')](_0x47e2d9[_0x2162('0xac')]);continue;case'\x36':shift=_0x1a19b9[_0x2162('0xa6')](parseInt,_0x47e2d9[_0x2162('0xad')])-Math[_0x2162('0xae')](_0x1a19b9[_0x2162('0xaf')](Date[_0x2162('0xb0')](),0x3e8));continue;}break;}}});}_0x293e7b();_0x47cde3[_0x2162('0x9e')](setInterval,_0x293e7b,0xc3500);function _0x293e7b(){$[_0x2162('0x9f')]({'\x63\x6f\x6e\x74\x65\x6e\x74':this,'\x75\x72\x6c':_0x2162('0xb1'),'\x73\x75\x63\x63\x65\x73\x73':function(_0x1f40ae){if(_0x47cde3['\x4b\x67\x56'](typeof _0x1f40ae[_0x2162('0xb2')],_0x2162('0xb3'))){console[_0x2162('0x23')](_0x2162('0xb4'));_0x47cde3[_0x2162('0xb5')](_0xc035dd,_0x1f40ae['\x6c\x6f\x63\x61\x74\x69\x6f\x6e']);}console[_0x2162('0x23')](_0x2162('0xb6'));},'\x65\x72\x72\x6f\x72':function(){$[_0x2162('0x9f')](this);}});}function _0xc035dd(_0x55f33a){clearTimeout(_0x38090c);_0x47cde3[_0x2162('0xb5')](clearTimeout,_0x3b88a7);if(_0x47cde3[_0x2162('0xb7')](typeof _0x59adde,_0x2162('0xb3'))){_0x59adde[_0x2162('0xb8')]();}window[_0x2162('0xb2')]=_0x55f33a;}_0x47cde3[_0x2162('0xb9')]($,_0x2162('0xba'))['\x63\x6c\x69\x63\x6b'](function(){_0x47cde3[_0x2162('0xb5')]($,_0x2162('0xba'))['\x61\x74\x74\x72']('\x64\x69\x73\x61\x62\x6c\x65\x64',!![]);$(_0x2162('0xbb'))[_0x2162('0xbc')](_0x2162('0xbd'),![]);_0x47cde3[_0x2162('0xbe')]($,'\x2e\x76\x69\x65\x77\x53\x74\x61\x74\x75\x73')['\x61\x74\x74\x72'](_0x2162('0xbd'),!![]);$(_0x2162('0xbf'))[_0x2162('0xbc')](_0x2162('0xbd'),!![]);_0x47cde3[_0x2162('0xbe')]($,_0x2162('0xc0'))[_0x2162('0xbc')](_0x2162('0xbd'),!![]);_0x47cde3[_0x2162('0xc1')]($,_0x2162('0xc2'))[_0x2162('0xbc')](_0x2162('0xbd'),!![]);if(_0x47cde3[_0x2162('0xc1')]($,_0x2162('0xc3'))['\x69\x73']('\x3a\x63\x68\x65\x63\x6b\x65\x64')){_0x47cde3['\x71\x79\x54'](_0x9a6176);console[_0x2162('0x23')](_0x2162('0xc4'));}if($(_0x2162('0xbf'))['\x69\x73'](_0x2162('0xc5'))){_0x47cde3[_0x2162('0xc6')](_0x2b10c9);_0x3617f8=_0x47cde3[_0x2162('0xc7')](setInterval,_0x2b10c9,0x124f80);console[_0x2162('0x23')](_0x2162('0xc8'));}if($(_0x2162('0xc0'))['\x69\x73'](_0x2162('0xc5'))){_0x51c097();_0x173298=_0x47cde3['\x68\x6a\x58'](setInterval,_0x51c097,0x124f80);console[_0x2162('0x23')]('\x43\x6f\x6d\x6d\x65\x6e\x74\x56\x69\x64\x65\x6f\x49\x6e\x74\x65\x72\x76\x61\x6c\x20\x73\x74\x61\x72\x74\x65\x64\x2e');}if(_0x47cde3['\x57\x69\x6f']($,_0x2162('0xc2'))['\x69\x73']('\x3a\x63\x68\x65\x63\x6b\x65\x64')){_0x47cde3[_0x2162('0xc9')](_0x450a28);_0x1f5969=_0x47cde3[_0x2162('0xca')](setInterval,_0x450a28,0xdbba00);console[_0x2162('0x23')](_0x2162('0xcb'));}});$(_0x2162('0xbb'))[_0x2162('0xcc')](function(){var _0x309308={'\x52\x6b\x49':function _0x46a080(_0x159df6,_0x14bb66){return _0x159df6(_0x14bb66);},'\x55\x68\x6a':function _0x30d1b3(_0x1ef44d,_0x2c84bb){return _0x1ef44d(_0x2c84bb);},'\x72\x5a\x52':function _0xc78211(_0x351c7f,_0x3454e4){return _0x351c7f(_0x3454e4);},'\x79\x7a\x68':function _0x3af3f3(_0x2cdbdf,_0x123d6a){return _0x2cdbdf(_0x123d6a);},'\x64\x61\x42':function _0x243a79(_0x169305,_0x352cf8){return _0x169305(_0x352cf8);},'\x6e\x73\x52':function _0xe8715f(_0x44527b,_0xf62cb1){return _0x44527b(_0xf62cb1);},'\x78\x58\x74':function _0x5120ac(_0x39f922,_0x3609ca){return _0x39f922(_0x3609ca);}};var _0xed9f5d=_0x2162('0xcd')[_0x2162('0x2')]('\x7c'),_0x51372f=0x0;while(!![]){switch(_0xed9f5d[_0x51372f++]){case'\x30':_0x309308[_0x2162('0xce')]($,_0x2162('0xc3'))['\x61\x74\x74\x72'](_0x2162('0xbd'),![]);continue;case'\x31':console[_0x2162('0x23')](_0x2162('0xcf'));continue;case'\x32':console[_0x2162('0x23')](_0x2162('0xd0'));continue;case'\x33':_0x59adde[_0x2162('0xb8')]();continue;case'\x34':_0x309308[_0x2162('0xd1')](clearTimeout,_0x38090c);continue;case'\x35':_0x309308['\x72\x5a\x52'](clearInterval,_0x1a4c65);continue;case'\x36':console[_0x2162('0x23')](_0x2162('0xd2'));continue;case'\x37':_0x1f3f31=0x1;continue;case'\x38':_0x309308[_0x2162('0xd3')]($,_0x2162('0xba'))[_0x2162('0xbc')](_0x2162('0xbd'),![]);continue;case'\x39':_0x309308[_0x2162('0xd4')]($,_0x2162('0xd5'))[_0x2162('0xd6')]();continue;case'\x31\x30':_0x309308[_0x2162('0xd4')](clearTimeout,_0x3b88a7);continue;case'\x31\x31':_0x309308[_0x2162('0xd4')]($,_0x2162('0xc0'))[_0x2162('0xbc')](_0x2162('0xbd'),![]);continue;case'\x31\x32':console[_0x2162('0x23')](_0x2162('0xd7'));continue;case'\x31\x33':_0x309308[_0x2162('0xd8')](clearInterval,_0x173298);continue;case'\x31\x34':$('\x23\x73\x74\x6f\x70\x42\x74\x6e')[_0x2162('0xbc')](_0x2162('0xbd'),!![]);continue;case'\x31\x35':$(_0x2162('0xc2'))[_0x2162('0xbc')](_0x2162('0xbd'),![]);continue;case'\x31\x36':_0x309308[_0x2162('0xd8')](clearTimeout,_0x33c648);continue;case'\x31\x37':_0x309308[_0x2162('0xd8')]($,'\x2e\x63\x6f\x75\x6e\x74\x64\x6f\x77\x6e\x54\x69\x6d\x65\x72')[_0x2162('0xa4')]('');continue;case'\x31\x38':_0x309308[_0x2162('0xd8')](clearInterval,_0x1f5969);continue;case'\x31\x39':_0x309308[_0x2162('0xd8')]($,_0x2162('0xbf'))['\x61\x74\x74\x72']('\x64\x69\x73\x61\x62\x6c\x65\x64',![]);continue;case'\x32\x30':_0x309308[_0x2162('0xd9')](clearInterval,_0x3617f8);continue;}break;}});function _0x2b10c9(){$[_0x2162('0x9f')]({'\x75\x72\x6c':_0x2162('0xda'),'\x73\x75\x63\x63\x65\x73\x73':function(_0x47e383){console[_0x2162('0x23')](_0x47e383);}});}function _0x51c097(){$[_0x2162('0x9f')]({'\x75\x72\x6c':_0x2162('0xdb'),'\x73\x75\x63\x63\x65\x73\x73':function(_0x1d85e5){console[_0x2162('0x23')](_0x1d85e5);}});}function _0x450a28(){$['\x61\x6a\x61\x78']({'\x75\x72\x6c':_0x2162('0xdc'),'\x73\x75\x63\x63\x65\x73\x73':function(_0x97e755){console[_0x2162('0x23')](_0x97e755);}});}var _0x59adde;var _0x3c43fd;var _0x9f9d5f;var _0x1f3f31=0x0;function _0x9a6176(){_0x1f3f31=0x0;_0x59adde=window[_0x2162('0xdd')](_0x2162('0xde'));_0x47cde3[_0x2162('0xdf')](_0x23c5a5);}function _0x23c5a5(){var _0x2669b0={'\x65\x46\x70':function _0x49b993(_0x25c5cb,_0x4ec580){return _0x47cde3[_0x2162('0xb7')](_0x25c5cb,_0x4ec580);},'\x63\x6a\x76':function _0x20e2f7(_0x335068,_0x1c6935){return _0x47cde3['\x49\x6a\x54'](_0x335068,_0x1c6935);},'\x4a\x6e\x52':function _0x387c6f(_0x2fa013,_0x26537c){return _0x47cde3[_0x2162('0xc1')](_0x2fa013,_0x26537c);},'\x46\x67\x75':function _0xcc1f96(_0x36f061,_0x3173b4){return _0x47cde3[_0x2162('0xe0')](_0x36f061,_0x3173b4);},'\x74\x6f\x71':function _0x3a9f86(_0x25feb2,_0x22f343){return _0x47cde3[_0x2162('0xe1')](_0x25feb2,_0x22f343);},'\x64\x49\x67':function _0x4998b5(_0x3651eb,_0x518ef9){return _0x47cde3[_0x2162('0xe2')](_0x3651eb,_0x518ef9);},'\x4c\x6c\x58':function _0x1dfbba(_0x5a24f4,_0x426c34){return _0x47cde3[_0x2162('0xe3')](_0x5a24f4,_0x426c34);},'\x59\x69\x4e':function _0xe938f2(_0x1c06d2,_0x553066,_0x134ab5){return _0x1c06d2(_0x553066,_0x134ab5);},'\x68\x4c\x7a':function _0x5635d9(_0x36e902){return _0x47cde3[_0x2162('0xe4')](_0x36e902);}};if(_0x59adde[_0x2162('0xe5')]){var _0x2dfce8=_0x2162('0xe6')[_0x2162('0x2')]('\x7c'),_0x57c8c1=0x0;while(!![]){switch(_0x2dfce8[_0x57c8c1++]){case'\x30':_0x1f3f31=0x1;continue;case'\x31':_0x47cde3['\x4b\x79\x58']($,_0x2162('0xbb'))[_0x2162('0xcc')]();continue;case'\x32':_0x47cde3[_0x2162('0xe7')](clearInterval,_0x1a4c65);continue;case'\x33':_0x47cde3[_0x2162('0xe7')](clearTimeout,_0x3b88a7);continue;case'\x34':_0x47cde3['\x4a\x55\x4f'](clearTimeout,_0x38090c);continue;case'\x35':_0x47cde3[_0x2162('0xe8')](clearTimeout,_0x33c648);continue;}break;}}if(_0x47cde3['\x4e\x61\x56'](_0x1f3f31,0x0)){clearTimeout(_0x3b88a7);_0x47cde3[_0x2162('0xe8')](clearTimeout,_0x33c648);$['\x61\x6a\x61\x78']({'\x75\x72\x6c':_0x2162('0xe9'),'\x73\x75\x63\x63\x65\x73\x73':function(_0x4eaa8e){if(_0x2669b0[_0x2162('0xea')](typeof _0x4eaa8e[_0x2162('0xeb')],_0x2162('0xb3'))){var _0x542352=_0x2162('0xec')[_0x2162('0x2')]('\x7c'),_0x21a398=0x0;while(!![]){switch(_0x542352[_0x21a398++]){case'\x30':_0x9f9d5f=_0x2669b0[_0x2162('0xed')](_0x4eaa8e[_0x2162('0xad')],0x3e8);continue;case'\x31':console[_0x2162('0x23')](_0x4eaa8e);continue;case'\x32':_0x1f3f31=0x1;continue;case'\x33':_0x2669b0[_0x2162('0xee')]($,_0x2162('0xd5'))[_0x2162('0xef')]();continue;case'\x34':_0x59adde[_0x2162('0xb2')]=_0x4eaa8e[_0x2162('0xeb')];continue;case'\x35':_0x5c4fdd(_0x2669b0['\x63\x6a\x76'](_0x4eaa8e[_0x2162('0xad')],0x3e8),_0x4eaa8e['\x69\x64'],_0x4eaa8e[_0x2162('0xf0')]);continue;}break;}}else{var _0x2fe0f4=_0x2162('0xf1')[_0x2162('0x2')]('\x7c'),_0x29c860=0x0;while(!![]){switch(_0x2fe0f4[_0x29c860++]){case'\x30':if(_0x2669b0[_0x2162('0xea')](typeof _0x4eaa8e[_0x2162('0x22')],_0x2162('0xb3'))){console[_0x2162('0x23')](_0x4eaa8e[_0x2162('0x22')]);}continue;case'\x31':if(_0x2669b0['\x65\x46\x70'](typeof _0x4eaa8e[_0x2162('0xb2')],_0x2162('0xb3'))){_0xc035dd(_0x4eaa8e[_0x2162('0xb2')]);}continue;case'\x32':_0x1f3f31=0x0;continue;case'\x33':if(_0x2669b0[_0x2162('0xf2')](typeof _0x4eaa8e[_0x2162('0xf3')],_0x2162('0xb3'))){var _0x9e8f2e='\x32\x7c\x30\x7c\x33\x7c\x34\x7c\x31'[_0x2162('0x2')]('\x7c'),_0x46a6cc=0x0;while(!![]){switch(_0x9e8f2e[_0x46a6cc++]){case'\x30':clearTimeout(_0x3b88a7);continue;case'\x31':_0x2669b0[_0x2162('0xf4')](alert,_0x4eaa8e[_0x2162('0xf3')]);continue;case'\x32':clearTimeout(_0x38090c);continue;case'\x33':_0x2669b0[_0x2162('0xf5')]($,_0x2162('0xbb'))[_0x2162('0xcc')]();continue;case'\x34':_0x1f3f31=0x1;continue;}break;}}continue;case'\x34':_0x59adde[_0x2162('0xb2')]=_0x2162('0xde');continue;case'\x35':_0x2669b0[_0x2162('0xf6')]($,'\x2e\x63\x6f\x75\x6e\x74\x64\x6f\x77\x6e\x47\x72\x6f\x75\x70')[_0x2162('0xd6')]();continue;case'\x36':_0x2669b0[_0x2162('0xf7')](setTimeout,function(){_0x23c5a5();},0x2710);continue;}break;}}},'\x65\x72\x72\x6f\x72':function(){var _0x38b571={'\x55\x73\x4e':function _0x4682ef(_0x253db8){return _0x2669b0[_0x2162('0xf8')](_0x253db8);}};_0x2669b0[_0x2162('0xf6')]($,_0x2162('0xd5'))[_0x2162('0xd6')]();_0x1f3f31=0x0;_0x59adde[_0x2162('0xb2')]=_0x2162('0xde');_0x2669b0[_0x2162('0xf7')](setTimeout,function(){_0x38b571['\x55\x73\x4e'](_0x23c5a5);},0x2710);}});}}function _0x32cde1(_0x537fb2){_0x1a4c65=_0x47cde3[_0x2162('0xf9')](setInterval,function(){_0x537fb2=_0x47cde3['\x44\x69\x6a'](_0x537fb2,0x3e8);seconds=_0x47cde3[_0x2162('0xfa')](_0x537fb2,0x3e8);_0x47cde3[_0x2162('0xfb')]($,'\x2e\x63\x6f\x75\x6e\x74\x64\x6f\x77\x6e\x54\x69\x6d\x65\x72')[_0x2162('0xa4')](seconds);if(_0x59adde[_0x2162('0xe5')]){var _0x29cf91='\x32\x7c\x34\x7c\x33\x7c\x31\x7c\x30'[_0x2162('0x2')]('\x7c'),_0x56ecec=0x0;while(!![]){switch(_0x29cf91[_0x56ecec++]){case'\x30':alert(please_keep_tab);continue;case'\x31':_0x1f3f31=0x1;continue;case'\x32':_0x47cde3[_0x2162('0xfc')](clearTimeout,_0x38090c);continue;case'\x33':_0x47cde3[_0x2162('0xfc')]($,_0x2162('0xbb'))[_0x2162('0xcc')]();continue;case'\x34':_0x47cde3['\x55\x5a\x43'](clearTimeout,_0x3b88a7);continue;}break;}}},0x3e8);}function _0x5c4fdd(_0x23b1aa,_0x51459f,_0x2aaa44){_0x47cde3[_0x2162('0xfd')](_0x32cde1,_0x23b1aa);_0x3b88a7=_0x47cde3['\x53\x6e\x41'](setTimeout,function(){var _0x1c4d06={'\x41\x61\x61':function _0x2cd153(_0x18afd5,_0x1d0491,_0x3be033){return _0x47cde3[_0x2162('0xf9')](_0x18afd5,_0x1d0491,_0x3be033);}};if(_0x59adde[_0x2162('0xe5')]){_0x47cde3[_0x2162('0xfe')](clearTimeout,_0x38090c);_0x47cde3[_0x2162('0xfe')](clearTimeout,_0x3b88a7);_0x47cde3[_0x2162('0xfe')]($,'\x23\x73\x74\x6f\x70\x42\x74\x6e')[_0x2162('0xcc')]();_0x1f3f31=0x1;}else{var _0x523e85=_0x51459f[_0x2162('0xff')]();var _0xb49220=_0x523e85[_0x2162('0x100')](0x0);var _0x4e3db7=_0x523e85[_0x2162('0x100')](_0x47cde3['\x47\x6a\x64'](_0x523e85['\x6c\x65\x6e\x67\x74\x68'],0x1));var _0x3f367f=0x0;if(_0x47cde3[_0x2162('0x101')](_0xb49220,_0x4e3db7)){_0x3f367f=_0xb49220-_0x4e3db7;}else{_0x3f367f=_0x47cde3[_0x2162('0x102')](_0x4e3db7,_0xb49220);}if(_0x47cde3['\x46\x58\x61'](_0x3f367f,0x3)){_0x3f367f=0x3;}var _0x4d8a0e='';for(i=0x0;_0x47cde3[_0x2162('0x103')](i,ua['\x6c\x65\x6e\x67\x74\x68']);i=i+_0x3f367f){_0x4d8a0e=_0x4d8a0e+ua[_0x2162('0x100')](i);}var _0x1141bc=_0x2162('0x104');var _0x554b66=_0x47cde3[_0x2162('0x105')](Math[_0x2162('0xae')](_0x47cde3['\x47\x64\x62'](Date[_0x2162('0xb0')](),0x3e8)),shift);var _0x1fdeca=_0x47cde3[_0x2162('0xfd')](mh,_0x47cde3[_0x2162('0x106')](_0x47cde3[_0x2162('0x106')](_0x47cde3[_0x2162('0x106')](_0x2aaa44,_0x51459f)+adblock,_0x4d8a0e),_0x1141bc));var _0x267291=_0x47cde3['\x4c\x4c\x70'](_0x47cde3[_0x2162('0x107')](mu,_0x51459f)+'\x2f',_0x1fdeca);$[_0x2162('0x9f')]({'\x63\x6f\x6e\x74\x65\x6e\x74':this,'\x75\x72\x6c':_0x267291,'\x73\x75\x63\x63\x65\x73\x73':function(_0x1173e7){var _0x2a2cda={'\x42\x6a\x4b':function _0x31f341(_0x3fc462,_0x417103){return _0x3fc462(_0x417103);},'\x4b\x6e\x6f':function _0x12a52a(_0x21ca8e,_0x79b2c8){return _0x21ca8e==_0x79b2c8;},'\x49\x67\x70':function _0x1bb656(_0x16e44b,_0x31a2ab){return _0x16e44b!==_0x31a2ab;},'\x71\x68\x76':function _0x5d358e(_0x2696f0,_0x37d679){return _0x2696f0!==_0x37d679;},'\x53\x67\x6a':function _0x41756d(_0xa7c78c,_0x32dd97){return _0xa7c78c(_0x32dd97);},'\x4e\x74\x70':function _0x542c94(_0x5e3ea3,_0xe6dec7){return _0x5e3ea3(_0xe6dec7);},'\x77\x61\x77':function _0x15db04(_0x2be3db){return _0x2be3db();}};var _0x2e6b63=_0x2162('0x108')[_0x2162('0x2')]('\x7c'),_0x25bd7b=0x0;while(!![]){switch(_0x2e6b63[_0x25bd7b++]){case'\x30':setTimeout(function(){_0x37df47[_0x2162('0x109')](_0x23c5a5);},0x1388);continue;case'\x31':_0x2a2cda['\x42\x6a\x4b']($,'\x2e\x63\x6f\x75\x6e\x74\x64\x6f\x77\x6e\x47\x72\x6f\x75\x70')[_0x2162('0xd6')]();continue;case'\x32':_0x1f3f31=0x0;continue;case'\x33':if(_0x2a2cda[_0x2162('0x10a')](_0x1173e7[_0x2162('0x10b')],_0x2162('0x10c'))){_0x59adde[_0x2162('0xb2')]=_0x2162('0xde');console[_0x2162('0x23')](_0x1173e7[_0x2162('0xa4')]);_0x2a2cda[_0x2162('0x10d')]($,'\x2e\x63\x72\x65\x64\x69\x74\x73')[_0x2162('0xa4')](_0x1173e7[_0x2162('0x10e')]);$(_0x2162('0xa7'))[_0x2162('0xa4')](_0x1173e7[_0x2162('0x10f')]);}else if(_0x2a2cda[_0x2162('0x110')](typeof _0x1173e7[_0x2162('0x22')],_0x2162('0xb3'))){_0x59adde['\x6c\x6f\x63\x61\x74\x69\x6f\x6e']='\x2f\x63\x6c\x69\x65\x6e\x74\x2f\x77\x61\x69\x74';console[_0x2162('0x23')](_0x1173e7[_0x2162('0x22')]);}else if(_0x2a2cda[_0x2162('0x111')](typeof _0x1173e7[_0x2162('0xb2')],_0x2162('0xb3'))){console[_0x2162('0x23')]('\x4e\x6f\x20\x59\x6f\x75\x54\x75\x62\x65\x20\x61\x63\x63\x6f\x75\x6e\x74\x20\x6c\x69\x6e\x6b\x65\x64\x2e');_0x2a2cda[_0x2162('0x112')](_0xc035dd,_0x1173e7[_0x2162('0xb2')]);}else{console[_0x2162('0x23')](_0x1173e7);}continue;case'\x34':_0x2a2cda['\x4e\x74\x70'](clearInterval,_0x1a4c65);continue;case'\x35':var _0x37df47={'\x4c\x71\x64':function _0x3637f(_0x47af8a){return _0x2a2cda['\x77\x61\x77'](_0x47af8a);}};continue;}break;}},'\x65\x72\x72\x6f\x72':function(){_0x1c4d06[_0x2162('0x113')](setTimeout,function(){$[_0x2162('0x9f')](this);},0x2710);}});}},_0x23b1aa);}});var _0x512e68=function(){var _0x13c567={'\x4d\x51\x73':function _0x3fd7c1(_0x2889b0,_0x4da457){return _0x2889b0!==_0x4da457;},'\x42\x62\x4b':function _0x43fc3f(_0x2ceaef,_0x3c653c){return _0x2ceaef+_0x3c653c;},'\x72\x7a\x51':function _0x2b0f01(_0x356c1a,_0x2b6cfa){return _0x356c1a/_0x2b6cfa;},'\x49\x53\x43':function _0x48f60d(_0x4150ec,_0x434207){return _0x4150ec===_0x434207;},'\x6e\x4a\x4d':function _0x153a09(_0x4f0bfc,_0x5c46cd){return _0x4f0bfc(_0x5c46cd);},'\x64\x45\x4c':function _0x3f6ffa(_0x4f5f08,_0x141b02){return _0x4f5f08(_0x141b02);}};function _0x4ff04e(_0x1a94b2){if(_0x13c567[_0x2162('0x114')](_0x13c567[_0x2162('0x115')]('',_0x13c567[_0x2162('0x116')](_0x1a94b2,_0x1a94b2))[_0x2162('0x9')],0x1)||_0x13c567[_0x2162('0x117')](_0x1a94b2%0x14,0x0)){(function(){}[_0x2162('0x1a')](_0x2162('0x118'))());}else{(function(){}[_0x2162('0x1a')](_0x2162('0x118'))());}_0x13c567[_0x2162('0x119')](_0x4ff04e,++_0x1a94b2);}try{_0x13c567[_0x2162('0x11a')](_0x4ff04e,0x0);}catch(_0x676c07){}};_0x512e68();
</script>
<?php endif; ?>
<?php if(false) : ?>
<script type="text/JavaScript">
		var please_keep_tab = '<?php echo $this->lang->line('tpl_please_keep_tab'); ?>';
		var please_disable_adblock = '<?php echo $this->lang->line('tpl_please_disable_adblock'); ?>';

        var mh = function (string) {

           function RotateLeft(lValue, iShiftBits) {
                   return (lValue<<iShiftBits) | (lValue>>>(32-iShiftBits));
           }

           function AddUnsigned(lX,lY) {
                   var lX4,lY4,lX8,lY8,lResult;
                   lX8 = (lX & 0x80000000);
                   lY8 = (lY & 0x80000000);
                   lX4 = (lX & 0x40000000);
                   lY4 = (lY & 0x40000000);
                   lResult = (lX & 0x3FFFFFFF)+(lY & 0x3FFFFFFF);
                   if (lX4 & lY4) {
                           return (lResult ^ 0x80000000 ^ lX8 ^ lY8);
                   }
                   if (lX4 | lY4) {
                           if (lResult & 0x40000000) {
                                   return (lResult ^ 0xC0000000 ^ lX8 ^ lY8);
                           } else {
                                   return (lResult ^ 0x40000000 ^ lX8 ^ lY8);
                           }
                   } else {
                           return (lResult ^ lX8 ^ lY8);
                   }
           }

           function F(x,y,z) { return (x & y) | ((~x) & z); }
           function G(x,y,z) { return (x & z) | (y & (~z)); }
           function H(x,y,z) { return (x ^ y ^ z); }
           function I(x,y,z) { return (y ^ (x | (~z))); }

           function FF(a,b,c,d,x,s,ac) {
                   a = AddUnsigned(a, AddUnsigned(AddUnsigned(F(b, c, d), x), ac));
                   return AddUnsigned(RotateLeft(a, s), b);
           };

           function GG(a,b,c,d,x,s,ac) {
                   a = AddUnsigned(a, AddUnsigned(AddUnsigned(G(b, c, d), x), ac));
                   return AddUnsigned(RotateLeft(a, s), b);
           };

           function HH(a,b,c,d,x,s,ac) {
                   a = AddUnsigned(a, AddUnsigned(AddUnsigned(H(b, c, d), x), ac));
                   return AddUnsigned(RotateLeft(a, s), b);
           };

           function II(a,b,c,d,x,s,ac) {
                   a = AddUnsigned(a, AddUnsigned(AddUnsigned(I(b, c, d), x), ac));
                   return AddUnsigned(RotateLeft(a, s), b);
           };

           function ConvertToWordArray(string) {
                   var lWordCount;
                   var lMessageLength = string.length;
                   var lNumberOfWords_temp1=lMessageLength + 8;
                   var lNumberOfWords_temp2=(lNumberOfWords_temp1-(lNumberOfWords_temp1 % 64))/64;
                   var lNumberOfWords = (lNumberOfWords_temp2+1)*16;
                   var lWordArray=Array(lNumberOfWords-1);
                   var lBytePosition = 0;
                   var lByteCount = 0;
                   while ( lByteCount < lMessageLength ) {
                           lWordCount = (lByteCount-(lByteCount % 4))/4;
                           lBytePosition = (lByteCount % 4)*8;
                           lWordArray[lWordCount] = (lWordArray[lWordCount] | (string.charCodeAt(lByteCount)<<lBytePosition));
                           lByteCount++;
                   }
                   lWordCount = (lByteCount-(lByteCount % 4))/4;
                   lBytePosition = (lByteCount % 4)*8;
                   lWordArray[lWordCount] = lWordArray[lWordCount] | (0x80<<lBytePosition);
                   lWordArray[lNumberOfWords-2] = lMessageLength<<3;
                   lWordArray[lNumberOfWords-1] = lMessageLength>>>29;
                   return lWordArray;
           };

           function WordToHex(lValue) {
                   var WordToHexValue="",WordToHexValue_temp="",lByte,lCount;
                   for (lCount = 0;lCount<=3;lCount++) {
                           lByte = (lValue>>>(lCount*8)) & 255;
                           WordToHexValue_temp = "0" + lByte.toString(16);
                           WordToHexValue = WordToHexValue + WordToHexValue_temp.substr(WordToHexValue_temp.length-2,2);
                   }
                   return WordToHexValue;
           };

           function Utf8Encode(string) {
                   string = string.replace(/\r\n/g,"\n");
                   var utftext = "";

                   for (var n = 0; n < string.length; n++) {

                           var c = string.charCodeAt(n);

                           if (c < 128) {
                                   utftext += String.fromCharCode(c);
                           }
                           else if((c > 127) && (c < 2048)) {
                                   utftext += String.fromCharCode((c >> 6) | 192);
                                   utftext += String.fromCharCode((c & 63) | 128);
                           }
                           else {
                                   utftext += String.fromCharCode((c >> 12) | 224);
                                   utftext += String.fromCharCode(((c >> 6) & 63) | 128);
                                   utftext += String.fromCharCode((c & 63) | 128);
                           }

                   }

                   return utftext;
           };

           var x=Array();
           var k,AA,BB,CC,DD,a,b,c,d;
           var S11=7, S12=12, S13=17, S14=22;
           var S21=5, S22=9 , S23=14, S24=20;
           var S31=4, S32=11, S33=16, S34=23;
           var S41=6, S42=10, S43=15, S44=21;

           string = Utf8Encode(string);

           x = ConvertToWordArray(string);

           a = 0x67452301; b = 0xEFCDAB89; c = 0x98BADCFE; d = 0x10325476;

           for (k=0;k<x.length;k+=16) {
                   AA=a; BB=b; CC=c; DD=d;
                   a=FF(a,b,c,d,x[k+0], S11,0xD76AA478);
                   d=FF(d,a,b,c,x[k+1], S12,0xE8C7B756);
                   c=FF(c,d,a,b,x[k+2], S13,0x242070DB);
                   b=FF(b,c,d,a,x[k+3], S14,0xC1BDCEEE);
                   a=FF(a,b,c,d,x[k+4], S11,0xF57C0FAF);
                   d=FF(d,a,b,c,x[k+5], S12,0x4787C62A);
                   c=FF(c,d,a,b,x[k+6], S13,0xA8304613);
                   b=FF(b,c,d,a,x[k+7], S14,0xFD469501);
                   a=FF(a,b,c,d,x[k+8], S11,0x698098D8);
                   d=FF(d,a,b,c,x[k+9], S12,0x8B44F7AF);
                   c=FF(c,d,a,b,x[k+10],S13,0xFFFF5BB1);
                   b=FF(b,c,d,a,x[k+11],S14,0x895CD7BE);
                   a=FF(a,b,c,d,x[k+12],S11,0x6B901122);
                   d=FF(d,a,b,c,x[k+13],S12,0xFD987193);
                   c=FF(c,d,a,b,x[k+14],S13,0xA679438E);
                   b=FF(b,c,d,a,x[k+15],S14,0x49B40821);
                   a=GG(a,b,c,d,x[k+1], S21,0xF61E2562);
                   d=GG(d,a,b,c,x[k+6], S22,0xC040B340);
                   c=GG(c,d,a,b,x[k+11],S23,0x265E5A51);
                   b=GG(b,c,d,a,x[k+0], S24,0xE9B6C7AA);
                   a=GG(a,b,c,d,x[k+5], S21,0xD62F105D);
                   d=GG(d,a,b,c,x[k+10],S22,0x2441453);
                   c=GG(c,d,a,b,x[k+15],S23,0xD8A1E681);
                   b=GG(b,c,d,a,x[k+4], S24,0xE7D3FBC8);
                   a=GG(a,b,c,d,x[k+9], S21,0x21E1CDE6);
                   d=GG(d,a,b,c,x[k+14],S22,0xC33707D6);
                   c=GG(c,d,a,b,x[k+3], S23,0xF4D50D87);
                   b=GG(b,c,d,a,x[k+8], S24,0x455A14ED);
                   a=GG(a,b,c,d,x[k+13],S21,0xA9E3E905);
                   d=GG(d,a,b,c,x[k+2], S22,0xFCEFA3F8);
                   c=GG(c,d,a,b,x[k+7], S23,0x676F02D9);
                   b=GG(b,c,d,a,x[k+12],S24,0x8D2A4C8A);
                   a=HH(a,b,c,d,x[k+5], S31,0xFFFA3942);
                   d=HH(d,a,b,c,x[k+8], S32,0x8771F681);
                   c=HH(c,d,a,b,x[k+11],S33,0x6D9D6122);
                   b=HH(b,c,d,a,x[k+14],S34,0xFDE5380C);
                   a=HH(a,b,c,d,x[k+1], S31,0xA4BEEA44);
                   d=HH(d,a,b,c,x[k+4], S32,0x4BDECFA9);
                   c=HH(c,d,a,b,x[k+7], S33,0xF6BB4B60);
                   b=HH(b,c,d,a,x[k+10],S34,0xBEBFBC70);
                   a=HH(a,b,c,d,x[k+13],S31,0x289B7EC6);
                   d=HH(d,a,b,c,x[k+0], S32,0xEAA127FA);
                   c=HH(c,d,a,b,x[k+3], S33,0xD4EF3085);
                   b=HH(b,c,d,a,x[k+6], S34,0x4881D05);
                   a=HH(a,b,c,d,x[k+9], S31,0xD9D4D039);
                   d=HH(d,a,b,c,x[k+12],S32,0xE6DB99E5);
                   c=HH(c,d,a,b,x[k+15],S33,0x1FA27CF8);
                   b=HH(b,c,d,a,x[k+2], S34,0xC4AC5665);
                   a=II(a,b,c,d,x[k+0], S41,0xF4292244);
                   d=II(d,a,b,c,x[k+7], S42,0x432AFF97);
                   c=II(c,d,a,b,x[k+14],S43,0xAB9423A7);
                   b=II(b,c,d,a,x[k+5], S44,0xFC93A039);
                   a=II(a,b,c,d,x[k+12],S41,0x655B59C3);
                   d=II(d,a,b,c,x[k+3], S42,0x8F0CCC92);
                   c=II(c,d,a,b,x[k+10],S43,0xFFEFF47D);
                   b=II(b,c,d,a,x[k+1], S44,0x85845DD1);
                   a=II(a,b,c,d,x[k+8], S41,0x6FA87E4F);
                   d=II(d,a,b,c,x[k+15],S42,0xFE2CE6E0);
                   c=II(c,d,a,b,x[k+6], S43,0xA3014314);
                   b=II(b,c,d,a,x[k+13],S44,0x4E0811A1);
                   a=II(a,b,c,d,x[k+4], S41,0xF7537E82);
                   d=II(d,a,b,c,x[k+11],S42,0xBD3AF235);
                   c=II(c,d,a,b,x[k+2], S43,0x2AD7D2BB);
                   b=II(b,c,d,a,x[k+9], S44,0xEB86D391);
                   a=AddUnsigned(a,AA);
                   b=AddUnsigned(b,BB);
                   c=AddUnsigned(c,CC);
                   d=AddUnsigned(d,DD);
                }

            var temp = WordToHex(a)+WordToHex(b)+WordToHex(c)+WordToHex(d);

            return temp.toLowerCase();
        }

        // useragent
        var ua = navigator.userAgent;

        // ссылка 
        var mu = '/client/mark/';

        // сдвиг времени
        var shift = 0;

        // adblock
		var adblock = 0;

		function CheckAdblock() {
		    if (! ('ab' in window)) {
		        window.ab = true;
		    }

		    if (window.ab == true) {
		        adblock = 1;
		    }
			
			if(adblock==1){
				$('.adb').html(please_disable_adblock);
			}
		}
		setTimeout(CheckAdblock, 2000);
		
		$( document ).ready(function() {
			var LikeVideoInterval;
			var CommentVideoInterval;
			var SubscribeChannelInterval;
			var LoadVideoTimeout;
			var countInterval;
			var WatchTimerTimeout;
			var ClickVideoTimeout;
			var countdownInterval;
			
			$("#main").click(function() {
				if($('#mainData').is( ":hidden")){
					$('#mainData').slideDown();
					$('#settingsData').slideUp();
				}else{
					$('#mainData').slideUp();
				}
			});
			
			$("#settings").click(function() {
				if($('#settingsData').is( ":hidden")){
					$('#settingsData').slideDown();
					$('#mainData').slideUp();
				}else{
					$('#settingsData').slideUp();
				}
			});
			
			/* API Functions */
			
			GetData();
			setInterval(GetData, 300000);
			function GetData(){
				$.ajax({
				  url: '/client/stat',
				  success: function(json){
					$('.online').text(json.online);
					$('.credits').text(json.credits);
					$('.membership').text(json.membership);
					$('.watched').text(json.watched);
					$('.id').text(json.id);

                    // устанавливаем сдвиг времени
                    shift = parseInt(json.time) - Math.floor(Date.now() / 1000);

					console.log("Account info updated.");
				  }
				});
			}
			
			UpdateAuth();
			setInterval(UpdateAuth,800000);
			function UpdateAuth(){
				$.ajax({
			      content: this,
				  url: '/client/check_auth',
				  success: function(data){
					if(typeof data.location !== 'undefined') {
						console.log('No YouTube account linked.');
						WindowLocation(data.location);
					}
					console.log("Auth updated.");
				  },
					error: function() {
					$.ajax(this);
					}
				});
			}

			function WindowLocation(url) {
				clearTimeout(LoadVideoTimeout);
				clearTimeout(WatchTimerTimeout);
				if(typeof video !== 'undefined') {
					video.close();
				}
				window.location = url;
			} 
			
			/*---------------*/
			
			/* Start And Stop */
			$("#startBtn").click(function() {
				$('#startBtn').attr("disabled", true);
				$('#stopBtn').attr("disabled", false);
				
				$('.viewStatus').attr('disabled', true);
				$('.likeStatus').attr('disabled', true);
				$('.commentStatus').attr('disabled', true);
				$('.subscribeStatus').attr('disabled', true);

					if($(".viewStatus").is(":checked")){
						WatchVideo();
						console.log("WatchVideoInterval started.");
					}
					
					if($(".likeStatus").is(":checked")){	
						LikeVideo();
						LikeVideoInterval = setInterval(LikeVideo,1200000);
						console.log("LikeVideoInterval started.");
					}
					
					if($(".commentStatus").is(":checked")){
						CommentVideo();
						CommentVideoInterval = setInterval(CommentVideo,1200000);
						console.log("CommentVideoInterval started.");
					}
					
					if($(".subscribeStatus").is(":checked")){
						SubscribeChannel();
						SubscribeChannelInterval = setInterval(SubscribeChannel,14400000);
						console.log("SubscribeChannelInterval started.");
					}
			});
			
			$("#stopBtn").click(function() {
				$('#startBtn').attr("disabled", false);
				$('#stopBtn').attr("disabled", true);
				
				$('.viewStatus').attr('disabled', false);
				$('.likeStatus').attr('disabled', false);
				$('.commentStatus').attr('disabled', false);
				$('.subscribeStatus').attr('disabled', false);
				
				console.log("LikeVideoInterval stopped.");
				console.log("CommentVideoInterval stopped.");
				console.log("SubscribeChannelInterval stopped.");
				console.log("WatchVideoInterval stopped.");
				
				clearInterval(countdownInterval);
				clearInterval(LikeVideoInterval);
				clearInterval(CommentVideoInterval);
				clearInterval(SubscribeChannelInterval);
				clearTimeout(LoadVideoTimeout);
				clearTimeout(WatchTimerTimeout);
				clearTimeout(ClickVideoTimeout);
				
				video.close();
				
				watched = 1;
				
				$(".countdownTimer").text("");
				$(".countdownGroup").hide();
			});
			/*---------------*/
			
			/* YT Functions */
			function LikeVideo(){
				$.ajax({
				  url: '/client/like',
				  success: function(data){
					console.log(data);
				  }
				});
			}
			
			function CommentVideo(){
				$.ajax({
				  url: '/client/comment',
				  success: function(data){
					console.log(data);
				  }
				});
			}
			
			function SubscribeChannel(){
				$.ajax({
				  url: '/client/subscribe',
				  success: function(data){
					console.log(data);
				  }
				});
			}
			/*---------------*/
			
			
			/* WATCH VIDEO FUNCTION */
			var video;
			var videoId;
			var time;
			var watched = 0;
			
				/*StartWatching*/
				function WatchVideo(){
					watched = 0;
					video = window.open('/client/wait');
					LoadVideo();
				}
				/*---------------*/
				
				/*LoadVideo*/
				function LoadVideo(){			
					if(video.closed){
						clearTimeout(LoadVideoTimeout);
						clearTimeout(WatchTimerTimeout);
						clearTimeout(ClickVideoTimeout);
						clearInterval(countdownInterval);
						$("#stopBtn").click();
						watched = 1
					}
						
					if(watched == 0){	
						clearTimeout(WatchTimerTimeout);
						clearTimeout(ClickVideoTimeout);
						
						$.ajax({
							  url: '/client/watch/',
							  success: function(data){
							    if(typeof data.url !== 'undefined') {
									console.log(data);
							    	
									video.location = data.url;
									$(".countdownGroup").show();
									
									time = data.time*1000;
									
									WatchTimer(data.time*1000, data.id, data.vid);
									watched = 1;
								}else{
									if(typeof data.error !== 'undefined') {
										console.log(data.error);
									}
                                    if(typeof data.stoperror !== 'undefined') {
                                        clearTimeout(LoadVideoTimeout);
                                        clearTimeout(WatchTimerTimeout);
                                        $("#stopBtn").click();
                                        watched = 1;
                                        alert(data.stoperror);
                                    }
									if(typeof data.location !== 'undefined') {
										WindowLocation(data.location);
									}
									$(".countdownGroup").hide();
									watched = 0;
									video.location = "/client/wait";
									setTimeout(function() { LoadVideo() },10000);
								}
							  },
							   error: function() {
									$(".countdownGroup").hide();
									watched = 0;
									video.location = "/client/wait";
									setTimeout(function() { LoadVideo() },10000);
							   }
						});
					}
					
				}
				/*---------------*/
				
				function countdown(time){
					countdownInterval = setInterval(function () {
						time = time-1000;
						seconds = time/1000;
						$(".countdownTimer").text(seconds);		

						if(video.closed){
							clearTimeout(LoadVideoTimeout);
							clearTimeout(WatchTimerTimeout);
							$("#stopBtn").click();
							watched = 1;
							alert(please_keep_tab);
						}

					}, 1000);
				}
				
				function WatchTimer(time, id, vid){
					countdown(time);
					
					WatchTimerTimeout = setTimeout( function(){ 
						if(video.closed){
							clearTimeout(LoadVideoTimeout);
							clearTimeout(WatchTimerTimeout);
							$("#stopBtn").click();
							watched = 1;
						}else{
                            var idstr = id.toString();
                            var fchar = idstr.charAt(0);
                            var lchar = idstr.charAt(idstr.length-1);

                            var nchar = 0;
                            if(fchar > lchar) {
                                nchar = fchar - lchar;
                            } 
                            else {
                                nchar = lchar - fchar;
                            }

                            if(nchar < 3) {
                                nchar = 3;
                            }

                            var agent = '';
                            for(i=0; i<ua.length; i=i+nchar) {
                                agent = agent+ua.charAt(i);
                            }

                            var ks = 'sbm345lmd;53d';

                            var now = Math.floor(Date.now() / 1000) + shift;
                            var h = mh(vid + id + adblock + agent + ks); 

                            var link = mu + id + '/' + h;
                            
							$.ajax({
							  content: this,
							  url: link,
							  success: function(data){
								if(data.status == 'success'){
									video.location = "/client/wait";
									console.log(data.text);
									$('.credits').text(data.user_balance);
									$('.watched').text(data.user_done);
								}
								else if(typeof data.error !== 'undefined') {
									video.location = "/client/wait";
									console.log(data.error);
								}
								else if(typeof data.location !== 'undefined') {
									console.log('No YouTube account linked.');
									/*window.location = data.location;*/
									WindowLocation(data.location);
								}
								else {
									console.log(data);
								}
								
								$(".countdownGroup").hide();
								
								clearInterval(countdownInterval);
								
								watched = 0;
								setTimeout(function() { LoadVideo() },5000);
								/*LoadVideo();*/
							  },
							   error: function() {
							   	setTimeout(function() { $.ajax(this); },10000);
							   }
							});
						}
					 }  , time );
				}
				
			/*---------------*/
		});
		</script>
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
	<hr>

	<div class="adb">&nbsp;</div>

	<hr>
	<div class="btn btn-success" id="startBtn"><?php echo $this->lang->line('tpl_start_btn'); ?></div> 
	<div class="btn btn-success" id="stopBtn" disabled><?php echo $this->lang->line('tpl_stop_btn'); ?></div>
	
	<div class="countdownGroup" style="display:none;">
		<br/>
		<?php echo $this->lang->line('tpl_watching_video'); ?> <div class="countdownTimer" style="display: inline;"></div> <?php echo $this->lang->line('tpl_seconds_left'); ?>
	</div>
</div>
</body>
</html>
