<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php if(isset($pageTitle))  echo $pageTitle .' / '; ?><?php echo $this->config->item('sitename'); ?></title>

    <link rel="icon" type="image/png" href="/y.png" />

    <!-- Bootstrap Core CSS -->
    <link href="/static/bower/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="/static/bower/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="/static/bower/morrisjs/morris.css" rel="stylesheet">

    <!-- DataTables CSS 
    <link href="/static/bower/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">-->

    <!-- DataTables Responsive CSS 
    <link href="/static/bower/datatables-responsive/css/dataTables.responsive.css" rel="stylesheet">-->

    <!-- Custom CSS -->
    <link href="/static/css/sb-admin-2.css?v2" rel="stylesheet">
    <link href="/static/css/custom.css?v7" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="/static/bower/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <script src="/static/bower/jquery/dist/jquery.min.js"></script>


  <script src="https://www.google.com/recaptcha/api.js?render=<?php echo $this->config->item('recaptcha3')['pub']; ?>"></script>
  <script>
  grecaptcha.ready(function() {
      grecaptcha.execute('<?php echo $this->config->item('recaptcha3')['pub']; ?>', {action: 'panel'}).then(function(token) {
          fetch('/main/recaptcha_verify/?action=panel&token='+token).then(function(response) {
              response.json().then(function(data) {
                  console.log(data);
                  //document.querySelector('.response').innerHTML = JSON.stringify(data, null, 2);
                  //document.querySelector('.step3').classList.remove('hidden');
              });
          });
      });
  });
  </script>


    <script src='https://www.google.com/recaptcha/api.js'></script>

    <style>
    .grecaptcha-badge {display: none;}
    </style>

    <script type="text/javascript">
        var LANG_REMOVE_CONFIRM                     = '<?php echo $this->lang->line('js_remove_confirm'); ?>';
        var LANG_COMPLETE_TASK_AND_CLOSE_WINDOW     = '<?php echo $this->lang->line('js_complete_task_and_close_window'); ?>';
        var LANG_BROWSER_NOT_ACCEPTED               = '<?php echo $this->lang->line('js_browser_not_accepted'); ?>';
        var LANG_ALLOW_POPUP                        = '<?php echo $this->lang->line('js_allow_popup'); ?>';
    </script>
</head>
           
<?php $user_info = get_user(); ?>
<body>
    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?=site_url('dashboard');?>"><?php echo $this->lang->line('logo_text'); ?></a>
                <p class="navbar-desc"></p>
            </div>
            <!-- /.navbar-header -->


            <div class="navbar-header-right">
                <script type="text/javascript">
                function openClient() {
                    window.open("<?=site_url('client');?>", "ytuber_client", "toolbar=no, scrollbars=no, resizable=no, top=50, left=50, width=450, height=615");
                }
                </script>
                <div class="btn btn-success btn-sm" style="margin-right: 10px;" onclick="openClient();">
                    <?php echo $this->lang->line('tpl_open_client'); ?>
                    <i class="glyphicon glyphicon-new-window" style="margin-left: 3px;"></i>
                </div>
                <?php echo $this->lang->line('tpl_your_id'); ?> <b><?=$user_info->id;?></b>
            </div>

            <?php /*
            <ul class="nav navbar-top-links navbar-right">

                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Настройки</a>
                        </li>
                        <li><a href="<?=site_url('user/logout');?>"><i class="fa fa-sign-out fa-fw"></i> Выйти</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->
			*/ ?>

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
		            <div class="nav-profile">
		            	<div class="avatar">
                            <?php 
                                if(!empty($user_info->avatar)) {
                                    echo '<img src="'.$user_info->avatar.'" alt="" />';
                                }
                                else {
                                    echo '<i class="fa-user fa"></i>';
                                }
                            ?>
                        </div>
		            	<div class="info">
                            <style>
                            div.name > span {
                                display: block;
                                height: 24px;
                                width: 120px;
                                overflow: hidden;
                                float: left;
                            } 
                            div.name > .actions {
                                float: right;
                                height: 24px;
                            }
                            </style>
		            		<div class="name">
		            			<span title="<?=$user_info->name;?>"><?=mb_substr($user_info->name, 0, 13);?></span>

                                <div class="actions">
		            			<a href="<?=site_url('user/setting');?>" class="aLink fa fa-gear fa-fw" title="<?php echo $this->lang->line('tpl_settings'); ?>"></a>
		            			<a href="<?=site_url('auth/logout');?>" class="fa fa-sign-out fa-fw" title="<?php echo $this->lang->line('tpl_exit'); ?>"></a>
                                </div>
		            		</div>
		            		<div class="balance">
								<span id="user_balance"><?php printf("%.2f", $user_info->balance);?></span>
								<a href="<?=site_url('payment/start');?>" id="ym_pay" class="aLink fa fa-plus-circle fa-fw" style="color: #449d44; font-size: 13px; " title="<?php echo $this->lang->line('tpl_purchase'); ?>"></a>
							</div>
		            	</div>
		            </div>
                    <ul class="nav" id="side-menu">
                        <!--<li>
                            <a href="index.html"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li> -->
                        <li>
                            <a href="<?=site_url('dashboard');?>" class="aLink"><i class="fa fa fa-dashboard fa-fw"></i> <?php echo $this->lang->line('tpl_dashboard'); ?></a>
                        </li>
                        <li>
                            <a href="#" class="aLink"><i class="fa fa-video-camera fa-fw"></i> <?php echo $this->lang->line('tpl_my_tasks'); ?></a>
                             <ul class="nav nav-second-level collapse">
                                <li>
                                    <a href="<?=site_url('task/index');?>" class="aLink"><?php echo $this->lang->line('tpl_task_list'); ?></a>
                                </li>
                                <li>
                                    <a href="<?=site_url('task/add');?>" class="aLink"><?php echo $this->lang->line('tpl_add_task'); ?></a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#" class="aLink"><i class="fa fa-eye fa-fw"></i> <?php echo $this->lang->line('tpl_perform_tasks'); ?></a>
                             <ul class="nav nav-second-level collapse">
                                <?php if(false): ?>
                                <li>
                                    <a href="<?=site_url('work/view');?>" class="aLink"><?php echo $this->lang->line('tpl_view'); ?></a>
                                </li>
                                <?php endif; ?>
                                <li>
                                    <a href="<?=site_url('work/like');?>" class="aLink"><?php echo $this->lang->line('tpl_like'); ?></a>
                                </li>
                                <li>
                                    <a href="<?=site_url('work/comment');?>" class="aLink"><?php echo $this->lang->line('tpl_comment'); ?></a>
                                </li>
                                <li>
                                    <a href="<?=site_url('work/comment_like');?>" class="aLink"><?php echo $this->lang->line('tpl_comment_like'); ?> <sup style="color:red;">new</sup></a>
                                </li>
                                <li>
                                    <a href="<?=site_url('work/reply');?>" class="aLink"><?php echo $this->lang->line('tpl_reply'); ?> <sup style="color:red;">new</sup></a>
                                </li>
                                <li>
                                    <a href="<?=site_url('work/subscribe');?>" class="aLink"><?php echo $this->lang->line('tpl_subscribe'); ?></a>
                                </li>
                                <li>
                                    <a href="<?=site_url('work/vkshare');?>" class="aLink"><?php echo $this->lang->line('tpl_vkshare'); ?></a>
                                </li>
                                <li>
                                    <a href="<?=site_url('work/twittershare');?>" class="aLink"><?php echo $this->lang->line('tpl_twittershare'); ?></a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="<?=site_url('work/penalty');?>" class="aLink"><i class="fa fa-exclamation-circle fa-fw"></i> <?php echo $this->lang->line('tpl_penalty'); ?></a>
                        </li>
                        <li>
                            <a href="<?=site_url('user/referrals');?>" class="aLink"><i class="fa fa-users fa-fw"></i> <?php echo $this->lang->line('tpl_referrals'); ?></a>
                        </li>
                        <li>
                            <a href="<?=site_url('user/transaction');?>" class="aLink"><i class="glyphicon glyphicon-transfer fa-fw"></i> <?php echo $this->lang->line('tpl_transactions'); ?></a>
                        </li>
                        <li>
                            <a href="#" class="aLink"><i class="fa fa-rouble fa-fw"></i> <?php echo $this->lang->line('tpl_payments'); ?></a>
                        
                             <ul class="nav nav-second-level collapse">
                                <li>
                                    <a href="<?=site_url('payment/start');?>" class="aLink"><?php echo $this->lang->line('tpl_purchase'); ?><br/><small style="color: gray;">Yandex.Деньги, Visa, Mastercard, Webmoney WMR, Qiwi и д.р.</small></a>
                                </li>
                                <li>
                                    <a href="<?=site_url('payment/history');?>" class="aLink"><?php echo $this->lang->line('tpl_payments_history'); ?></a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="<?=site_url('info/faq');?>" class="aLink"><i class="fa fa-support fa-fw"></i> <?php echo $this->lang->line('tpl_faq'); ?></a>
                        </li>
                        <li>
                            <a href="<?=site_url('info/rules');?>" class="aLink"><i class="fa fa-book fa-fw"></i> <?php echo $this->lang->line('tpl_rules'); ?></a>
                        </li>
                        <?php if(isset($this->user->admin) && $this->user->admin) : ?>
                        <li>
                            <a href="<?=site_url('stat');?>" class="aLink"><i class="fa fa-bar-chart-o fa-fw"></i> <?php echo $this->lang->line('tpl_stat'); ?></a>
                        </li>
                        <li>
                            <a href="<?=site_url('admin');?>" class="aLink"><i class="fa fa-wrench fa-fw"></i> <?php echo $this->lang->line('tpl_admin'); ?></a>
                        </li>
                        <?php endif; ?>
			<?php if(false) : ?>
                        <li>
                            <a href="<?=site_url('promotion');?>"><i class="fa fa-bullhorn fa-fw"></i> <?php echo $this->lang->line('tpl_promotion'); ?></a>
                        </li>

                        <li>
                            <a href="<?=site_url('payout');?>"><i class="fa fa-money fa-fw"></i> <?php echo $this->lang->line('tpl_payout'); ?></a>
                        </li>
			<?php endif; ?>
                    </ul>

                    <div class="nav-share">
                        <?php $this->load->language('main'); ?>
                    	<h5><?php echo $this->lang->line('tpl_share'); ?></h5>


                        <script src="https://yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
                        <script src="https://yastatic.net/share2/share.js"></script>
                        <div class="ya-share2" data-yasharelink="<?php echo site_url();?>" data-services="vkontakte,facebook,twitter,tumblr,viber,whatsapp,telegram"></div>

                        <?php if(false) : ?>
						<script type="text/javascript" src="//yastatic.net/share/share.js" charset="utf-8"></script>
						<div class="yashare-auto-init" data-yasharelink="<?php echo site_url();?>" data-yasharetitle="<?php echo $this->lang->line('page_title'); ?>" data-yashareL10n="ru" data-yashareType="small" data-yasharetheme="counter" data-yashareQuickServices="vkontakte,facebook,moimir,odnoklassniki,gplus"></div>
						<?php endif; ?>

                        <hr/>
                    	<h5><?php echo $this->lang->line('tpl_ref_link'); ?></h5>
                    	<input type="text" class="form-control" name="url" value="<?php echo site_url($user_info->id);?>" onclick="this.select();" />
                    </div>

                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <!-- Page Content -->
        <div id="page-wrapper"> 
            <div class="content"><!-- container-fluid -->
                <div class="row">
                    <div class="col-lg-12">
                        <?php if(isset($pageTitle)) : ?>
                    	<h1 class="page-header"><?php echo $pageTitle; ?></h1>
                        <?php endif; ?>
						<?php if($success = $this->session->flashdata('success')) : ?>
							<div class="alert alert-success"><?php echo $success; ?></div>
						<?php endif;?>
						<?php if($error = $this->session->flashdata('error')) : ?>
							<div class="alert alert-danger"><?php echo $error; ?></div>
						<?php endif;?>

                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <?php echo $content; ?>
                <div class="row">
                    <div class="col-lg-12">
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="/static/js/jquery.confirm.min.js"></script>
    <script src="/static/js/history.min.js"></script>

    <!--<link rel="stylesheet" type="text/css" href="/static/js/noty-2.3.8/demo/animate.css"/>-->
    <script src="/static/js/noty-2.3.8/js/noty/packaged/jquery.noty.packaged.js"></script>
    <script src="/static/js/clipboard.min.js"></script>
    <script src="/static/js/custom_new.js?<?=time();?>"></script>
	
    <!-- Bootstrap Core JavaScript -->
    <script src="/static/bower/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="/static/bower/metisMenu/dist/metisMenu.min.js"></script>


    <!-- Morris Charts JavaScript -->
    <script src="/static/bower/raphael/raphael-min.js"></script>
    <script src="/static/bower/morrisjs/morris.min.js"></script>

    <!-- DataTables JavaScript 
    <script src="/static/bower/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="/static/bower/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>-->

    <!-- Custom Theme JavaScript -->
    <script src="/static/js/sb-admin-2.js?1"></script>    

    <!-- Page-Level Demo Scripts - Tables - Use for reference 
    <script>
    $(document).ready(function() {
        $('.dataTable').DataTable({
                responsive: true
        });
    });
    </script>-->

    <!-- Page-Level Demo Scripts - Notifications - Use for reference -->
    <script>
    // tooltip demo
    $('#page-wrapper').tooltip({
        selector: "[data-toggle=tooltip]",
        container: "body"
    })

    // popover demo
    //$("[data-toggle=popover]").popover()
    </script>

    
    <?php require_once(APPPATH.'views/_analytics.php'); ?>
</body>
</html>
