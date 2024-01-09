<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api extends CI_Controller {
    public  $user = null;

    public function __construct() 
    {
        parent::__construct();

        $this->load->model('User_Model', 'User');
        $this->load->model('Task_Model', 'Task');
        $this->load->model('Transfer_Model', 'Transfer');
        $this->load->model('Complete_Model', 'Complete');

        header("Access-Control-Allow-Headers: Content-Type");
        header("Access-Control-Allow-Origin: *");

        $this->_api_login();

        if(!$this->user) {
            $this->output->json(array('error' => 'User not found'));
        }
    }

    function _api_login() {
        $api_key = trim($this->input->get('api_key'));
        if(!empty($api_key)) {
            $user = $this->User->getItemBy('api_key', $api_key);
            if($user) {
                $this->user = $user;
            }
        }
    }
}