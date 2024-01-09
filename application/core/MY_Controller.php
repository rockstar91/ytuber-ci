<?php
class MY_Controller extends CI_Controller  {
    
    // Авторизация по api 
    function _api_login($allowedMethods = array()) {
        if(!in_array($this->router->fetch_method(), $allowedMethods))
        {
            return false;
        }

        $api_key = trim($this->input->get('api_key'));
        
        if(!empty($api_key)) 
        {
            $user = $this->User->getItemBy('api_key', $api_key);
            if($user) 
            {
                $this->user = $user;
            }
        }
    }

}