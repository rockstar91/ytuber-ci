<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('Api.php');

class Client extends Api {


    function __construct() {
        parent::__construct();

        $this->load->model('Task_Model', 'Task');
        $this->load->model('User_Model', 'User');
        $this->load->model('Youtube_Model', 'Youtube');
        $this->load->model('Transfer_Model', 'Transfer');
        $this->load->model('Complete_Model', 'Complete');
        $this->load->helper('yt');
        $this->load->helper('google');
        $this->load->helper('strgen');

        $this->lang->load('yt');
    }

    function watch() 
    {
        $type_id = TASK_VIEW; // просмотры

        //if(!$this->user) {
        //    $this->session->set_userdata('auth_google_redirect', site_url('client'));
        //    $this->output->json(array('location' => site_url('auth/login')));
        //}

        // Бан?
        if($this->user->banned > time()) {
            $error = sprintf($this->lang->line('error_banned'), date('d.m.Y H:i', $this->user->banned), $this->user->ban_reason);
            $this->output->json(array('stoperror' => $error));
        }

        //$yt = google_auth_youtube($this->user);
        //if(!$yt) {
        //    $this->session->set_userdata('auth_google_redirect', site_url('client'));
        //    $this->output->json(array('error' => sprintf($this->lang->line('error_google_auth'), site_url('auth/google'))));
        //}

        //if(!google_youtube_check_channel($this->user, $yt)) {
        //    $this->output->json(array('error' => 'Ваш канал недоступен.'));
        //}

        // Удаляем стартовую метку в любом случае
        $this->Complete->remove($this->user->id, null, $type_id, COMPLETE_OPENED);

        // Лимит выполнений в час по ip 
        if($this->Complete->isHourLimitReach($type_id)) {
            $this->output->json(array('error' => $this->lang->line('error_hour_limit')));
        }

        // Лимит выполнений в час по id пользователя
        if($this->Complete->isHourLimitReach($type_id, $this->user->id)) {
            $this->output->json(array('error' => $this->lang->line('error_hour_limit')));
        }

        $results = $this->Task->getItemsAvailableGeo($this->user->id, $type_id, 't.order', 0, 150, true, true);

        //$startTry = 0;
        //start:
        if($results) {
            $task = $this->Task->_extendItem($results[mt_rand(0, count($results)-1)]);

            // Возвращаем ссылку
            if($vid = yt_vid($task->url)) {
                $youtubeUrl  = 'https://www.youtube.com/watch?v='.$vid;

                // выбранное время на youtube
                if($time = yt_time($task->url)) {
                    $youtubeUrl .= '&'.$time;
                }

                // -+25% для времени
                $task->extend['time'] = round(mt_rand($task->extend['time'] * 0.95, $task->extend['time'] * 1.2));
                
                // Получение данных по задаче от ютуба
                $youtube = $this->Youtube->getRelevantCounter($task);

                // Обновляем данные в бд, если они изменились
                if($youtube > $task->youtube) {
                    $this->Task->updateItem($task->user_id, $task->id, array('youtube' => $youtube));
                }

                // Запись о начале просмотра в бд
                $this->Complete->defaultStatus = COMPLETE_WAITING;
                $added = $this->Complete->add($this->user->id, $task, COST_AJAX, null, $youtube);
                if(!$added) {
                    $this->output->json(array('error' => $this->lang->line('error_task_perm_unavailable')));
                }

                $data = array(
                    'id'    => $task->id,
                    'url'   => $youtubeUrl,
                    'vid'   => $vid,
                    'time'  => $task->extend['time'],
                );

                $this->output->json($data);
            }
        }
    }

    function mark() 
    {
        $now = time();

        $id = (int)$this->uri->segment(4);
        $clientHash = $this->uri->segment(5);

        if(!$this->user) {
            $this->session->set_userdata('auth_google_redirect', site_url('client'));
            $this->output->json(array('location' => site_url('auth/login')));
        }

        // Получаем задачу
        $task = $this->Task->getItem($id);
        if(!$task) {
            $this->output->json(array('error' => $this->lang->line('error_task_not_found')));
        }

        if($task->type_id != TASK_VIEW) {
                $this->output->json(array('error' => 'Wrong task type.'));
        }

        // Лимит выполнений в час по задаче
        if($task->hour_limit > 0 AND $task->hour_done >= $task->hour_limit) {
            $this->output->json(array('error' => $this->lang->line('error_task_hour_limit')));
        }

        // Проверка подписи
        $isBot = 0;

        $privateKey = 'yPZQSo5eOY39SyuJ'; 

        $serverHash = md5(yt_vid($task->url).$task->id.'0'.$isBot.$privateKey);
        $serverHashAdblock = md5(yt_vid($task->url).$task->id.'1'.$isBot.$privateKey);

        if ($clientHash != $serverHash && $clientHash != $serverHashAdblock) {
            $this->output->json(array('location' => site_url('client')));
        }

        // Определение adblock
        $clientAdblock = ($clientHash == $serverHashAdblock);

        // проверяем статус выполнения
        if($this->Complete->isFinished($this->user->id, $task)) {
            $this->output->json(array('error' => $this->lang->line('error_task_done')));
        }

        // проверяем доступность средств
        if($task->total_cost < $task->action_cost) {
            $this->output->json(array('error' => $this->lang->line('error_end_task_budget')));
        }

        // проверка по HTTP_REFERER
        //$referer = $this->input->server('HTTP_REFERER');
        //if(!preg_match('#.*(ytuber.ru|ytubey.com|ytuber.com)/client(/\d+)*#', $referer)) {
        //    $this->output->json(array('error' => $this->lang->line('error_window_close_early')));
        //}

        // Проверка стартовой метки и прошедшего времени
        $complete = $this->Complete->getWaiting($this->user->id, $task->id);
        if(!$complete OR time() < $complete->time + $complete->timeout) {
            $this->output->json(array('error' => $this->lang->line('error_window_close_early')));
        } 

        // Cost rule
        $costRule = $clientAdblock ? COST_ADBLOCK : COST_AJAX;

        // Возраст канала 
        if($this->user->channel_published > 0) {
                $channel_age = time() - strtotime($this->user->channel_published);
                $channel_age = intval($channel_age / 86400);

                if($channel_age < 90) {
                    $costRule = COST_PENALTY;
                }
        }
        
        if(!$this->Task->decrease($complete->task_id, $complete->action_cost)) {
            $this->output->json(array('error' => $this->lang->line('error_end_task_budget')));
        }
        
        // Перевод средств
        $this->Transfer->completeToUser($complete->id, $costRule);
        //$this->Transfer->taskToUser($task, $costRule);
        
        // Меняем статус на COMPLETE_WAITING
        $this->Complete->setStatus($complete->id, COMPLETE_FINISHED);

        // Сообщаем о выполнении
        $this->output->json(
            array(
                'status' => 'success',
            )
        );
    }
}