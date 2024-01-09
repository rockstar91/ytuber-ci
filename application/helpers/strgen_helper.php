<?php 
function strgen($len=8, $chars='qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP0123456789')
{
	$size=strlen($chars)-1; 
	$str=null; 
	
    while($len--) 
		$str.=$chars[rand(0,$size)]; 
	
	return $str;
}