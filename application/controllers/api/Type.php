<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('Api.php');

class Type extends Api {

 	public function __construct() 
 	{
        parent::__construct();

 		if(!$this->user->admin) {
 			die('No have permissions');
 		}
 	}

 	function getList() 
 	{
 		$this->db->select('id, name, hour_limit, window_pattern');
        $query = $this->db->get('type');
		$this->output->json($query->result());
 	}
 	
}
//

/* End of file task.php */
/* Location: ./application/controllers/task.php */