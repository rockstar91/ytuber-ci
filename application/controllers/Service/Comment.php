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
class Comment extends Service {
    public function __construct() 
    {
        parent::__construct();
        $this->load->model('Task_Model', 'Task');
        $this->load->model('User_Model', 'User');
        $this->load->model('Transfer_Model', 'Transfer');
        $this->load->model('Complete_Model', 'Complete');
        $this->load->model('Comment_Model', 'Comment');
        $this->load->helper('yt');
        $this->load->helper('google');
    }

    public function test($task_id) {
        $comments = $this->Comment->getItemsBy(array('task_id' => (int) $task_id, 'status' => COMMENT_OPEN));
        print_r($comments);
    }

    public function migrateComments()
    {
        $this->db->select('id');
        $this->db->where('type_id', TASK_REPLY);
        $this->db->where('total_cost > action_cost');
        $query  = $this->db->get('task');

        foreach($query->result() as $task)
        {
            $task = $this->Task->getItem($task->id);
            if($task->extend['comment_type'] == 4)
            {
                $comments = preg_split('#[\r\n]+#', trim($task->extend['comment_text']));
                foreach($comments as $comment)
                {
                    if(!empty($comment))
                    {
                        $this->Comment->addItem(
                            array(
                                'task_id'       => $task->id,
                                'comment_text'  => $comment,
                                'status'        => COMMENT_FREE
                            )
                        );
                        echo $comment.PHP_EOL;
                    }
                }
            }

        }
    }

    private function completeCheck($complete)
    {
        echo "Проверяем... \r\n";
        // исправляем 0 на DOMAIN_YTUBER
        $complete->domain = $complete->domain <= 0 ? DOMAIN_YTUBER : $complete->domain;

        // выбираем конфиг
        $config = $this->config->item('google_api');
        $this->config->set_item('google', $config[$complete->domain]);

        // Переключатель
        //$found = false;

        // Получаем задачу
        $task = $this->Task->getItem($complete->task_id);
        echo "Задача task_id: " . $complete->task_id ."\r\n";

        // Получаем пользователя
        $user = $this->User->getItem($complete->user_id);
        echo "Пользователь user_id: " . $complete->user_id ."\r\n";

        // Получаем авторизацию от пользователя
        $yt = google_auth_youtube($user, false);

        // Получаем video id
        $vid = yt_vid($task->url);

        if($task && $user && $yt && $vid) {
            try{
                // Получение канала текущего пользователя
                //$listChannels = $yt->channels->listChannels('contentDetails', array(
                //    'mine' => true
                //));
                //$authorChannelId = $listChannels->getItems()[0]->getId();
                $authorChannelId = $user->channel;


                // получаем тред комментариев по channelId
                $videoCommentThreads = $yt->commentThreads->listCommentThreads('snippet', array(
                    //'allThreadsRelatedToChannelId' => $channelId,
                    'textFormat' => 'plainText',
                    'maxResults' => 30,
                    'moderationStatus'=> 'published',
                    'videoId' => $vid
                ));

                foreach($videoCommentThreads->getItems() as $item) {
                    $comment = $item->getSnippet()->getTopLevelComment()->getSnippet();

                    // проверяем автора
                    if(isset($comment->getAuthorChannelId()->value))
                    {
                        $chId = $comment->getAuthorChannelId()->value;
                    }
                    else
                    {
                        $chId = '';
                    }
                    //if($comment->videoId != $vid) continue;

                    if($chId == $authorChannelId) {
                        //сообщение
                        echo "Найден канал выполняющего: " . $authorChannelId ."\r\n";
                        echo "Тип задачи: " . $task->extend['comment_type'] . "\r\n";
                        echo "Ролик id: " . $vid . "\r\n";
                        // проверяем текст
                        if($task->extend['comment_type'] == 4) {
                            echo "Тип задачи: заданные комментарии \r\n";

                            $variants = $this->Comment->getItemsBy(array('task_id' => (int) $task->id, 'status' => COMMENT_OPEN));

                            //$variants = array_map('trim', preg_split('#[\r\n]+#', trim($task->extend['comment_text'])));

                            foreach($variants as $key=>$variant) {
                                similar_text(rtrim($comment->textDisplay, "\xef\xbb\xbf"), $variant->comment_text, $prc);

                                //сообщение
                                echo "Процент совпадение текста: " . $prc . "% \r\n";

                                if($prc >= 80) {
                                    // удаляем коммент из бд
                                    //unset($variants[$key]);
                                    //$task->extend['comment_text'] = implode("\r\n", $variants);
                                    //$this->Task->updateItem($task->user_id, $task->id, array('extend' => serialize($task->extend)));
                                    //$found = true;
                                    //сообщение
                                    echo "Требуемый текст: " . $comment->textDisplay. "\r\n";
                                    echo "Текст совпал, проверено: " . $variant->comment_text . "\r\n";
                                    echo "\r\n";

                                    $this->Comment->updateItem($variant->id, array('status' => COMMENT_COMPLETE));

                                    return true;
                                    //goto transfer;
                                }
                                else {
                                    //сообщение
                                    echo "Не совпал текст: " . $variant->comment_text . "\r\n";

                                    //Проверяем если пустой вариант
                                    if ($variant == '') {
                                        $this->Task->updateItem($task->user_id, $task->id, array('disabled' => 1));
                                        //сообщение
                                        echo "Отключаем задачу...";
                                    }

                                    //сообщение
                                    echo "Требуемый текст: " . $comment->textDisplay . "\r\n";
                                    echo "\r\n";
                                }
                            }
                        }
                        // проверка длины
                        else if(mb_strlen($comment->textDisplay) >= 5)
                        {
                            if($task->extend['comment_type'] == 1) {
                                echo "Текст позитивный: " . $comment->textDisplay;
                            }
                            if($task->extend['comment_type'] == 2) {
                                echo "Текст негативный: " . $comment->textDisplay;
                            }
                            if($task->extend['comment_type'] == 3) {
                                echo "Текст произвольный: " . $comment->textDisplay;
                            }
                            echo "\r\n";
							echo "Выполненный текст: " . $comment->textDisplay;
                            //$found = true;
							echo "\r\n";
                           return true; // успешно
                        }
                    }
                }
            }
            catch(Google_Service_Exception $e) {
                $errors = $e->getErrors();
                if(isset($errors[0]['reason']) && $errors[0]['reason'] == 'commentsDisabled') {
                    // отключаем задачу
                    //$this->_userBan($task->user_id, 86400 * 365 * 3, '2.8');

                    $this->Task->updateItem($task->user_id, $task->id, array('disabled' => 1));
                }
                if(isset($errors[0]['reason'])){
                    echo "Ошибка: " . $errors[0]['reason'] . "\r\n";
                }
                if($errors[0]['reason'] == "videoNotFound"){
                    echo "Отключаем задачу \r\n";
                    $this->Task->updateItem($task->user_id, $task->id, array('disabled' => 1));
                }
                else{
                    print_r($e);
                    echo "\r\n";
                }
            }
        }
    }
    
    /*
     * 
     */
    public function complete() 
    {
        while(true) {
            sleep(5);
            $this->db->where('type_id', TASK_COMMENT);
            $this->db->where('status',  COMPLETE_WAITING);
            //$this->db->where('time < ', time() - 60);// 30 сек (с момента выполнения)
            $query  = $this->db->get('done');

            foreach ($query->result() as $complete) 
            {

                $found = $this->completeCheck($complete);

                if($found){
                    echo "Успешно выполнено...\r\n";
                    echo "\r\n";
                }
                else{
                    echo "Не выполнено...\r\n";
                    echo "\r\n";
                }
                $this->transfer($complete->id, $found);
            }   
        }
    }

	public function CurrentComplete($task_id)
    {

        $this->db->where('type_id', TASK_COMMENT);
        $this->db->where('status',  COMPLETE_WAITING);
        $this->db->where('time < ', time() - 60);// 30 сек (с момента выполнения)
        $this->db->where('task_id', $task_id);
        $query  = $this->db->get('done');

        foreach ($query->result() as $complete)
        {

            $found = $this->completeCheck($complete);

            if($found){
                echo "Успешно выполнено...\r\n";
                echo "\r\n";
            }
            else{
                echo "Не выполнено...\r\n";
                echo "\r\n";
            }
            $this->transfer($complete->id, $found);
        }
    }

}
