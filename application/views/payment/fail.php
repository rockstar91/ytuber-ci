<!DOCTYPE html>
<html lang="ru">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Платеж не совершен!</title>
	<style>
		body {background: #f8f8f8; font-family: Arial; margin: 0; padding: 0; color: #000; font-size: 13px;}
		.main {height: 400px; width: 450px; margin: 150px auto 0 auto; position: relative; background: #f8f8f8 url('/static/payment_bg_fail.jpg') bottom no-repeat;}
		h1 {font-size: 40px; margin: 15px 10px; line-height: 40px; color: red;}
		p {margin: 15px 10px; font-size: 13px;}
		a {color: #252525; text-decoration: underline;}
		a:hover {color: #CA2123; text-decoration: none;}
	</style>
	
	<?php require_once(APPPATH.'views/_head.php'); ?>
</head>
<body>
	<div class="main">
		<h1>Платеж не совершен!</h1>
		<p>Вы можете перейти в <a href="<?php echo site_url('payment/history'); ?>">историю платежей</a> или на <a href="<?php echo site_url('/'); ?>">главную страницу</a> сайта.</p>
		<p>Через <span id="counter">0</span> сек. вы будете автоматически перенаправлены в панель управления.</p>
	</div>
</body>
<script>
sec = 15;
timer = setInterval(function() {   
		document.getElementById('counter').innerHTML = sec;
		if(sec <= 0) {
			clearInterval(timer);
			window.location = '/task/index';
		}
		sec = sec - 1;
	}, 1000
);
</script>
</html>