<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('Api.php');

class Complete extends Api {

 	public function __construct() 
 	{
            parent::__construct();
        
            if(!$this->user->admin) {
                die('No have permissions');
            }
 	}

 	// Получение неотмодерированных записей о выполнении 
 	function getWaiting($type_id=null) 
 	{
            $this->db->select('c.id as complete_id, c.time, c.action_cost, c.type_id, c.task_id, c.time, t.url as task_url, u.soc_vk, u.soc_twitter, u.channel');
            $this->db->from('done as c');
            $this->db->join('task as t', 'c.task_id = t.id', 'left');
            $this->db->join('user as u', 'c.user_id = u.id', 'left');
            
            $this->db->where('c.status', COMPLETE_WAITING);

            if($type_id) {
                    $this->db->where('c.type_id', (int)$type_id);
            }

            // задержка проверки
            $this->db->where('c.time <', time() - 120);

            $this->db->limit(100);

            //$this->db->order_by('c.account_id');
            $query = $this->db->get();

            $this->output->json($query->result());
 	}


 	// 
 	function setFinished($complete_id=null) 
 	{
            if($this->Transfer->completeToUser($complete_id)) {    
                echo $this->Complete->setStatus($complete_id, COMPLETE_FINISHED);
            }
 	}

 	function setFailed($complete_id=null) 
 	{
            $this->Transfer->completeToTask($complete_id);
            echo $this->Complete->setStatus($complete_id, COMPLETE_FAILED);
 	}

}
//

/* End of file task.php */
/* Location: ./application/controllers/task.php */