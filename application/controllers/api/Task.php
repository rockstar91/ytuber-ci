<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('Api.php');

class Task extends Api 
{
    // Получение задачи
    function getItem($id)
    {
        $task = $this->Task->getItem((int)$id);
        $this->output->json($task);
    }

    function getWorkShutdownCallback($task) 
    {
        // Получение данных по задаче от ютуба
        $youtube = 0;//$this->Youtube->getRelevantCounter($task);

        // Обновляем данные в бд, если они изменились
        if ($youtube > $task->youtube) {
            $this->Task->updateItem($task->user_id, $task->id, array('youtube' => $youtube));
        }
    }

    function update($task_id)
    {
        if(!$this->user->admin) {
            die('No have permissions');
        }

        $task = $this->Task->getItem((int)$task_id);
        $youtube = $this->input->get('youtube');
        $this->Task->updateItem($task->user_id, $task_id, array('youtube' => $youtube));
    }

    public function getWork($type_id=null)
    {
        $this->load->model('Youtube_Model', 'Youtube');
        $this->load->helper('yt');
        $this->load->helper('google');
        $this->load->language('yt');
        
		if ($this->user->recaptcha_score < 0.3){
			$this->output->json(array('error' => 'Recaptcha score'));
		}
		
        if(!$this->user) {
            //$this->session->set_userdata('auth_google_redirect', site_url('yt/client'));
            $this->output->json(array('location' => site_url('auth/login')));
        }

        // проверяем авторизацию google
        //$yt = google_auth_youtube($this->user);
        //if(!$yt) {
            //$this->session->set_userdata('auth_google_redirect', site_url('yt/client'));
            //$this->output->json(array('location' => site_url('auth/google')));
        //}

        //if(!google_youtube_check_channel($this->user, $yt)) {
        //    $this->output->json(array('error' => 'Ваш канал недоступен.'));
        //}

        // Лимит выполнений в час по ip
        if($this->Complete->isHourLimitReach($type_id)) {
            $this->output->json(array('error' => $this->lang->line('error_hour_limit')));
        }
        // Лимит выполнений в час по ip
        if($this->Complete->isHourLimitReach($type_id, $this->user->id)) {
            $this->output->json(array('error' => $this->lang->line('error_hour_limit')));
        }

        $rand = mt_rand(0, 20);
        
        // Получаем видео
        //$results = $this->Task->getItemsAvailableGeo($this->user->id, $type_id, 't.order', 0, 90, true, true);
        $results = $this->Task->getItemsAvailableGeoWithOpened($this->user->id, $type_id, 't.order', 1, $rand, true);

        if($results) {
            //shuffle($results);
            $task = $this->Task->_extendItem(array_first($results));

            if($vid = yt_vid($task->url)) {
                    $task->vid = $vid;
            }

            if($channel = yt_channel($task->url)) {
                    $task->channel = $channel;
            }


            register_shutdown_function(array($this, 'getWorkShutdownCallback'), $task);

            // Удаляем стартовую метку для других просмотров для user_id
            if(isset($task->extend['time'])) {
                $this->Complete->remove($this->user->id, null, $task->type_id, COMPLETE_OPENED);
            }

            // Запись о начале просмотра в бд
            $added = $this->Complete->add($this->user->id, $task, COST_API, null, $task->youtube);
                
            if(!$added) {
                $this->output->json(array('error' => $this->lang->line('error_task_perm_unavailable')));
            }

            $this->output->json($task);
        }
        else {
            $this->output->json(array('error' => 'not found available task'));
        }
    }

    function removeComment($task_id) 
    {
        if(!$this->user->admin) {
            die('No have permissions');
        }

        $comment_text = urldecode($this->input->get('comment_text'));

        $task = $this->Task->getItem((int) $task_id);

        if(!$task)
        {
            $this->output->json(array('error' => 'task not found'));
        }

        $variants = array_map('trim', preg_split('#[\r\n]+#', trim($task->extend['comment_text'])));

        //print_r($variants);

        foreach($variants as $key=>$variant) {
            similar_text($comment_text, $variant, $prc);
            if($prc >= 90) {
                // удаляем коммент из бд
                unset($variants[$key]);
                $task->extend['comment_text'] = implode("\r\n", $variants);
                $this->Task->updateItem($task->user_id, $task->id, array('extend' => serialize($task->extend)));
                die(true);
            }
        }
    }

    function getActiveList()
    {
        $type_id = TASK_VIEW;
        $order_by = 't.action_cost';

        $sql = "
            SELECT t.name, t.url, t.extend, t.youtube_extend, t.action_cost, t.total_cost FROM task t
            WHERE
                t.removed  = 0 AND
                t.disabled = 0 AND 
                t.type_id  = {$type_id} AND
                t.total_cost >= t.action_cost AND
                (t.hour_limit > t.hour_done OR t.hour_limit = 0)
            ORDER BY {$order_by} DESC
            LIMIT 0, 100
        ";

        $query = $this->db->query($sql);

        $this->output->json($query->result());
    }

}
