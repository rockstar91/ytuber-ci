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
class View extends Service {
    public function __construct() 
    {
        parent::__construct();
        $this->load->model('Task_Model', 'Task');
        $this->load->model('User_Model', 'User');
        $this->load->model('Transfer_Model', 'Transfer');
        $this->load->model('Complete_Model', 'Complete');
        $this->load->helper('yt');
        $this->load->helper('google');
        set_time_limit(0);
    }
    
    /*
     * 
     */
    public function complete() 
    {
        while(true)
        {
            sleep(5);
            $this->db->where('type_id', TASK_VIEW);
            $this->db->where('status',  COMPLETE_WAITING);
            //$this->db->where('time < ', time() - 3600);// 3 сек (с момента выполнения)
            $this->db->limit(1000);
            $query  = $this->db->get('done');

            foreach ($query->result() as $complete) 
            {
                // исправляем 0 на DOMAIN_YTUBER
                $complete->domain = $complete->domain <= 0 ? DOMAIN_YTUBER : $complete->domain;
                // выбираем конфиг
                $config = $this->config->item('google_api');
                $this->config->set_item('google', $config[$complete->domain]);
                
                // Переключатель
                $found = false; 

                // Получаем задачу
                //$task = $this->Task->getItem($complete->task_id);

                // Получаем пользователя 
                //$user = $this->User->getItem($complete->user_id);

                // Получаем авторизацию от пользователя
                // $yt = google_auth_youtube($user, false);

                // Получаем video id
                //$vid = yt_vid($task->url);

                $this->transfer($complete->id, $found);
            }
        }
    }
}
