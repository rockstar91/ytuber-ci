<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Copyright 2017 User.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

require_once('Service.php');

/**
 * Description of Like
 *
 * @author User
 */
 
class UserPenalty extends Service {
    public function __construct() 
    {
        parent::__construct();
        $this->load->model('Task_Model', 'Task');
        $this->load->model('User_Model', 'User');
        $this->load->model('Transfer_Model', 'Transfer');
        $this->load->model('Complete_Model', 'Complete');
		$this->load->model('Youtube_Model', 'Youtube');
        $this->load->helper('yt');
        $this->load->helper('google');
        set_time_limit(0);
    }
	
		public function CurrentUserBan($currentuser){
		echo "ban user... " . $currentuser;
		$user_id = $currentuser;
        $this->_userBan($user_id, 86400 * 365 * 3, '2.8');
	}
	
	    function _userBan($user_id, $time, $reason, $tasksDisable = true)
    {
        $data = array(
            'banned' => time() + $time,
            'ban_reason' => $reason
        );
        $this->User->updateItem((int)$user_id, $data);

        if ($tasksDisable) {
            $this->db->where('user_id', (int)$user_id);
            $this->db->update('task', array('disabled' => 1));
        }
    }

    function _userUnban($user_id)
    {
        $data = array(
            'banned' => 0,
            'ban_reason' => ''
        );
        $this->User->updateItem((int)$user_id, $data);
    }
	
}