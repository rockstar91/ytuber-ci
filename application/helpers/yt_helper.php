<?php 

function yt_time($url) {
	preg_match('#\?t=([a-z0-9-_]{2,8})$#', $url, $match);
	return isset($match[1]) ? $match[1] : false;
}

function yt_vid($url) {
	preg_match('#(\?v=|\/)([^\/\?&]{11})(\?|\&|$)#u', $url, $match);
	return isset($match[2]) ? $match[2] : false;
} //https://www.youtube.com/watch?v=roARTeintBg&t=249s

function yt_channel($url) {
	preg_match('#([^\/\?&]{24})(\?|$)#u', $url, $match);
	return isset($match[1]) ? $match[1] : false;
}

function yt_curl_get($link) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $link);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
	curl_setopt($ch, CURLOPT_USERAGENT, 'PHP Bot');
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	$data = curl_exec($ch);
	curl_close($ch);
	
	return $data;
}

function yt_api_get($link) {
	$CI      =& get_instance();
	$config  = $CI->config->item('google');
	$dev_key = $config['developer_key'];
	return json_decode(yt_curl_get($link.'&key='.$dev_key));
}


function yt_decl($digit,$expr,$onlyword=true) 
    {
        if(!is_array($expr)) $expr = array_filter(explode(' ', $expr));
        if(empty($expr[2])) $expr[2]=$expr[1];
        $i=preg_replace('/[^0-9]+/s','',$digit)%100;
        if($onlyword) $digit='';
        if($i>=5 && $i<=20) $res=$digit.' '.$expr[2];
        else
        {
            $i%=10;
            if($i==1) $res=$digit.' '.$expr[0];
            elseif($i>=2 && $i<=4) $res=$digit.' '.$expr[1];
            else $res=$digit.' '.$expr[2];
        }
        return trim($res);
}

function yt_cost($cost, $type=null, $cost_rule=COST_BASE) 
{
	$CI      =& get_instance();
	//$config  = $CI->config->item($item);
    $config  = $CI->config->item($cost_rule, 'cost_rules');

	if(isset($config[$type]))
		$cost = $cost * $config[$type];

	return sprintf('%.2f', $cost);
}

function yt_cost_format($cost, $type=null, $cost_rule=COST_BASE) 
{
	$CI      =& get_instance();
	$arr = $CI->lang->line('yt_cost_format');

	$cost = yt_cost($cost, $type, $cost_rule);
	return sprintf('%.2f', $cost).' '.yt_decl(substr($cost, -1), $arr);
}

function yt_comment_split($text) {
	return array_map('trim', preg_split('#[\r\n]+#', trim($text)));
}

function yt_comment_cycle($text, $done) {
	$done = (int) $done;
	$exp = yt_comment_split($text); 
	$count = count($exp)-1;
	
	if($count <= 0) {
		return $exp[0];
	}
	else if($done > $count) {
		$n = $done - (ceil($done / $count) - 1) * $count;
		return $exp[$n-1];
	}
	else {
		return $exp[$done];
	}
}

function yt_rand_comment($text) {
	$exp = yt_comment_split($text); 
	return $exp[mt_rand(0, count($exp)-1)];
}

function yt_gplus_id($link) {
	preg_match('#\/(\d+)$#', $link, $match);
	return isset($match[1]) ? $match[1] : null;
}