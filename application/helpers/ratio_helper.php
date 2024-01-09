<?php 

function ratio_channel_age($x) {
	if($x < 30) {
		return -1;
	}
	else if($x < 1095) {
		return $x / 1095;
	}
	else {
		return 1;
	}
}

function ratio_done_day($x) {
	$result = log1p($x/120) / 2.8;
	return $result;
	return ($result < 1) ? $result : 1;
}

function ratio_done_total($x) {
	//return cos($x/100) ;
	$result = log1p($x/100) / 10;
	return $result;
	return ($result < 1) ? $result : 1;
}

function ratio_active_referrals($x) {
	$result = log1p($x/20) / 5;
	return $result;
	return ($result < 1) ? $result : 1;
}

function ratio($user) {
	$CI =& get_instance();

	// Количество активных рефералов, привлеченных пользователем
	$total = $CI->User->getActiveReferralsTotal($user->id);
	$activeReferrals = ratio_active_referrals($total);         

	// Общее количество выполненных задач
	$doneTotal       = ratio_done_total($user->done);  

	// Кол-во выполненных задач за день 
	$doneDay         = ratio_done_day($user->done_day);  

	// Возраст YouTube канала пользователя в днях
	if($user->channel_published > 0) {
		$age = time() - strtotime($user->channel_published);
		$age = intval($age / 86400);
		echo "$age - channel days({$user->channel_published})<br>";
	}
	else {
		$age = 0;
	}
	$channelDays     = ratio_channel_age($age);  

	echo "$activeReferrals - activeReferrals<br>";
	echo "$doneTotal - doneTotal<br>";
	echo "$doneDay - doneDay<br>";
	echo "$channelDays - channelDays<br>";

	// Сумма всех показателей
	$sum = $activeReferrals+$doneTotal+$doneDay+$channelDays;
	$sum = $sum / 4;

	//$sum = $sum * 0.5 + 0.5;

	$prc = $sum * 100; 

	//echo "<div style='height: 10px; background: red; width: {$prc}%;'></div>";

	echo "$sum - sum rating<br/>";

}