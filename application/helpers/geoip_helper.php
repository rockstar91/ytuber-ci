<?php
function geoip($ip)
{

	$reader = new MaxMind\Db\Reader(APPPATH.'GeoLite2-City.mmdb');

	//$CI =& get_instance();
	//$CI->load->library('MaxMind\Db\Reader', APPPATH.'GeoLite2-City.mmdb', 'max_reader');
	$r = $reader->get($ip);

	$l = 'ru';

	$data = array(
		'continent_code' 	=> isset($r['continent']['code']) ? $r['continent']['code'] : false,
		'continent_name'	=> isset($r['continent']['names'][$l]) ? $r['continent']['names'][$l] : false,

		'country_code' 		=> isset($r['country']['iso_code']) ? $r['country']['iso_code'] : false,
		'country_name' 		=> isset($r['country']['names'][$l]) ? $r['country']['names'][$l] : false,

		'region_code'		=> isset($r['subdivisions'][0]['iso_code']) ? $r['subdivisions'][0]['iso_code'] : false,
		'region_name'		=> isset($r['subdivisions'][0]['names'][$l]) ? $r['subdivisions'][0]['names'][$l] : false,

		'city_name'			=> isset($r['city']['names'][$l]) ? $r['city']['names'][$l] : false,
		'time_zone'			=> isset($r['location']['time_zone']) ? $r['location']['time_zone'] : false,
	);
	return $data;//any IP
}
