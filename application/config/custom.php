<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


// Base
$config['sitename']    = 'YTuber';
$config['description'] = 'YTuber';

// Pagination
$config['pagination'] =  array(
	'per_page' 		  => 12,
	'num_links'		  => 4,
	'first_link'	  => 'Первая',
	'last_link'		  => 'Последняя',
	'full_tag_open'   => '<ul class="pagination">',
	'full_tag_close'  => '</ul>',
	'first_tag_open'  => '<li class="paginate_button">',
	'first_tag_close' => '</li>',
	'prev_tag_open'   => '<li class="paginate_button previous">',
	'prev_tag_close'  => '</li>',
	'cur_tag_open'    => '<li class="paginate_button active"><a>',
	'cur_tag_close'   => '</a></li>',
	'next_tag_open'   => '<li class="paginate_button">',
	'next_tag_close'  => '</li>',
	'last_tag_open'   => '<li class="paginate_button">',
	'last_tag_close'  => '</li>',
	'num_tag_open'    => '<li class="paginate_button">',
	'num_tag_close'   => '</li>'
);

// Google API
/*$config['google'] = array(
	'client_id'     => '1049057798715-g7l155abp2vr631mr2tpiicdqot9t5ni.apps.googleusercontent.com',
	'client_secret' => 'MBm6jkydnjsEPLFxt8OHsIFw',
	'redirect_uri'	=> 'https://ytuber.ru/auth/google',
	'developer_key' => 'AIzaSyCZ-DOCr20LHyEVzcl5ehC6q6-kAWu9CSM',
	'recaptcha_pub' => '6LeTFAwTAAAAAP8hGZQxSHKqua2fy5FyUhEgCTQW',
	'recaptcha_pri' => '6LeTFAwTAAAAAPboYkJUNf1GIBn9ulhwspOSA9fT'
);*/

/* Payment W1 */
$config['w1']['merchantUrl']                = 'https://wl.walletone.com/checkout/checkout/Index';
$config['w1']['merchantId']                 = 189512087175;
$config['w1']['merchantPrivateKey']         = '45327a35795a385467324551744c34416d66604c7578755861355e';

/* Payment Yandex */
$config['yandex']['merchantUrl']            = 'https://yoomoney.ru/quickpay/confirm.xml';
//$config['yandex']['merchantId']             = '41001702799594';
$config['yandex']['merchantId']             = '410013992606555'; // vladimir '410019870411990';
//$config['yandex']['merchantPrivateKey']     = '5m4//uEhMuaHhZitH/etyQuW';
$config['yandex']['merchantPrivateKey']     = 'fXhwaBHnjlRAzpv3+E5H9tTa'; // vladimir 'tBpwIzP7I79sd2CkYWVPChWm';

/* Payment Webmoney */
$config['webmoney']['merchantUrl']          = 'https://merchant.webmoney.ru/lmi/payment.asp';
$config['webmoney']['merchantId']           = 'Z376081103153';
$config['webmoney']['merchantPrivateKey']   = 'AmDPfH6sU36U9E33649neuh7RvfDu4Uk';//'345tersdft345afSADW543}WERL>we435';

/* Payment UnitPay*/
$config['unitpay']['merchantUrl']          = 'https://unitpay.ru/pay/';
$config['unitpay']['merchantId']           = '166961-05b8b'; // public key
$config['unitpay']['merchantPrivateKey']   = '10df59452feebb8000458af1d0df1da2'; //secret key

$config['recaptcha2']['pub'] 		= '6Lev7ncUAAAAAFhusPfyNLnRS7SKfrchfvieGtEz';
$config['recaptcha2']['secret'] 	= '6Lev7ncUAAAAANFW9IF2en3D-Frno4MAtPTrAOvv';

//$config['recaptcha2']['pub'] 		= '6LfoVJkUAAAAABbFJshLKGReon2-5-QtBh8Pmx_h';
//$config['recaptcha2']['secret'] 	= '6LfoVJkUAAAAAKRsdi5RRgAwRJ-8NsyE344g5OAf';

//$config['recaptcha3']['pub'] 		= '6Lf68XcUAAAAAIn8ehzK5NEA4RVXFeVMnzJAx-ZO';
//$config['recaptcha3']['secret'] 	= '6Lf68XcUAAAAADTUUPc4COQXHWwR6pvnKDco2TjK';

$config['recaptcha3']['pub']     = '6LeZU5kUAAAAAJNTaLhXx74OnTC4ROzxBUqQ-WCg';
$config['recaptcha3']['secret']   = '6LeZU5kUAAAAAHYWGOvt5_ihDNfP4OVX9ZCrvNs_';

$config['google_api'] = array(
    DOMAIN_YTUBER => array(
  'client_id'     => '1049057798715-g7l155abp2vr631mr2tpiicdqot9t5ni.apps.googleusercontent.com',
  'client_secret' => 'MBm6jkydnjsEPLFxt8OHsIFw',
  'redirect_uri'  => 'https://ytuber.ru/auth/google',
  'developer_key' => 'AIzaSyBOED4gtX_l14emzOonoAaWcXHVcADTnHw',
  'recaptcha_pub' => '6LeTFAwTAAAAAP8hGZQxSHKqua2fy5FyUhEgCTQW',
  'recaptcha_pri' => '6LeTFAwTAAAAAPboYkJUNf1GIBn9ulhwspOSA9fT'
    ),
    DOMAIN_YTUBEY => array(
        'client_id'  => '379242296043-jv3dek3mjokt5sr9420rju31iqmrg7g9.apps.googleusercontent.com',
        'client_secret' => '84HJPJIfe8imTGByFizm1eSk',
        'redirect_uri'  => 'https://ytubey.com/auth/google',
        'developer_key' => 'AIzaSyBcTh-47d--TBT5YAPtRYbe5D4uxYBkQt0',
        'recaptcha_pub' => '6LeTFAwTAAAAAP8hGZQxSHKqua2fy5FyUhEgCTQW',
        'recaptcha_pri' => '6LeTFAwTAAAAAPboYkJUNf1GIBn9ulhwspOSA9fT'
    )
);

$config['google'] = $config['google_api'][DOMAIN_YTUBER];

// Почта
$config['mail'] = array(
	'admin_mail' => 'lukyanov@webistan.ru, support@ytuber.ru',
	'from'		 => 'robot@ytuber.ru',
	'from_name'  => 'YTuber - обмен просмотрами на YouTube'
);


// Цены
$config['cost_rules'] = array(
	COST_BASE => array(
		'user' 		=> 0.70,
		'referrer'	=> 0.10,
		'system'	=> 0.20
	),
	COST_AJAX => array(
		'user' 		=> 0.45,
		'referrer'	=> 0.05,
		'system'	=> 0.50
	),
	COST_ADBLOCK => array(
		'user' 		=> 0.10,
		'referrer'	=> 0,
		'system'	=> 0.90
	),
	COST_PENALTY => array(
		'user' 		=> 0.05,
		'referrer'	=> 0,
		'system'	=> 0.95
	),
	COST_API => array(
		'user' 		=> 0.70,
		'referrer'	=> 0.05,
		'system'	=> 0.25
	)
);

if(isset($_COOKIE['language'])) {
	switch ($_COOKIE['language']) {
		case 'ru':
			$config['language'] = 'russian';
			break;

		case 'en':
			$config['language'] = 'english';
		
		default:
			break;
	}
}

$http_host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'ytuber.ru';

if($http_host == 'api.ytuber.ru') {
	$config['disable_controllers'] = array(
		'main',
		'auth',
		'dashboard'
	);
}

if(in_array($http_host, array('ytubey.com', 'ytuber.com')))
{
	define('CURRENT_DOMAIN', DOMAIN_YTUBEY);
	// Язык
	$config['language']	= 'english';

	$config['pagination']['first_link'] = 'First';
	$config['pagination']['last_link']  = 'Last';
}
else
{
	define('CURRENT_DOMAIN', DOMAIN_YTUBER);
	setlocale(LC_TIME, 'ru_RU.utf8');
}
