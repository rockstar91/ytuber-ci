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

    <!-- Custom CSS -->
    <link href="/static/css/sb-admin-2.css" rel="stylesheet">
    <link href="/static/css/custom.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="/static/bower/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script src='https://www.google.com/recaptcha/api.js'></script>

    <style>
    .grecaptcha-badge {display: none;}

    a.navbar-brand {    
        float: right;
        padding: 0;
        font-size: 16px;
        height: auto;
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <a class="navbar-brand" href="<?=site_url('/');?>"><?php echo $this->lang->line('logo_text'); ?></a>
                        <h3 class="panel-title"><?php echo $pageTitle; ?></h3>
                    </div>
                    <?php echo $content; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="/static/bower/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="/static/bower/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="/static/bower/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="/static/js/sb-admin-2.js"></script>


    <?php require_once('_analytics.php'); ?>
</body>
</html>