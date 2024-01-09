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
	<link rel="manifest" href="/manifest.json">
    
    <?php /*
    <meta name="google-signin-client_id" content="<?php echo $this->config->item('google')['client_id'];?>">
	 */ ?>

	<link rel="shortcut icon" href="/favicon.ico" />
    <?php /*
	<link rel="shortcut icon" href="img/favicon.ico">
    */ ?>
	<link rel="apple-touch-icon" sizes="180x180" href="/i-180.png">
	<link rel="apple-touch-icon" sizes="167x167" href="/i-167.png">
	<link rel="apple-touch-icon" sizes="152x152" href="/i-152.png">

	<link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&subset=latin,cyrillic-ext&display=swap' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Raleway:400,100,200,300,500,600,700,800,900&display=swap' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="/static/css/index/bootstrap.min.css" rel=preload>
	<link rel="stylesheet" href="/static/css/index/main.min.css?v15" rel=preload>

	<!--[if lt IE 9]>
      	<script src="./js/html5shiv.js"></script>
	    <script src="./js/respond.js"></script>
	<![endif]-->

	<style>
	.grecaptcha-badge {display: none;}
	</style>
</head>
<body>

<nav class="navbar navbar-default header" role="navigation"> <?php /*navbar-fixed-top */ ?>
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
			</ul>
		</div>

			<div style=" display: inline-block; padding: 15px 0; float: right; " class="language" data-select="ru">
				<select style="padding: 3px; border-radius: 5px; border: 0px; ">
					<option value="ru">RUS</option>
					<option value="en">ENG</option>
				</select>
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
<div class="top-header bg-1">
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
								<div class="col-lg-12 legend">
									<button type="submit" data-sitekey="<?php echo $this->config->item('recaptcha2')['pub']; ?>" data-callback="submitLoginForm" class="g-recaptcha btn1 btn-7 btn-7a" style="padding: 11px 25px; margin: 0;"><?php echo $this->lang->line('login_btn'); ?></button>
									  <?php echo $this->lang->line('or'); ?> <a href="/auth/google/" title="<?php echo $this->lang->line('google_auth'); ?>"><img src="/static/index/google_login.png" alt="<?php echo $this->lang->line('google_auth'); ?>" style="width: 120px;" /></a>
								</div>

								<?php /*
								<div class="col-sm-8 legend">

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

									  <script src="https://apis.google.com/js/platform.js?hl=ru&onload=renderButton" async defer></script>
								</div>
								*/ ?>
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
 .capability h3, .capability p.lead {margin-left: 75px;}
</style>

<div class="wrap-content wrap-content1 capability">
	<div class="container">
				<div class="clearfix"></div>
				<h2 class="text-center"><?php echo $this->lang->line('features'); ?></h2>
		<div class="row">
			<div class="col-sm-6">
				<img src="/static/index/icon_view.png" width="60" alt="<?php echo $this->lang->line('view_alt'); ?>" />
				<h3><?php echo $this->lang->line('view_title'); ?></h3>
				<p class="lead"><?php echo $this->lang->line('view_desc'); ?></p>
				<div class="clearfix"></div>
			</div>
			<div class="col-sm-6">
				<img src="/static/index/icon_like.png" width="60" alt="<?php echo $this->lang->line('like_alt'); ?>" />
				<h3><?php echo $this->lang->line('like_title'); ?></h3>
				<p class="lead"><?php echo $this->lang->line('like_desc'); ?></p>
				<div class="clearfix"></div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6">
				<img src="/static/index/icon_comment.png" width="60" alt="<?php echo $this->lang->line('comment_alt'); ?>" />
				<h3><?php echo $this->lang->line('comment_title'); ?></h3>
				<p class="lead"><?php echo $this->lang->line('comment_desc'); ?></p>
				<div class="clearfix"></div>
			</div>
			<div class="col-sm-6">
				<img src="/static/index/icon_subscribe.png" width="60" alt="<?php echo $this->lang->line('subscribe_alt'); ?>" />
				<h3><?php echo $this->lang->line('subscribe_title'); ?></h3>
				<p class="lead"><?php echo $this->lang->line('subscribe_desc'); ?></p>
				<div class="clearfix"></div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6">
				<img src="/static/index/icon_replies.png" width="60" alt="<?php echo $this->lang->line('replies_alt'); ?>" />
				<h3><?php echo $this->lang->line('replies_title'); ?></h3>
				<p class="lead"><?php echo $this->lang->line('replies_desc'); ?></p>
				<div class="clearfix"></div>
			</div>
			<div class="col-sm-6">
				<img src="/static/index/icon_comment_like.png" width="60" alt="<?php echo $this->lang->line('comment_like_alt'); ?>" />
				<h3><?php echo $this->lang->line('comment_like_title'); ?></h3>
				<p class="lead"><?php echo $this->lang->line('comment_like_desc'); ?></p>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>




<div class="wrap-content wrap-gallery bg-1">
	<div class="container">
		<div class="clearfix"></div>
		<h2 class="text-center"><?php echo $this->lang->line('user_interface_title'); ?></h2>

		<div class="row">
			<div class="col-lg-12">

				<div class="gallery">
					<a href="/static/index/Screenshot_1.png" title="Настройки">
						<img src="/static/index/Screenshot_1.png" />
					</a>
					<a href="/static/index/Screenshot_2.png" title="Перевод средств">
						<img src="/static/index/Screenshot_2.png" />
					</a>
					<a href="/static/index/Screenshot_3.png" title="Добавление новой задачи">
						<img src="/static/index/Screenshot_3.png" />
					</a>
					<a href="/static/index/Screenshot_4.png">
						<img src="/static/index/Screenshot_4.png" />
					</a>
				</div>
		<div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>

<?php if(false) : ?>
<div class="wrap-content" style="background: url(/static/index/office.png); padding: 20px 0;">
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
<?php endif; ?>


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


<div class="wrap-content wrap-content1 wrap-signup bg-1">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 text-center">
				<a href="<?=site_url('auth/singup'); ?>" class="btn1 btn-8"><?php echo $this->lang->line('signup_now'); ?></a>
			</div>
		</div>
	</div>
</div>

<?php if(true) : ?>
<style>
	.wrap-counters {background:#fff; color: #1e1e1e; padding: 40px 0;}
	.wrap-counters .col-sm-3 {margin: 10px 0;}
	.wrap-counters .num {
		font-size: 25px;
	    /* display: block; */
	    font-weight: 200;
	    color: #fff;
	    background: #c2191e;
	    padding: 5px;
	    border-radius: 15px;
	}
	.wrap-counters .text {font-size: 20px; font-weight: 200; display: block;}
</style>
<div class="wrap-content wrap-content1 wrap-counters">
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
<?php endif; ?>


<?php if(false) : ?>
<div class="wrap-content wrap-contacts">
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
</div>
<?php endif; ?>

<footer>
	<div class="container">
		<div class="row">
			<div class="col-lg-12">

                <div class="yashare" style="text-align: center; margin-bottom: 15px;">
                    <div class="ya-share2" data-services="vkontakte,facebook,odnoklassniki,twitter,tumblr,viber,whatsapp,telegram"></div>
                </div>

                <style>
                footer p.links a, footer p.links span {
                	margin: 0 5px;
                }
                </style>
				<p class="links text-center">
					<a href="#login"><?php echo $this->lang->line('login'); ?></a>
					<a href="#about"><?php echo $this->lang->line('about_us'); ?></a>
					<span><?php echo $this->lang->line('contact_us'); ?>: support@ytuber.ru </span>
					<a href="/agreement.html" class="ajax-popup-link"><?php echo $this->lang->line('agreement'); ?></a>
					<a href="/policy.html" class="ajax-popup-link"><?php echo $this->lang->line('policy'); ?></a>
				</p>
				<p class="copyright text-center medium">
					&copy; 2013-<?=date('Y');?> <?php echo sprintf($this->lang->line('copyright'), site_url()); ?>
				</p>
			</div>
		</div>
	</div>
</footer>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="/static/bower/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="/static/js/index/main.js"></script>

<!-- Magnific Popup core CSS file -->
<link rel="stylesheet" href="/static/css/index/magnific-popup.css">
<!-- Magnific Popup core JS file -->
<script src="/static/js/index/jquery.magnific-popup.js"></script>


<script type="text/javascript">

    function getCookie(name) {
        var matches = document.cookie.match(new RegExp(
            "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
        ));
        return matches ? decodeURIComponent(matches[1]) : undefined;
    }

$(document).ready(function() {
    var date = new Date(new Date().getTime() + 60 * 1000 * 60 * 24 * 365 * 10);
    
    if(getCookie("language")){
        var lang = getCookie("language");
        $('.language select option[value='+lang+']').prop('selected', true);
    }else{
        var lang = $('.language').attr('data-select');
        document.cookie = "language="+lang+"; path=/; expires=" + date.toUTCString();
        $('.language select option[value='+lang+']').prop('selected', true);
    }

    $('.language select').on('change', function (e) {
        var lang = $("option:selected", this).val();
        document.cookie = "language="+lang+"; path=/; expires=" + date.toUTCString();
        location.reload();
    });

	$('.ajax-popup-link').magnificPopup({
	  type: 'ajax',
      	callbacks: {
            // wrap the ajax request with a div that we've styled to look good
            parseAjax: function (mfpResponse) {
                mfpResponse.data = "<div class='modal-content'>" + mfpResponse.data + "</div>";
            },
            ajaxContentAdded: function () {
                return this.content;
            }
        }
	});

	$('.gallery').magnificPopup({
		delegate: 'a',
		type: 'image',
		tLoading: 'Loading image #%curr%...',
		mainClass: 'mfp-img-mobile',
		gallery: {
			enabled: true,
			navigateByImgClick: true,
			preload: [0,1] // Will preload 0 - before current, and 1 after the current image
		},
		image: {
			tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
			titleSrc: function(item) {
				return item.el.attr('title') + '<small>ytuber.ru</small>';
			}
		}
	});
});

</script>


<script src='https://www.google.com/recaptcha/api.js'></script>
<script src="https://yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
<script src="https://yastatic.net/share2/share.js"></script>

<?php require_once('_analytics.php'); ?>
</body>
</html>
