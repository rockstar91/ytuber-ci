<?php 

//function recaptcha_secret() {
//  return '6LeTFAwTAAAAAPboYkJUNf1GIBn9ulhwspOSA9fT';
//}

function recaptcha_pub() {
    $CI =& get_instance();
    return $CI->config->item('recaptcha2')['pub'];
    //return '6LeTFAwTAAAAAP8hGZQxSHKqua2fy5FyUhEgCTQW';
}

function recaptcha_verify($config = false) {
    $CI =& get_instance();

    $postdata = http_build_query(
        array(
            'secret'    => isset($config['secret']) ?  $config['secret'] : $CI->config->item('recaptcha2')['secret'],
            'response'  => isset($_POST['g-recaptcha-response']) ? $_POST['g-recaptcha-response'] : false
        )
    );

    $opts = array('http' =>
        array(
            'method'  => 'POST',
            'header'  => 'Content-type: application/x-www-form-urlencoded',
            'content' => $postdata
        )
    );

    $context = stream_context_create($opts);

    $result = file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, $context);

    $result = json_decode($result);

    return $result->success;
}
