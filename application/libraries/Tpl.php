<?php
class Tpl  {
    public function load($views='', $data='', $return=false, $layout='layout')
    {
    	$CI = &get_instance();
        $data['content'] = $CI->load->view($views, $data, true);
        return $CI->load->view($layout, $data, $return);
    }
}