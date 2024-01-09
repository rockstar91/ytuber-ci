<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('Api.php');

class Setting extends Api {

    function __construct() {
        parent::__construct();

        $this->load->model('Setting_Model', 'Setting');
    }

    function get($key=null) 
    {
        $this->output->json($this->Setting->get($key));
    }

}