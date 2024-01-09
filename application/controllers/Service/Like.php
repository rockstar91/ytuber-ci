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
class Like extends Service {
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
    
    /*
     * 
     */

	
    public function complete() 
    {
        while(true)
        {
            sleep(5);
            $this->db->where('type_id', TASK_LIKE);
            $this->db->where('status',  COMPLETE_WAITING);
            //$this->db->where('time < ', time() - 600);// 30 сек (с момента выполнения)
            $query  = $this->db->get('done');

            foreach ($query->result() as $complete) 
            {
                echo $complete->id.PHP_EOL;
                
                // исправляем 0 на DOMAIN_YTUBER
                $complete->domain = $complete->domain <= 0 ? DOMAIN_YTUBER : $complete->domain;
                // выбираем конфиг
                $config = $this->config->item('google_api');
                $this->config->set_item('google', $config[$complete->domain]);
                
                // Переключатель
                $found = false; 

                // Получаем задачу
                $task = $this->Task->getItem($complete->task_id);
				
                // Получаем пользователя 
                $user = $this->User->getItem($complete->user_id);
				
                // Получаем авторизацию от пользователя
                $yt = google_auth_youtube($user, false);
				
                // Получаем video id
                $vid = yt_vid($task->url);
				
				//echo "video_id = " . $vid;
				
                // тип лайка
                $rating = 'like';
				try{
                if(isset($task->extend['type']) && $task->extend['type'] == 2) {
                    $rating = 'dislike';
                } 
				}
				catch(Exception $e){}

                if($task && $user && $yt && $vid) {
					echo "Проверка запущена... \r\n";
					echo "task_id: " . $complete->task_id;
					echo "\r\n";
                    // Проверка от пользователя
                    try {
                        // проверяем лайк
                        $res = $yt->videos->getRating($vid);

                        foreach($res->getItems() as $item) {
							
                            if($item->rating == $rating && $item->videoId == $vid) {
							echo "Like found for user_id ". $complete->user_id;
							echo "\r\n";
                                $found = true;
                                break;
                            }
							if($item->rating == 'none'){
							echo "Рейтинг: " . $item->rating;
							echo "\r\n";
							echo "Not found like for user_id " . $complete->user_id . " ";
							echo "\r\n";
							//Print_r($res);
							}
							else{
							echo "this rating: " . $item->rating;
							echo "\r\n";
							}
                        }
                    }
                    catch(Exception $e) {
						
                         $errors = $e->getErrors();
						 
						 if(isset($errors[0]['reason'])){
							 echo "Ошибка: " . $errors[0]['reason'] . "\r\n";
						 }
						 if($errors[0]['reason'] == "videoNotFound"){
							 $this->Task->updateItem($task->user_id, $task->id, array('disabled' => 1));
						 }
                    }
                }

                $this->transfer($complete->id, $found);
            }
        }
    }
}
