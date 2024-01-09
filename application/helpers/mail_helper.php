<?php 
function mail_send($to, $subject, $message, $reply_to=null) {

	if(strpos($to, 'pages.plusgoogle.com') !== false) {
		return false;
	}

	$CI      =& get_instance();
	$config  = $CI->config->item('mail');

	$init = array(
		'useragent' => 'YT-Mailer',
		'mailtype'  => 'html'
	);
	/*
	$smtp = Array(
	    'protocol' => 'smtp',
	    'smtp_host' => 'ssl://smtp.yandex.ru',
	    'smtp_port' => 465,
	    'smtp_user' => 'robot@ytuber.ru',
	    'smtp_pass' => 'zx72wc',
	    'mailtype'  => 'html', 
	    'charset'   => 'utf-8'
	);
	$CI->load->library('email', $smtp);
	*/
	
	$CI->load->library('email', $init);

	//$CI->email->initialize(array('mailtype'=>'html'));

	$CI->email->from($config['from'], $config['from_name']);
	$CI->email->to($to); 
	
	if($reply_to) {
		$CI->email->reply_to($reply_to['mail'], $reply_to['name']);
	}

	$CI->email->subject($subject);
	$CI->email->message($message);

	return $CI->email->send();
}

function mail_send_tpl($to, $subject, $tpl, $data) {
	$CI =& get_instance();

	$language = $CI->config->item('language');
	if(is_file(APPPATH.'views/emails/'.$language.'/'.$tpl)) {
		$path = 'emails/'.$language.'/'.$tpl;
		//echo $path;
	}
	else {
		return false; 
	}

	$body = $CI->load->view($path, $data, true);
	//echo $body;
	return mail_send($to, $subject, $body);
}