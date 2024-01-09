<!DOCTYPE html>
<!--[if IE 8]>			<html class="ie ie8"> <![endif]-->
<!--[if IE 9]>			<html class="ie ie9"> <![endif]-->
<!--[if gt IE 9]><!-->	<html> <!--<![endif]-->
<head>
	<meta charset="utf-8"/>
	<title><?php echo $this->lang->line('page_title'); ?></title>
	<meta name="verification" content="2a41995647dd010a9c02e976505083" />
	<meta name="description" content="<?php echo $this->lang->line('meta_description'); ?>"/>
	<meta name="keywords" content="<?php echo $this->lang->line('meta_keywords'); ?>" />
	<meta name="owner" content="dev@ytuber.ru"/>
	<meta name="author" content="Ytuber"/>
	<meta name="resourse-type" content ="Document"/>
	<meta http-equiv="expires" content=""/>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<meta http-equiv="content-language" content="<?php echo $this->lang->line('meta_lang'); ?>"/>
	<meta name="robots" content="index,follow"/>
	<meta name="revisit-after" content="1 days"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<meta property="og:image" content="<?=site_url('/static/index/ytuber.png');?>"/>
    <meta name="google-signin-client_id" content="<?php echo $this->config->item('google')['client_id'];?>">

	<link rel="shortcut icon" href="/favicon.ico" />
    <?php /*
	<link rel="shortcut icon" href="img/favicon.ico">
	<link rel="apple-touch-icon" href="img/apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="img/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="114x114" href="img/apple-touch-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="144x144" href="img/apple-touch-icon-144x144.png">
	<!--
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&subset=latin,cyrillic-ext' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Raleway:400,100,200,300,500,600,700,800,900' rel='stylesheet' type='text/css'>
	-->*/ ?>
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&subset=latin,cyrillic-ext' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Raleway:400,100,200,300,500,600,700,800,900' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="/static/index/bootstrap.min.css">
	<link rel="stylesheet" href="/static/index/main.min.css">

	<?php if($_SERVER['HTTP_HOST'] == 'ytuber.ru') { ?>
	  <link rel="stylesheet" type="text/css" href="/static/index/slick/slick.css">
	  <link rel="stylesheet" type="text/css" href="/static/index/slick/slick-theme.css">
	<?php } ?>
	<!--[if lt IE 9]>
      	<script src="./js/html5shiv.js"></script>
	    <script src="./js/respond.js"></script>
	<![endif]-->
	<script src="/static/index/modernizr.custom.js" async></script>
	
	<?php require_once('_head.php'); ?>

	<script src='https://www.google.com/recaptcha/api.js'></script>

	<style>
	.grecaptcha-badge {display: none;}
	</style>
<script src="//code-ya.jivosite.com/widget/ByNz0yKIb7" async></script>
</head>
<body>

<nav class="navbar navbar-default navbar-fixed-top header" role="navigation">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand logo" id="logo" href="<?php echo site_url('/'); ?>" title="<?php echo $this->lang->line('logo_title'); ?>"><?php echo $this->lang->line('logo_text'); ?></a> 
			
		</div>
		<div class="collapse navbar-collapse navbar-right navbar-ex1-collapse">
			<ul class="nav navbar-nav">
				<li><a href="#login" class="active"><span><?php if($this->user) {echo $this->lang->line('account');} else {echo $this->lang->line('login');} ?></span></a></li>
				<li><a href="#about"><span><?php echo $this->lang->line('about_us'); ?></span></a></li>
				<li><a href="#contact"><span><?php echo $this->lang->line('contact_us'); ?></span></a></li>
			</ul>
		</div>
	</div>
</nav>

<script>
function submitLoginForm() {
    document.getElementById("loginForm").submit();
}
</script>

<style>
    .login-form p a {
        text-transform: uppercase;
        font-weight: bold;
        text-shadow: 1px 1px 0px #000;
    }
</style>

<a id="login" class="anchor"></a>
<div class="top-header">
	<div class="container">
		<div class="row">
			<div class="col-sm-6">
				<div class="top-message">
					<?php echo $this->lang->line('header_h1'); ?>
					<hr class="top-divider"><br />
					<?php echo $this->lang->line('header_description'); ?>
				</div>
			</div>
			<div class="col-sm-6">
					<?php if($this->user) : ?>
						<div class="login-form">
							<h3><?=$this->user->mail?> <small><?=anchor('auth/logout', $this->lang->line('logout'));?></small></h3>
							<h4><?php echo $this->lang->line('your_balance'); ?> <?=$this->user->balance;?></h4>
							<p><?=anchor('dashboard', $this->lang->line('go_to_dashboard'), 'class="btn1 btn-7 btn-7a"'); ?><p>
						</div>
					<?php else: ?>
					<?php echo form_open('auth/login', 'class="login-form" id="loginForm"'); ?>
							<div class="row">
								<input id="email" name="mail" class="form-control" type="email" placeholder="<?php echo $this->lang->line('email'); ?>"/>
							</div>

							<div class="row">
								<input id="password" name="password" class="form-control" type="password" placeholder="<?php echo $this->lang->line('password'); ?>"/>
							</div>
							<p><?=anchor('auth/singup', $this->lang->line('singup')); ?><p>
							<p><?=anchor('auth/forgot', $this->lang->line('forgot')); ?><p>
							
							<div class="row">							
								<div class="col-lg-4 legend">
								<button type="submit" data-sitekey="<?php echo $this->config->item('recaptcha2')['pub']; ?>" data-callback="submitLoginForm" class="g-recaptcha btn1 btn-7 btn-7a" style="padding: 11px 25px; margin: 0;"><?php echo $this->lang->line('login_btn'); ?></button> 

  

								<?php if(false) : ?>
								<a href="/auth/google/" title="<?php echo $this->lang->line('google_auth'); ?>"><img src="/static/index/google_login.png" alt="<?php echo $this->lang->line('google_auth'); ?>" style="width: 120px;" /></a>
								</div>
								<?php endif; ?>
							</div>

							<div class="col-lg-8 legend">
								

								  <div id="my-signin2"></div>
								  <script>
								    function onSuccess(googleUser) {
								      console.log('Logged in as: ' + googleUser.getBasicProfile().getName());
								    }
								    function onFailure(error) {
								      console.log(error);
								    }
								    function renderButton() {
								      gapi.signin2.render('my-signin2', {
								        'scope': 'profile email',
								        'width': 240,
								        'height': 50,
								        'longtitle': true,
								        'theme': 'dark',
								        'onsuccess': onSuccess,
								        'onfailure': onFailure,
								        'ux_mode': 'redirect',
								        'redirect_uri': '<?=site_url('auth/google');?>'
								      });
								    }
								  </script>

								  <script src="https://apis.google.com/js/platform.js?onload=renderButton" async defer></script>
							</div>
					</form>
					<?php endif; ?>
			</div>
		</div>
	</div>
</div>

<a id="about" class="anchor"></a>

<style>
 .capability {padding: 40px 0;}
 .capability .col-sm-6 {margin-bottom: 15px;}
 .capability img {float: left; margin-right: 15px; margin-top: 5px; opacity: 0.9;}
 .capability h4, .capability p.lead {margin-left: 75px;}
</style>

<div class="wrap-content wrap-content1 capability">
	<div class="container">
				<div class="clearfix"></div>
				<h2><?php echo $this->lang->line('features'); ?></h2>
		<div class="row">
			<div class="col-sm-6">
				<img src="/static/index/icon_view.png" width="60" alt="<?php echo $this->lang->line('view_alt'); ?>" />
				<h4><?php echo $this->lang->line('view_title'); ?></h4>
				<p class="lead"><?php echo $this->lang->line('view_desc'); ?></p>
				<div class="clearfix"></div>
			</div>
			<div class="col-sm-6">
				<img src="/static/index/icon_like.png" width="60" alt="<?php echo $this->lang->line('like_alt'); ?>" />
				<h4><?php echo $this->lang->line('like_title'); ?></h4>
				<p class="lead"><?php echo $this->lang->line('like_desc'); ?></p>
				<div class="clearfix"></div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6">
				<img src="/static/index/icon_comment.png" width="60" alt="<?php echo $this->lang->line('comment_alt'); ?>" />
				<h4><?php echo $this->lang->line('comment_title'); ?></h4>
				<p class="lead"><?php echo $this->lang->line('comment_desc'); ?></p>
				<div class="clearfix"></div>
			</div>
			<div class="col-sm-6">
				<img src="/static/index/icon_subscribe.png" width="60" alt="<?php echo $this->lang->line('subscribe_alt'); ?>" />
				<h4><?php echo $this->lang->line('subscribe_title'); ?></h4>
				<p class="lead"><?php echo $this->lang->line('subscribe_desc'); ?></p>
				<div class="clearfix"></div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6">
				<img src="/static/index/icon_replies.png" width="60" alt="<?php echo $this->lang->line('replies_alt'); ?>" />
				<h4><?php echo $this->lang->line('replies_title'); ?></h4>
				<p class="lead"><?php echo $this->lang->line('replies_desc'); ?></p>
				<div class="clearfix"></div>
			</div>
			<div class="col-sm-6">
				<img src="/static/index/icon_comment_like.png" width="60" alt="<?php echo $this->lang->line('comment_like_alt'); ?>" />
				<h4><?php echo $this->lang->line('comment_like_title'); ?></h4>
				<p class="lead"><?php echo $this->lang->line('comment_like_desc'); ?></p>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>



<?php if($_SERVER['HTTP_HOST'] == 'ytuber.ru') { //#0D233C url(/static/index/office.png) ?>
<style>
.slick-dots {
}
.slick-list {
	box-shadow: 1px 1px 15px rgba(0, 0, 0, 0.32);
}
.slick-slide {
	outline: none;
}
.slick-slide p {
	margin: 7px 0;
}
</style>
<div class="wrap-content" style="background: #e42b28; padding: 20px 0 40px 0;">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<section class="regular slider" style="text-align: center; max-width: 1000px; margin: 0 auto;">
				    <div>
				      <p>Пользовательские настройки</p>
				      <img src="/static/index/Screenshot_1.png">
				    </div>
				    <div>
				      <p>Перевод средств между пользователями</p>
				      <img src="/static/index/Screenshot_2.png">
				    </div>
				    <div>
				      <p>Добавление новой задачи</p>
				      <img src="/static/index/Screenshot_3.png">
				    </div>
				    <div>
				      <p>Список задач доступных для выполнения</p>
				      <img src="/static/index/Screenshot_4.png">
				    </div>
				</section>
			</div>
		</div>
	</div>
</div>
<?php } else { ?>

<div class="wrap-content" style="background: #e42b28; padding: 20px 0;">
	<div class="container">
		<div class="row">
			<div class="col-sm-5">
				<img class="img-responsive" src="<?php echo $this->lang->line('bonus_img_src'); ?>" alt="<?php echo $this->lang->line('bonus_img_alt'); ?>" style="width: 80%; margin: 0 auto;" />
			</div>
			<div class="col-sm-7">
				<hr class="heading-spacer">
				<div class="clearfix"></div>
				<h2><?php echo $this->lang->line('bonus_title'); ?></h2>
				<p class="lead"><?php echo $this->lang->line('bonus_desc_1'); ?></p>
				<p class="lead"><?php echo $this->lang->line('bonus_desc_2'); ?></p>
				<p class="lead"><?php echo $this->lang->line('bonus_desc_3'); ?></p>
			</div>
		</div>
	</div>
</div>

<?php } ?>

<div class="wrap-content wrap-content1">
	<div class="container">
		<div class="row">
			<div class="col-sm-6">
				<hr class="heading-spacer">
				<div class="clearfix"></div>
				<h2><?php echo $this->lang->line('ref_title'); ?></h2>
				<p class="lead"><?php echo $this->lang->line('ref_desc_1'); ?></p>
				<p class="lead"><?php echo $this->lang->line('ref_desc_2'); ?></p>
			</div>
			<div class="col-sm-6">
				<img class="img-responsive" src="/static/index/referaly.jpg" alt="">
			</div>
		</div>
	</div>
</div>

<?php if(true) { ?>
<style>
	.counters {background:#f8f8f8; border-top: 1px solid #cacaca;border-bottom: 1px solid #cacaca; padding: 5px 0; color: #1e1e1e;}
	.counters .col-sm-3 {margin: 10px 0;}
	.counters .num {font-size: 35px; display: block; font-weight: 200; color: #C51A1F;}
	.counters .text {font-size: 20px; font-weight: 200;}
</style>
<div class="wrap-content counters">
	<div class="container">
		<div class="row">
			<div class="col-sm-3">
				<span class="num" id="counter1"><?php echo $counters[1]; ?></span>
				<span class="text"><?php echo $this->lang->line('count_total_users'); ?></span>
			</div>
			<div class="col-sm-3">
				<span class="num" id="counter2"><?php echo $counters[2]; ?></span>
				<span class="text"><?php echo $this->lang->line('count_online_users'); ?></span>
			</div>
			<div class="col-sm-3">
				<span class="num" id="counter3"><?php echo $counters[3]; ?></span>
				<span class="text"><?php echo $this->lang->line('count_total_tasks'); ?></span>
			</div>
			<div class="col-sm-3">
				<span class="num" id="counter4"><?php echo $counters[4]; ?></span>
				<span class="text"><?php echo $this->lang->line('count_complete_tasks'); ?></span>
			</div>
		</div>
	</div>
</div>
<?php } ?>

<?php if(true) : ?>
<a id="contact" class="anchor"></a>
<div class="container team">
	<div class="row">
		<div class="col-lg-12">
			<h2><?php echo $this->lang->line('contact_form_title'); ?></h2>
			<div class="col-lg-12">
			
				<form class="contact-form" action="/main/contact" method="post">
					<fieldset>
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
					
						<div class="row">
							<input id="name" name="name" class="form-control" type="text" placeholder="<?php echo $this->lang->line('contact_form_your_name'); ?>">
						</div>

						<div class="row">
							<input id="email" name="email" class="form-control" type="email" placeholder="<?php echo $this->lang->line('contact_form_your_email'); ?>"/>
						</div>						
						
						<div class="row">
							<textarea id="text" name="text" class="form-control" style="height: 160px; resize: vertical;" placeholder="<?php echo $this->lang->line('contact_form_your_message'); ?>"></textarea>
						</div>

						<div class="row">
							<div class="g-recaptcha" data-sitekey="<?php echo $this->config->item('recaptcha2')['pub'];?>"></div>
						</div>

						<div class="row">							
							<div class="col-lg-3 legend" style="padding: 0;">
								<button type="submit" class="btn1 btn-8 btn-7a"><i class="fa fa-send-o"></i> <?php echo $this->lang->line('contact_form_send'); ?></button>
							</div>			
							<div class="col-lg-9 legend status" style="padding: 0; padding-top: 28px;"></div>
						</div>
					</fieldset>
				</form>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>

<?php if(false) : ?>
<div class="newsletter">
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2 text-center">
				<h3><?php echo $this->lang->line('share_title'); ?></h3>
<script type="text/javascript">(function() {
  if (window.pluso)if (typeof window.pluso.start == "function") return;
  if (window.ifpluso==undefined) { window.ifpluso = 1;
    var d = document, s = d.createElement('script'), g = 'getElementsByTagName';
    s.type = 'text/javascript'; s.charset='UTF-8'; s.async = true;
    s.src = ('https:' == window.location.protocol ? 'https' : 'http')  + '://share.pluso.ru/pluso-like.js';
    var h=d[g]('body')[0];
    h.appendChild(s);
  }})();</script>
<div class="pluso" data-background="transparent" data-options="big,round,line,horizontal,nocounter,theme=04" data-services="vkontakte,facebook,odnoklassniki,twitter,google,moimir,email"></div>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>

<footer>
	<div class="container">
		<div class="row">
			<div class="col-lg-12">

                <div class="yashare" style="text-align: center; margin-bottom: 15px;">
                    <script src="https://yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
                    <script src="https://yastatic.net/share2/share.js"></script>
                    <div class="ya-share2" data-services="vkontakte,facebook,odnoklassniki,twitter,tumblr,viber,whatsapp,telegram"></div>
                </div>

				<ul class="list-inline">
					<li><a href="#login"><?php echo $this->lang->line('login'); ?></a></li>
					<li>&sdot;</li>
					<li><a href="#about"><?php echo $this->lang->line('about_us'); ?></a></li>
					<li>&sdot;</li>
					<li><a href="#contact"><?php echo $this->lang->line('contact_us'); ?></a></li>
				</ul>
				<p class="copyright text-center medium">Copyright &copy; <?=anchor('https://ytuber.ru/', 'YTuber.ru');?> 2013-<?=date('Y');?>. All Rights Reserved</p>
			</div>
		</div>
	</div>
</footer>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="/static/index/jquery.form.min.js"></script>
<script src="/static/bower/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="/static/index/main.js?v8"></script>

<?php if($_SERVER['HTTP_HOST'] == 'ytuber.ru') { ?>
<script src="/static/index/slick/slick.min.js" type="text/javascript" charset="utf-8"></script>
  <script type="text/javascript">
$(document).on('ready', function() {
  $(".regular").slick({
    dots: true,
    infinite: true,
    autoplay: true,
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: false
  });
});
</script>
<?php } ?>
</body>
</html>