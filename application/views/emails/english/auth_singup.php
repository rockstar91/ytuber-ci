Поздравляем с регистрацией, <?php echo $name; ?>!<br/><br/>
Ваш логин: <?php echo $mail; ?><br/>
Ваш пароль: <?php echo $password; ?><br/><br/>
<?php 
if(isset($confirm) && !empty($confirm)) {
	echo "Ссылка для подтвержения email: ".anchor('auth/confirm/?id='.$id.'&code='.$confirm)."<br/><br/>\r\n";
	echo "Подтвердив email, вы получите 25 бонусных баллов по мере выполнения первых 50-ти заданий.";
}
?>