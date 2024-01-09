<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

ini_set('memory_limit','256M');

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
class Subscribe extends Service {
    public function __construct() 
    {
        parent::__construct();
        $this->load->model('Task_Model', 'Task');
        $this->load->model('User_Model', 'User');
        $this->load->model('Transfer_Model', 'Transfer');
        $this->load->model('Complete_Model', 'Complete');
        $this->load->helper('yt');
        $this->load->helper('google');
    }

    function _mail_subscribe_penalty($user, $task, $done)
    {
        $this->load->helper('mail');
        $text   = "ID: {$task->id}<br/>\r\n";
        $text  .= "Ссылка: {$task->url}<br/><br/>\r\n\r\n";
        $text  .= "Вы были оштрафованы на {$done->action_cost} балл(а/ов), так как отписались от указаного выше канала.<br/>\r\n";

        mail_send($user->mail, 'Штраф: Отписка от канала', $text);
    }

    function _mail_subscribe_cancel_penalty($user, $task, $done)
    {
        $this->load->helper('mail');
        $text   = "ID: {$task->id}<br/>\r\n";
        $text  .= "Ссылка: {$task->url}<br/><br/>\r\n\r\n";
        $text  .= "Штраф по задаче был отменен, вам были возвращены {$done->action_cost} балл(а/ов).<br/>\r\n";

        mail_send($user->mail, 'Отмена штрафа', $text);
    }

    private function updateComplete($complete_id, $status=null, $increase_check_count=null)
    {
        $this->db->where('id', (int)$complete_id);

        if($status) {
            $this->db->set('status', (int)$status);
        }

        if($increase_check_count)
        {
            $this->db->set('check_count', 'check_count+1', false);
            $this->db->set('check_time', time());
        }

        $this->db->update('done');

        return $this->db->affected_rows();
    }

		private function getCurrentItems($mytask)
    {
        $this->db->where('type_id', TASK_SUBSCRIBE);
        $this->db->where('task_id', $mytask);

        if($this->input->get('task_id'))
        {
            $this->db->where('task_id', (int) $this->input->get('task_id'));
        }
        else if($this->input->get('user_id'))
        {
            $this->db->where('user_id', (int) $this->input->get('user_id'));
        }
        else
        {
            $this->db->where('time > ', time() - (60 * 60 * 24 * 60)); 	// 30 дней (с момента выполнения)
            //$this->db->where('time < ', time() - (60 * 60 * 24)); 		// 24 часа (с момента выполнения)
            //$this->db->where('check_time < ', time() - (60 * 60 * 24)); // 24 часа (с момента последней проверки)
        }

        $this->db->order_by('time', 'ASK');
        $this->db->limit(2000);
        $query  = $this->db->get('done');

        return $query->result();
    }

    private function getItems()
    {
        $this->db->where('type_id', TASK_SUBSCRIBE);
        $this->db->where_in('status', array(COMPLETE_FINISHED, COMPLETE_PENALTY));

        if($this->input->get('task_id'))
        {
            $this->db->where('task_id', (int) $this->input->get('task_id'));
        }
        else if($this->input->get('user_id'))
        {
            $this->db->where('user_id', (int) $this->input->get('user_id'));
        }
        else
        {
            $this->db->where('time > ', time() - (60 * 60 * 24 * 30)); 	// 30 дней (с момента выполнения)
            $this->db->where('time < ', time() - (60 * 60 * 24)); 		// 24 часа (с момента выполнения)
            $this->db->where('check_time < ', time() - (60 * 60 * 24)); // 24 часа (с момента последней проверки)
        }

        $this->db->order_by('time', 'ASK');
        $this->db->limit(2000);
        $query  = $this->db->get('done');

        return $query->result();
    }

    function penalty()
    {
        $start_time = time();

        $items = $this->getItems();

        foreach($items as $k=>$done) {

            $this->setGoogleConfig($done->domain);

            echo "---\r\n";
            echo "done number:{$k}\r\n";
            //echo "penalty status:".$done->penalty."\r\n";
            echo "done id:".$done->id."\r\n";
            echo "done time:".date('Y-m-d H:i', $done->time)."\r\n";

            $subscribed = false;
            $continue = false;

            // определяем цену, если она не задана
            $done->action_cost = $done->action_cost;

            // обновляем время и количество проверок для метки
            $this->updateComplete($done->id, null, true);

            // получаем задачу
            $task = $this->Task->getItem($done->task_id);
            if(!$task) {
                echo "task not found, continue\r\n";
                continue;
            }
            echo "task id:".$task->id."\r\n";

            // Получение id канала задачи
            $channel = yt_channel($task->url);
            echo "task channel id:".$channel."\r\n";

            // получаем пользователя
            $user = $this->User->getItem($done->user_id);
            if(!$user) {
                echo "user not found, continue\r\n";
                continue;
            }
            echo "user id:".$user->id."\r\n";

            // Получаем авторизацию от пользователя
            $yt = google_auth_youtube($user, false);
            if(!$yt) {
                echo "no user auth\r\n";
                $continue = true;
                //continue;
            }

            //Проверяем квоту
            if (strpos($yt, 'quotas') !== false) {
                break;
            }
            // Получение канала пользователя
            if(!$continue) {
                if(empty($user->channel)) {
                    try {
                        $listChannels = $yt->channels->listChannels('contentDetails', array(
                            'mine' => true
                        ));
                        $user->channel = $listChannels->getItems()[0]->getId();
                    }
                    catch(Exception $e) {}

                    if(!empty($user->channel)) {
                        $this->User->updateItem($user->id, array('channel' => $user->channel));
                    }
                }
                echo "user channel id:".$user->channel."\r\n";
            }


            // проверяем подписку от подписавшегося
            if(!$continue) {

                // проверка доступности канала
                echo "check channel available...\r\n";
                $dev = google_youtube_developer();
                try {
                    $listChannels = $dev->channels->listChannels('statistics', array('id' => $channel));
                    // если нет канала
                    if($listChannels->getPageInfo()->getTotalResults() === 0) {
                        echo "channel not found, continue\r\n";
                        continue;
                    }
                    foreach($listChannels->getItems() as $k=>$item) {
                        if($item->getStatistics()->subscriberCount > 0) {
                            echo $item->getStatistics()->subscriberCount . " subscribers \r\n";
                        }
                    }
                }
                catch(Exception $e) {
                    echo "channel not found, continue\r\n";
                    continue;
                }

                // проверка подписки от пользователя
                echo "check from user...\r\n";
                try {
                    $listSubscriptions = $yt->subscriptions->listSubscriptions('snippet', array(
                        'mine' => true,
                        'forChannelId' => $channel
                    ));

                    $items = $listSubscriptions->getItems();

                    foreach($items as $item) {
                        if($item->getSnippet()->getResourceId()->channelId == $channel) {
							echo "Subscribed channel " . $item->getSnippet()->getResourceId()->channelId . "\r\n";
                            $subscribed = true;
                            echo "subscribe found from user\r\n";
                            break; // break foreach
                        }
                    }
                }
                catch(Exception $e) {
                    echo "check from user failed, continue\r\n";
                    continue;
                }
            }

            echo "subscribed:".(int)$subscribed."\r\n";


            // снимаем штраф, возвращаем баллы
            if($subscribed && $done->status == COMPLETE_PENALTY) {
                // обновляем метку
                $this->updateComplete($done->id, COMPLETE_FINISHED);

                // обновляем задачу
                if($task->total_cost >= $done->action_cost) {
                    $this->db->where('id', $task->id);
                    $this->db->set('action_fail', 'action_fail-1', false);
                    $this->db->set('total_cost', 'total_cost-'.$done->action_cost, false);
                    $this->db->update('task');
                }

                // отправляем уведомление
                if($user->sub_notification && empty($user->confirm))
                    $this->_mail_subscribe_cancel_penalty($user, $task, $done);

                // возвращаем баллы пользователю
                $this->User->increaseBalance($user->id, $done->action_cost);

                echo "COMPLETE: cancel penalty\r\n";
            }
            else if(!$this->input->get('debug') && !$subscribed && $done->status == COMPLETE_FINISHED && $this->User->decreaseBalance($user->id, $done->action_cost, false)) {

                // отправляем уведомление
                if($user->sub_notification && empty($user->confirm))
                    $this->_mail_subscribe_penalty($user, $task, $done);

                // обновляем метку
                $this->updateComplete($done->id, COMPLETE_PENALTY);

                // обновляем задачу
                $this->db->where('id', $task->id);
                $this->db->set('action_fail', 'action_fail+1', false);
                $this->db->set('total_cost', 'total_cost+'.$done->action_cost, false);
                $this->db->update('task');

                // Нотификации
                $noty = array(
                    'user_id'       => $user->id,
                    'task_id'       => $task->id,
                    'task_type_id'  => $task->type_id,
                    'data'			=> $channel,
                    'cost'          => $done->action_cost,
                    'type'          => NOTY_PENALTY_TASK
                );

                $this->Notification->addItem($noty);

                echo "COMPLETE: penalty\r\n";
            }
        }

        $execution_time = time()-$start_time;

        echo "#END, execution time: {$execution_time} sec\r\n";
    }

    /*
     * 
     */
    public function complete() 
    {
        while(true) {
            sleep(5);
            
            $this->db->where('type_id', TASK_SUBSCRIBE);
            $this->db->where('status',  COMPLETE_WAITING);
            $this->db->where('time < ', time() - 30);// 30 сек (с момента выполнения)
            $this->db->where('time > ', time() - 3600);// 30 сек (с момента выполнения)
            $query  = $this->db->get('done');

            foreach ($query->result() as $complete) 
            {
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

                // Получаем пользователя 
                $user = $this->User->getItem($complete->user_id);

                // Получаем авторизацию от пользователя
                $yt = google_auth_youtube($user, false);

                // Получаем канал
                $channel = yt_channel($task->url);

                if($task && $user && $yt && $channel) {
                    // Проверка от пользователя
                    try {
                        $listSubscriptions = $yt->subscriptions->listSubscriptions('snippet', array(
                            'mine' => true,
                            'forChannelId' => $channel
                        ));

                        $items = $listSubscriptions->getItems();

                        foreach($items as $item) {
                            if($item->getSnippet()->getResourceId()->channelId == $channel) {
                                $found = true;
                                break;
                            }
                        }
                    }
                    catch(Exception $e) {
                        //print_r($e->getMessage());
                    }
                }

                $this->transfer($complete->id, $found);
            }
        }

    }
}
