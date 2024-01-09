<?php
ini_set("memory_limit", "256M");

class Cron extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Task_Model', 'Task');
        $this->load->model('User_Model', 'User');
        $this->load->model('Comment_Model', 'Comment');
        $this->load->model('Penalty_Model', 'Penalty');
        $this->load->model('Notification_Model', 'Notification');
        $this->load->helper('yt');
        $this->load->helper('google');
    }

    /* Освобождение комментов, которые были открыты, но не выполнены в течении 3 мин */
    function comment_realese() 
    {
        $this->db->where('status', COMMENT_OPEN);
        $this->db->where('time <', 'timestamp(DATE_SUB(NOW(), INTERVAL 3 MINUTE))', false);
        $this->db->set('status', COMMENT_FREE);
        $this->db->update('comment');

    }

    /* Обновление кода Instagram для редиректа */
    function update_instagram_code()
    {
        echo "ready get instagram url \r\n";
        
        $this->load->model('Setting_Model', 'Setting');

        sleep(3);
        
        $auth = base64_encode('o3seh1q6:797qqyv3');

        $aContext = array(
            'http' => array(
                'proxy' => 'tcp://irina.ltespace.com:15849',
                'request_fulluri' => true,
                'header' => "Proxy-Authorization: Basic $auth",
            ),
        );

        $cxContext = stream_context_create($aContext);

        $html = file_get_contents("http://www.instagram.com/youtube/", False, $cxContext);
        
        preg_match('#u0026e=(.*?)\\\#', $html, $match);
        
        $code = isset($match[1]) ? $match[1] : false;

        $instagram_code = $this->Setting->get('instagram_code');

        echo "Code is: \r\n" . $code . "\r\n";

        if(strlen($code) == 72) 
        {
            if($instagram_code != null) 
            {
                $this->Setting->update('instagram_code', $code);
            }
            else 
            {
                $this->Setting->add('instagram_code', $code);
            }
        }

        //print_r($instagram_code);
        echo "Instagram get url complete...\r\n";
    }

    /* Удаление неактивных пользователей (не заходили более 6 мес) */
    function remove_inactive_users()
    {
        $removedUsers = $removedTasks = 0;

        $this->db->select('id, balance');
        $this->db->where('lastseen <', 'NOW() - INTERVAL 6 MONTH', false);
        $this->db->limit(10000);
        $query = $this->db->get('user');

        foreach ($query->result() as $user) {
            // Платников не трогаем
            if ($this->User->allPaymentsSum($user->id) >= 300) {
                continue;
            }

            // Удаление задач пользователя
            $this->db->where('user_id', $user->id);
            $this->db->delete('task');
            $removedTasks += $this->db->affected_rows();

            // Удаление пользователя
            $removedUsers += $this->User->removeItem($user->id);
        }

        echo 'Removed users: ' . $removedUsers . ', removed tasks: ' . $removedTasks;
    }

    /* Сброс лимита выполнений за час */
    function hour_done_reset()
    {
        $this->db->where('hour_done >', 0);
        $this->db->set('hour_done', 0);
        $this->db->update('task');
    }

    /* Сброс лимита выполнений за сутки */
    function user_done_day_reset()
    {
        $this->db->set('done_day', 0)->set('daily_bonus_received', 0)->update('user');
    }

    // Отключение задач пользователей с отрицательным балансом
    function debtors_tasks_off()
    {
        $this->db->where('balance <', CREDIT_LIMIT);
        $query = $this->db->get('user');

        foreach ($query->result() as $user) {
            // Отключение задач пользователя
            $this->db->where('user_id', $user->id);
            $this->db->set('disabled', 1);
            $this->db->update('task');
        }
    }

    function task_comment_custom_disable_completed() {

        $this->db->select('id, name, url, user_id, action_done, extend');
        //$this->db->where('id', 262128);
        $this->db->where('total_cost > action_cost');
        $this->db->where('type_id', TASK_COMMENT);
        $this->db->where('disabled', 0);
        //$this->db->limit(10000);
        $query = $this->db->get('task');

        foreach ($query->result() as $task) 
        {
            // Доп. инфрмация о задаче
            $task->extend = @unserialize($task->extend);
            if(isset($task->extend['comment_type']) && $task->extend['comment_type'] != 4)
            {
                continue;
            }
            
            // кол-во доступных комментов
            $this->db->or_where_in('status', array(COMMENT_FREE, COMMENT_OPEN));
            $this->db->where('task_id', $task->id);
            $comment = $this->db->get('comment');

            if($comment->num_rows() <= 0) {
                // отключаем задачу
                $this->db->where('id', $task->id);
                $this->db->set('disabled', 1);
                $this->db->update('task');
                
                echo 'task #'.$task->id.' has been disabled'.PHP_EOL; 
            }
        }
    }

    // Удаление старых уведомлений
    function remove_old_notifications()
    {
        $date = date('Y-m-d H:i:s', strtotime('-30 days'));
        $this->db->where('time <', $date);
        $this->db->delete('notification');
    }

    function remove_old_done()
    {
        $this->load->model('Type_Model', 'Type');
        $types = $this->Type->getAllItems();

        foreach ($types as $type) {
            $targetTime = time() - ($type->complete_days * 86400);

            $this->db->where('type_id', $type->id);
            $this->db->where('time <', $targetTime);
            $this->db->delete('done');
        }
    }

    // Пересчет задач с отрицательной ценой
    function task_cost_recalc()
    {
        $this->db->where('total_cost <', 0);
        $query = $this->db->get('task');

        foreach ($query->result() as $task) {
            // получаем задачу
            if ($this->User->increaseBalance($task->user_id, $task->total_cost)) {
                $this->db->where('id', $task->id);
                $this->db->set('total_cost', 0);
                $this->db->update('task');
            }
        }
    }

    // Отключение завершенных задач
    function task_done_disable()
    {
        $this->db->select('id, name, url, user_id, action_done');
        //$this->db->where('id', 262128);
        $this->db->where('total_cost < action_cost');
        $this->db->where('disabled', 0);
        $this->db->limit(1000);
        $query = $this->db->get('task');

        foreach ($query->result() as $task) {
            // отключаем задачу
            $this->db->where('id', $task->id)->set('disabled', 1)->update('task');

            // получаем пользователя
            $user = $this->User->getItem($task->user_id);
            if (!$user) {
                echo "user not found, continue\r\n";
                continue;
            }

            // отправляем уведомление
            if ($user->sub_statistic) {
                $this->_mail_task_end($user, $task);
            }
        }
    }

    function remove_old_tasks() 
    {
        $this->db->query("DELETE FROM `task` WHERE `total_cost` < `action_cost` AND `updated` < '2019-06-01 00:00:00'");
    }

    function _mail_task_end($user, $task)
    {
        $this->load->helper('mail');
        $text = "ID: {$task->id}<br/>\r\n";
        $text .= "Ссылка: {$task->url}<br/><br/>\r\n\r\n";
        $text .= "Ваша задача была выполнена, всего выполнений: <b>{$task->action_done}</b>.<br/>\r\n";

        mail_send($user->mail, 'Задача выполнена', $text);
    }

    // Метка у гео задач
    function task_geo()
    {
        $this->db->group_by('task_id');
        $query = $this->db->get('geo_to_task');
        foreach ($query->result() as $item) {
            $this->db->where('id', $item->task_id);
            $this->db->set('geo', 1);
            $this->db->update('task');
            echo 1;
        }
    }

    function penalty_spam()
    {
        echo "<pre>";

        // Получение пользователей для проверки
        $this->db->where('channel !=', '');
        $this->db->where('refresh_token !=', '');
        $this->db->order_by('rand()');
        $this->db->limit(1000);
        $query = $this->db->get('user');

        foreach ($query->result() as $user) {
            // Получаем авторизацию от пользователя
            $yt = google_auth_youtube($user, false);

            // проверяем квоту
            if (strpos($yt, 'quotas') !== false) {
                break;
            }

            if (!$yt) {
                echo "No have google auth \r\n";
                continue;
            }

            try {
                $videoCommentThreads = $yt->commentThreads->listCommentThreads('snippet,replies', array(
                    //'allThreadsRelatedToChannelId' => $channelId,
                    'textFormat' => 'plainText',
                    'maxResults' => 50,
                    'moderationStatus' => 'likelySpam',
                    'allThreadsRelatedToChannelId' => $user->channel
                ));

                foreach ($videoCommentThreads->getItems() as $item) {
                    $vid = $item->getSnippet()->getVideoId();

                    $commentId = $item->getSnippet()->getTopLevelComment()->getId();
                    $comment = $item->getSnippet()->getTopLevelComment()->getSnippet();

                    // канал автора коммента
                    $channelId = $comment->getAuthorChannelId()->value ?? null;
                    if ($channelId) {
                        echo "Channel not found\r\n";
                        continue;
                    }

                    $author = $this->User->getItemBy('channel', $channelId);

                    // Проверяем наличие пользователя в базе
                    if (!$author) {
                        echo "User not found by comment author channel id\r\n";
                        continue;
                    }

                    // Проверяем наличие штрафа по этой задаче
                    if ($this->Penalty->hasItem('comment_id', $commentId)) {
                        echo "Penalty exist, continue \r\n";
                        continue;
                    }

                    // Размер штрафа
                    $cost = 5;

                    // Снятие средств с баланса пользователя
                    if ($this->User->decreaseBalance($author->id, $cost)) {
                        // Добавление штрафа
                        $data = array(
                            'user_id' => $author->id,
                            'comment_id' => $commentId,
                            'task_id' => 0,
                            'data' => $comment->textDisplay,
                            'cost' => $cost
                        );
                        $this->Penalty->addItem($data);

                        // Нотификации
                        $noty = array(
                            'user_id' => $author->id,
                            'cost' => $cost,
                            'type' => NOTY_PENALTY_SPAM
                        );
                        if ($vid) {
                            $noty['data'] = $vid;
                        }
                        $this->Notification->addItem($noty);


                        echo "Penalty \r\n";
                    }
                }
            } catch (Exception $e) {
            }
        }

    }

    function _mail_spam_penalty($user, $cost, $vid, $comment)
    {
        $this->load->helper('mail');
        $text = "Вы были оштрафованы за спам к видео на {$cost} балл(а/ов)<br>\r\n";
        $text .= "Ссылка на видео: https://www.youtube.com/watch?v={$vid}<br>\r\n";
        $text .= "Текст комментария:<br>\r\n <i>{$comment}</i><br>\r\n";
        mail_send($user->mail, 'Штраф: Спам', $text);
    }

    function penalty_subcribe()
    {
        set_time_limit(3600);
        $this->db->where('type_id', TASK_SUBSCRIBE);
        //$this->db->where('finished', 1);
        $this->db->where_in('status', array(COMPLETE_FINISHED, COMPLETE_PENALTY));

        if ($this->input->get('task_id')) {
            $this->db->where('task_id', (int)$this->input->get('task_id'));
        } else if ($this->input->get('user_id')) {
            $this->db->where('user_id', (int)$this->input->get('user_id'));
        } else {
            $this->db->where('time > ', time() - (60 * 60 * 24 * 30));    // 30 дней (с момента выполнения)
            $this->db->where('time < ', time() - (60 * 60 * 24));        // 24 часа (с момента выполнения)
            $this->db->where('check_time < ', time() - (60 * 60 * 24)); // 24 часа (с момента последней проверки)
        }
        //$this->db->where('penalty', 0);
        //$this->db->order_by('check_count', 'ASK');
        $this->db->order_by('time', 'ASK');
        //$this->db->order_by('task_id', 'ASK');
        $this->db->limit(2000);
        $query = $this->db->get('done');

        // Если у нас 6 тыс выполнений в день, это 180 тыс выполнений за 30 дней. Скорость проверки, в лучшем случае, 12 тыс. в час, значит за сутки можно проверить 288 тыс.

        //print_r($query->result()); exit;

        $subscribedUsers = array();
        $tasks = array();

        $start_time = time();

        foreach ($query->result() as $k => $done) {
            // исправляем 0 на DOMAIN_YTUBER
            $done->domain = $done->domain <= 0 ? DOMAIN_YTUBER : $done->domain;
            // выбираем конфиг
            $config = $this->config->item('google_api');
            $this->config->set_item('google', $config[$done->domain]);


            echo "---\r\n";
            echo "done number:{$k}\r\n";
            //echo "penalty status:".$done->penalty."\r\n";
            echo "done id:" . $done->id . "\r\n";
            echo "done time:" . date('Y-m-d H:i', $done->time) . "\r\n";

            $subscribed = false;
            $continue = false;

            // определяем цену, если она не задана
            $done->action_cost = $done->action_cost;

            // обновляем время и количество проверок для метки
            $this->db->where('id', $done->id);
            $this->db->set('check_count', 'check_count+1', false);
            $this->db->set('check_time', time());
            $this->db->update('done');

            // получаем задачу
            //if(!isset($tasks[$done->task_id])) {
            //  $tasks[$done->task_id] = $this->Task->getItem($done->task_id);
            //}

            $task = $this->Task->getItem($done->task_id);
            if (!$task) {
                echo "task not found, continue\r\n";
                continue;
            }
            echo "task id:" . $task->id . "\r\n";

            // Получение id канала задачи
            $channel = yt_channel($task->url);
            echo "task channel id:" . $channel . "\r\n";

            // получаем пользователя
            $yt = false;
            $user = $this->User->getItem($done->user_id);
            if (!$user) {
                echo "user not found, continue\r\n";
                continue;
            }
            echo "user id:" . $user->id . "\r\n";

            // Получаем авторизацию от пользователя
            $yt = google_auth_youtube($user, false);
            if (!$yt) {
                echo "no user auth\r\n";
                $continue = true;
                //continue;
            }

            // Получение канала пользователя
            if (!$continue) {
                if (empty($user->channel)) {
                    try {
                        $listChannels = $yt->channels->listChannels('contentDetails', array(
                            'mine' => true
                        ));
                        $user->channel = $listChannels->getItems()[0]->getId();
                    } catch (Exception $e) {
                    }

                    if (!empty($user->channel)) {
                        $this->User->updateItem($user->id, array('channel' => $user->channel));
                    }
                }
                echo "user channel id:" . $user->channel . "\r\n";

                echo "check channel available...\r\n";
                $dev = google_youtube_developer();
                try {
                    $listChannels = $dev->channels->listChannels('statistics', array('id' => $channel));
                    // если нет канала
                    if ($listChannels->getPageInfo()->getTotalResults() === 0) {
                        echo "channel not found, continue\r\n";
                        continue;
                    }
                    foreach ($listChannels->getItems() as $k => $item) {
                        if ($item->getStatistics()->subscriberCount > 0) {
                            echo $item->getStatistics()->subscriberCount . " subscribers \r\n";
                        }
                    }
                } catch (Exception $e) {
                }

                echo "check from user...\r\n";
                try {
                    $listSubscriptions = $yt->subscriptions->listSubscriptions('snippet', array(
                        'mine' => true,
                        'forChannelId' => $channel
                    ));

                    $items = $listSubscriptions->getItems();

                    foreach ($items as $item) {
                        if ($item->getSnippet()->getResourceId()->channelId == $channel) {
                            $subscribed = true;
                            echo "subscribe found from user\r\n";
                            break; // break foreach
                        }
                    }
                } catch (Exception $e) {
                    echo "check from user failed, continue\r\n";
                    continue;
                }
            }

            echo "subscribed:" . (int)$subscribed . "\r\n";


            // снимаем штраф, возвращаем баллы
            if ($subscribed && $done->status == COMPLETE_PENALTY) {
                // обновляем метку
                $this->db->where('id', $done->id);
                //$this->db->set('penalty', 0);
                $this->db->set('status', COMPLETE_FINISHED);
                $this->db->update('done');

                // обновляем задачу
                if ($task->total_cost >= $done->action_cost) {
                    $this->db->where('id', $task->id);
                    $this->db->set('action_fail', 'action_fail-1', false);
                    $this->db->set('total_cost', 'total_cost-' . $done->action_cost, false);
                    $this->db->update('task');
                }

                // возвращаем баллы пользователю
                $this->User->increaseBalance($user->id, $done->action_cost);

                echo "COMPLETE: cancel penalty\r\n";
            } else if (!$this->input->get('debug') && !$subscribed && $done->status == COMPLETE_FINISHED && $this->User->decreaseBalance($user->id, $done->action_cost, false)) {

                // отправляем уведомление
                //if ($user->sub_notification && empty($user->confirm))
                //    $this->_mail_subscribe_penalty($user, $task, $done);

                // обновляем метку
                $this->db->where('id', $done->id);
                //$this->db->set('penalty', 1);
                $this->db->set('status', COMPLETE_PENALTY);
                $this->db->update('done');

                // обновляем задачу
                $this->db->where('id', $task->id);
                $this->db->set('action_fail', 'action_fail+1', false);
                $this->db->set('total_cost', 'total_cost+' . $done->action_cost, false);
                $this->db->update('task');

                // Нотификации
                $noty = array(
                    'user_id' => $user->id,
                    'task_id' => $task->id,
                    'task_type_id' => $task->type_id,
                    'data' => $channel,
                    'cost' => $done->action_cost,
                    'type' => NOTY_PENALTY_TASK
                );

                $this->Notification->addItem($noty);

                echo "COMPLETE: penalty\r\n";
            }
        }

        $execution_time = time() - $start_time;

        echo "#END, execution time: {$execution_time} sec\r\n";
    }

    function penalty_like()
    {
        $this->db->where('type_id', TASK_LIKE);
        //$this->db->where('finished', 1);
        $this->db->where('status', COMPLETE_FINISHED);

        if ($this->input->get('task_id')) {
            $this->db->where('task_id', (int)$this->input->get('task_id'));
        } else if ($this->input->get('user_id')) {
            $this->db->where('user_id', (int)$this->input->get('user_id'));
        } else {
            $this->db->where('time > ', time() - (60 * 60 * 24 * 3));    // 3 дня (с момента выполнения)
            $this->db->where('time < ', time() - (5 * 60));            // 5 минут (с момента выполнения)
            $this->db->where('check_time < ', time() - (60 * 60 * 4));        // 60 минут (с момента последней проверки)
        }
        //$this->db->where('penalty', 0);
        //$this->db->order_by('id', 'random');
        $this->db->order_by('check_count', 'ASK');
        $this->db->limit(500);
        $query = $this->db->get('done');

        //print_r($query->result()); exit;

        foreach ($query->result() as $done) {
            // исправляем 0 на DOMAIN_YTUBER
            $done->domain = $done->domain <= 0 ? DOMAIN_YTUBER : $done->domain;
            // выбираем конфиг
            $config = $this->config->item('google_api');
            $this->config->set_item('google', $config[$done->domain]);

            $liked = false;

            // определяем цену, если она не задана
            $done->action_cost = $done->action_cost;

            // обновляем время и количество проверок для метки
            $this->db->where('id', $done->id);
            $this->db->set('check_count', 'check_count+1', false);
            $this->db->set('check_time', time());
            $this->db->update('done');

            // получаем задачу
            $task = $this->Task->getItem($done->task_id);
            if (!$task) {
                echo "task not found, continue\r\n";
                continue;
            }
            echo "task id:{$task->id}\r\n";

            // получаем пользователя
            $user = $this->User->getItem($done->user_id);
            if (!$user) {
                echo "user not found, continue\r\n";
                continue;
            }
            echo "user id:{$user->id}\r\n";

            // получаем авторизацию
            $yt = google_auth_youtube($user);
            if (!$yt) {
                echo "auth not found, continue\r\n";
                continue;
            }

            // проверяем лайк
            try {
                $allow = array('like', 'dislike');

                $vid = yt_vid($task->url);
                $res = $yt->videos->getRating($vid);
                foreach ($res->getItems() as $item) {
                    if (in_array($item->rating, $allow) && $item->videoId == $vid) {
                        $liked = true;
                        break;
                    }
                }

                if (!$liked && $this->User->decreaseBalance($user->id, $done->action_cost)) {
                    echo "COMPLETE: penalty\r\n";

                    // обновляем метку
                    $this->db->where('id', $done->id);
                    //$this->db->set('penalty', 1);
                    $this->db->set('status', COMPLETE_PENALTY);
                    $this->db->update('done');

                    // обновляем задачу
                    $this->db->where('id', $task->id);
                    $this->db->set('action_fail', 'action_fail+1', false);
                    $this->db->set('total_cost', 'total_cost+' . $done->action_cost, false);
                    $this->db->update('task');


                    // Нотификации
                    $noty = array(
                        'user_id' => $user->id,
                        'task_id' => $task->id,
                        'task_type_id' => $task->type_id,
                        'data' => $vid,
                        'cost' => $done->action_cost,
                        'type' => NOTY_PENALTY_TASK
                    );

                    $this->Notification->addItem($noty);
                }
            } catch (Exception $e) {
                //print_r($e);
            }
            echo "<br/>\r\n";
        }
    }
}