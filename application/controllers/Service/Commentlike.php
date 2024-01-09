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
 * Description of Subscribe
 *
 * @author User
 */
class Commentlike extends Service {
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
    }

    /*
     * 
     */
    public function complete() 
    {
        while(true) {
            echo 'start'.PHP_EOL;
            sleep(5);
            $this->db->where('type_id', TASK_COMMENT_LIKE);
            $this->db->where('status',  COMPLETE_WAITING);
            //$this->db->where('time < ', time() - 60);// 30 сек (с момента выполнения)
            $query  = $this->db->get('done');

            foreach ($query->result() as $complete) 
            {
                //
                $this->setGoogleConfig($complete->domain);
                    
                // Переключатель
                $found = false;

                // выполнения по API подтверждаются автоматически
                if($complete->cost_rule == COST_API) 
                {
                    $found = true;
                }

                // Получаем задачу
                $task = $this->Task->getItem($complete->task_id);
                if(!$task) {
                    goto transfer;
                }

                $youtube = $this->Youtube->getRelevantCounter($task, true);

                if($youtube == -1) {
                    echo "target comment not found, task #{$task->id} disabled" . PHP_EOL;
                }
                else {
                    echo "target comment found, like count: {$youtube}".PHP_EOL;
                }

                if($youtube > $complete->data) {
                    $found = true;
                    goto transfer;
                }
				
				
                transfer:
                echo "call transfer method, found: {$found}".PHP_EOL;
                $this->transfer($complete->id, $found);
            }
        }
    }
}
