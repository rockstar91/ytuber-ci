<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Work extends MY_Controller
{

    public $user = null;
    public $redirectUrl = 'https://www.google.com/url?sa=t&rct=j&q=&esrc=s&source=web&cad=rja&url=';

    // Для выполнения указанных типов задач требуется авторизация Google
    public $redirectUrls = array(

        'https://www.google.com/url?sa=t&rct=j&q=&esrc=s&source=web&cad=rja&url=[link]',
        'http://www.liveinternet.ru/journal_proc.php?action=redirect&url=[link]'
    );
    public $costType = COST_BASE;

    // public $redirectUrl = '
    // https://www.google.com/url?sa=t&rct=j&q=&esrc=s&source=web&cad=rja&url=';]
    //'https://exit.sc/?url=[link]',
    private $name = 'work';
    private $needGoogleAuth = array(TASK_VIEW, TASK_LIKE, TASK_COMMENT, TASK_SUBSCRIBE, TASK_REPLY, TASK_GPSHARE, TASK_COMMENT_LIKE);
    private $defaultTimeType = array(TASK_VIEW, TASK_LIKE, TASK_COMMENT, TASK_SUBSCRIBE, TASK_REPLY, TASK_COMMENT_LIKE);

    // Соответствие типов задач и их id в бд
    private $taskTypeIds = array(
        TASK_VIEW => 'view',
        TASK_LIKE => 'like',
        TASK_COMMENT => 'comment',
        TASK_SUBSCRIBE => 'subscribe',
        TASK_REPLY => 'reply',
        TASK_GPSHARE => 'gpshare',
        TASK_COMMENT_LIKE => 'comment_like',
        TASK_SITE => 'site',
        TASK_VK_SHARE => 'vkshare',
        TASK_TWITTER_SHARE => 'twittershare',
        TASK_FB_SHARE => 'fbshare'
    );

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Task_Model', 'Task');
        $this->load->model('Category_Model', 'Category');
        $this->load->model('Type_Model', 'Type');
        $this->load->model('User_Model', 'User');
        $this->load->model('Complete_Model', 'Complete');
        $this->load->model('Youtube_Model', 'Youtube');
        $this->load->model('Transfer_Model', 'Transfer');
        $this->load->model('Comment_Model', 'Comment');
        $this->load->model('Geo_Model', 'Geo');
        $this->load->library("pagination");
        $this->load->helper('yt');
        $this->load->helper('google');

        $this->lang->load('yt');

        $this->load->helper('user');
        $this->user = get_user();

        $this->_api_login(array('complete'));

        if (!$this->user)
        {
            redirect('auth/login');
        }

        // Обновление последнего времени посещения и последнего ip
        if (isset($this->user) && strtotime($this->user->lastseen) < (time() - 60))
        {
            $this->User->updateLastseen($this->user->id);
        }

        // Instagram redirect
        $this->load->model('Setting_Model', 'Setting');
        $code = $this->Setting->get('instagram_redirect_code', 900);
        if ($code)
        {
            $this->redirectUrls[] = 'https://l.instagram.com/?u=[link]&e=' . $code;
        }
    }

    public function test()
    {
        $allFinishedTypes = $this->Complete->getCountAllFinishedTypes(7);
        print_r($allFinishedTypes);
    }

    public function penalty()
    {
        $time = time() - (60 * 60 * 24 * 14);

        $sql = "
                SELECT t.*, d.user_id, d.task_id, d.time as done FROM done d
                LEFT JOIN task t ON(d.task_id = t.id)
                WHERE
                        d.time > {$time} AND
                        d.user_id = {$this->user->id} AND
                        d.status = " . COMPLETE_PENALTY . "
                        #t.removed = 0 AND
                        #t.disabled = 0 AND
                        #t.total_cost > t.action_cost AND
                        #(t.hour_limit > t.hour_done OR t.hour_limit = 0)
                GROUP BY t.id
        ";

        $query = $this->db->query($sql);

        // pagination
        $config = $this->config->item('pagination');
        $config['base_url'] = base_url($this->name . '/penalty');
        $config['total_rows'] = $query->num_rows();
        $config['uri_segment'] = 3;

        $this->pagination->initialize($config);

        $page = (int)$this->uri->segment($config['uri_segment']);

        $limit = "LIMIT {$page}, {$config['per_page']}";//
        $query = $this->db->query($sql . $limit);

        $results = $query->result();

        foreach ($results as &$item)
        {
            // тип
            $type = $this->Type->getItem($item->type_id);
            $item->type = isset($type->name) ? $type->name : '-';
        }

        $data["results"] = $this->Task->_extendAll($results);
        $data['pagination'] = $this->pagination->create_links();


        $data['pageTitle'] = $this->lang->line('penalty_title');
        $this->tpl->load('work/penalty', $data);
    }

    public function embeded()
    {


        $data['pageTitle'] = 'Просмотры';

        $this->load->driver('cache');

        $action = $this->uri->segment(2);

        $type_id = TASK_VIEW;

        // pagination
        $total = $this->cache->file->get('work.tasklist.total.' . $type_id);
        if (!$total)
        {
            $total = $this->Task->getTotalAvailable($type_id);
            $this->cache->file->save('work.tasklist.total.' . $type_id, $total, 600);
        }

        $config = $this->config->item('pagination');
        $config['base_url'] = base_url($this->name . '/' . $action);
        $config['total_rows'] = $total;
        $config['uri_segment'] = 3;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();

        $offset = (int)$this->uri->segment($config['uri_segment']);

        if ($offset > $total)
        {
            show_404();
        }

        $result = $this->Task->getItemsAvailableGeo($this->user->id, $type_id, 't.order', $offset, $config['per_page']);
        $data["results"] = $this->Task->_extendAll($result);

        $data['action'] = $action;


        $this->tpl->load('work/embeded', $data);
    }

    public function tasklist()
    {
        //$this->output->cache(5);
        $this->load->driver('cache');

        $action = $this->uri->segment(2);

        $type_id = array_search($action, $this->taskTypeIds);

        if (empty($type_id))
        {
            show_404();
        }

        // pagination
        $total = $this->cache->file->get('work.tasklist.total.' . $type_id);
        if (!$total)
        {
            $total = $this->Task->getTotalAvailable($type_id);
            $this->cache->file->save('work.tasklist.total.' . $type_id, $total, 600);
        }

        $config = $this->config->item('pagination');
        $config['base_url'] = base_url($this->name . '/' . $action);
        $config['total_rows'] = $total;
        $config['uri_segment'] = 3;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();

        $order_by = in_array($action, array('view', 'site')) ? 't.order' : 't.action_cost'; // сортировка

        $offset = (int)$this->uri->segment($config['uri_segment']);

        if ($offset > $total)
        {
            show_404();
        }

        $result = $this->Task->getItemsAvailableGeo($this->user->id, $type_id, $order_by, $offset, $config['per_page']);
        $data["results"] = $this->Task->_extendAll($result);

        $data['action'] = $action;
        $data['pageTitle'] = $this->lang->line('yt_' . $action . '_title');

        $this->tpl->load('work/tasklist', $data);
    }

    // Список задач для выполнения

    public function info()
    {
        // Возраст YouTube канала пользователя в днях
        if ($this->user->channel_published > 0)
        {
            $channel_age = time() - strtotime($this->user->channel_published);
            $channel_age = ceil($channel_age / 86400);
        } else
        {
            $channel_age = 1;
        }

        echo 'channel_age: ' . $channel_age . '<br>';

        //коэфицент
        $b = 4.5;
        $log2 = log($b) * log($channel_age) * $b;
        //лимит подписчиков для данного возраста канала
        $limit = round((log($channel_age) * $log2 * log($b)));

        echo 'limit: ' . $limit . '<br>';
    }

    public function open()
    {
        if ($this->user->banned > time())
        {
            $error = sprintf($this->lang->line('error_banned'), date('d.m.Y H:i', $this->user->banned), $this->user->ban_reason);
            $this->output->json(array('error' => $error));
        }

        $id = (int)$this->uri->segment(3);

        if (!$this->user)
        {
            $this->output->json(array('location' => site_url('auth/login')));
        }


        if ($this->User->monthPaymentsSum($this->user->id) < 500 && !$this->user->admin)
        {
            $recaptcha2_time = $this->session->userdata('recaptcha2_time');
            if ($this->user->recaptcha_score <= 0.2 || time() > $recaptcha2_time)
            {
                $this->output->json(array('location' => site_url('work/captcha')));
            }
        } else
        {
            $this->session->set_userdata('recaptcha2_time', time() + 3000);
        }
        //if($this->user->recaptcha_score < 0.5) {
        //    $this->output->json(array('error' => 'Please try again later'));
        //}

        // получаем задачу
        $task = $this->Task->getItem($id);
        if (!$task)
        {
            $this->output->json(array('error' => $this->lang->line('error_task_not_found')));
        }

        // Интервал выполнений
        //if(strtotime($task->completion) > (time()-60)) {
        //    $this->output->json(array('error' => $this->lang->line('error_task_perm_unavailable')));
        //}

        // Лимит выполнений в час по задаче
        if ($task->hour_limit > 0 AND $task->hour_done >= $task->hour_limit)
        {
            $this->output->json(array('error' => $this->lang->line('error_task_hour_limit')));
        }

        // проверяем статус выполнения
        $complete = $this->Complete->isFinished($this->user->id, $task);
        if ($complete)
        {
            $this->output->json(array('error' => $this->lang->line('error_task_done')));
        }

        // проверяем доступность средств
        if ($task->total_cost < $task->action_cost)
        {
            $this->output->json(array('error' => $this->lang->line('error_end_task_budget')));
        }

        // Лимит выполнений в час по ip
        if ($this->Complete->isHourLimitReach($task->type_id))
        {
            $this->output->json(array('error' => $this->lang->line('error_hour_limit')));
        }

        // Лимит выполнений в час по id пользователя
        if ($this->Complete->isHourLimitReach($task->type_id, $this->user->id))
        {
            $this->output->json(array('error' => $this->lang->line('error_hour_limit')));
        }

        // проверяем штрафы
        $penalty = $this->Task->countPenalty($this->user->id, $task->type_id, 3600 * 24 * 30);
        if ($penalty > 30)
        {
            $this->output->json(array('error' => $this->lang->line('limit_penalty')));
        }

        if (!isset($task->extend['time']) && in_array($task->type_id, $this->defaultTimeType))
        {
            $task->extend['time'] = 30;
        }

        //количество выполнений

        /*$vkNum = $this->Complete->countFinished($this->user->id, TASK_VK_SHARE, 86400);
        $commentsNum = $this->Complete->countFinished($this->user->id, TASK_COMMENT, 86400);
        $likesNum = $this->Complete->countFinished($this->user->id, TASK_LIKE, 86400);
        $videosNum = $this->Complete->countFinished($this->user->id, TASK_VIEW, 86400);
        $subscribsNum = $this->Complete->countFinished($this->user->id, TASK_SUBSCRIBE, 86400);
        */

        $allFinishedTypes = $this->Complete->getCountAllFinishedTypes($this->user->id, 86400);

        $vkNum = isset($allFinishedTypes[TASK_VK_SHARE]) ? $allFinishedTypes[TASK_VK_SHARE] : 0;
        $commentsNum = isset($allFinishedTypes[TASK_COMMENT]) ? $allFinishedTypes[TASK_COMMENT] : 0;
        $likesNum = isset($allFinishedTypes[TASK_LIKE]) ? $allFinishedTypes[TASK_LIKE] : 0;
        $videosNum = isset($allFinishedTypes[TASK_VIEW]) ? $allFinishedTypes[TASK_VIEW] : 0;
        $subscribsNum = isset($allFinishedTypes[TASK_SUBSCRIBE]) ? $allFinishedTypes[TASK_SUBSCRIBE] : 0;


        // проверяем авторизацию google
        if (in_array($task->type_id, $this->needGoogleAuth))
        {
            //$yt = google_auth_youtube($this->user);
			
            /*
            if (!$yt)
            {
                $re = isset($this->taskTypeIds[$task->type_id]) ? $this->name . '/' . $this->taskTypeIds[$task->type_id] : '/';
                $this->session->set_userdata('auth_google_redirect', site_url($re));
                $this->output->json(array('error' => sprintf($this->lang->line('error_google_auth'), site_url('auth/google'))));
            }

            if (!google_youtube_check_channel($this->user, $yt))
            {

                // проверяем квоту
                if (strpos($yt, 'quotas') !== false)
                {
                    $this->output->json(array('error' => $this->lang->line('error_quotas')));
                }

                $this->output->json(array('error' => 'Ваш канал недоступен.'));
            }
            */

            if(empty($this->user->channel)) 
            {
                $this->output->json(array('error' => 'Укажите в настройках свой Youtube-канал.'));
            }

            //Проверяем свободный коммент
            if ($task->type_id == TASK_COMMENT && $task->extend['comment_type'] == 4)
            {
                if ($this->Comment->FreeCommentsCount($task->id) === 0)
                {
                    $this->output->json(array('error' => 'Нет свободных комментариев'));
                }
            }
            if ($task->type_id == TASK_LIKE)
            {
            }

            /* Подписки */
            if ($task->type_id == TASK_SUBSCRIBE)
            {

                //Если не основной канал
                if (strpos($this->user->mail, 'pages.plusgoogle.com'))
                {
                    $error = $this->lang->line('error_notmain_channel');
                    $this->output->json(array('error' => sprintf($error, 0)));
                }

                //ограничиваем выполнение

                if ($subscribsNum > 5 AND ($videosNum < 3 || $likesNum < 3 || $commentsNum < 1))
                {
                    $this->output->json(array('error' => sprintf($this->lang->line('suspicious_activity_subsribe'))));
                }

            }
        }

        if ($task->type_id == TASK_COMMENT_LIKE)
        {
            $count = $this->Complete->countUnfinished($task->id);
            if ($count >= 1)
            {
                $this->output->json(array('error' => $this->lang->line('error_task_perm_unavailable')));
            }
        }

        if ($task->type_id == TASK_VK_SHARE)
        {
            if ($vkNum > 10 AND ($videosNum < 5 || $likesNum < 3 || $commentsNum < 1))
            {
                $this->output->json(array('error' => sprintf($this->lang->line('suspicious_activity_vk'))));
            }
        }

        if ($task->type_id == TASK_VIEW)
        {
            if ($videosNum > 25 AND ($likesNum < 3 || $commentsNum < 1))
            {
                $this->output->json(array('error' => sprintf($this->lang->line('suspicious_activity_view'))));
            }
        }

        /*
        // Получение данных по задаче от ютуба
        $youtube = $this->Youtube->getRelevantCounter($task, true); //$this->_openYoutube($task);
        if ($youtube == -1)
        {
            // прозрачное удаление задачи
            $this->output->json(array('error' => $this->lang->line('error_task_not_found')));
        }

        // Обновляем данные в бд, если они изменились
        if ($youtube > $task->youtube)
        {
            $this->Task->updateItem($task->user_id, $task->id, array('youtube' => $youtube));
        }
        */

        // Запись об открытии
        if (!$this->Complete->add($this->user->id, $task, $this->costType, null, $youtube))
        {
            $this->output->json(array('error' => $this->lang->line('error_task_perm_unavailable')));
        }

        // Время последнего открытия
        //$this->Task->updateItem($task->user_id, $task->id, array('completion' => date('Y-m-d H:i:s')));

        $this->output->json(array('href' => $task->url));
    }

    function go()
    {
        $id = (int)$this->uri->segment(3);
        // получаем задачу
        $task = $this->Task->getItem($id);

        if (!$task)
        {
            show_404();
        }

        $recaptcha2_time = $this->session->userdata('recaptcha2_time');

        if ($this->user->recaptcha_score <= 0.4 && time() > $recaptcha2_time || $this->user->recaptcha_score == 0 && !is_null($this->user->recaptcha_score))
        {
            $this->captcha('go', $id);
        }


        $data['href'] = $task->url; // по умолчанию
        if (in_array($task->type_id, $this->needGoogleAuth))
        {

            if ($task->type_id == TASK_SUBSCRIBE)
            {

                $youtubeUrl = $task->url; // по умолчанию

                // получение ссылки на ролик с канала
                
                /*
                $alternateLink = $this->_getAlternateLink($task->id, yt_channel($task->url));
                if ($alternateLink)
                {
                    $youtubeUrl = $alternateLink;
                }
                */

            }


            if ($vid = yt_vid($task->url))
            {
                $youtubeUrl = 'https://www.youtube.com/watch?v=' . $vid;

                // выбранное время на youtube
                if ($time = yt_time($task->url))
                {
                    $youtubeUrl .= '&' . $time;
                }

                // $task->type_id == TASK_REPLY
                if ($task->type_id == TASK_REPLY OR $task->type_id == TASK_COMMENT_LIKE)
                {
                    $youtubeUrl .= '&lc=' . $task->extend['comment_id'];

                    // only liveinternet works with &lc in url
                    $this->redirectUrls = array($this->redirectUrls['1']);
                }
            }

            // Формирование ссылки редиректа
            $redirectPattern = $this->redirectUrls[mt_rand(0, count($this->redirectUrls) - 1)];
            $replace = array(
                '[link]' => urlencode($youtubeUrl)
            );

            $data['href'] = str_replace(array_keys($replace), $replace, $redirectPattern);
        } else
        {
            // Формирование ссылки
            $replace = array(
                '{url}' => urlencode($task->url),
                '{name}' => urlencode(str_replace('|', ' ', $task->name)) // для твитера
            );
            $windowPatten = $this->Type->getWindowPattern($task->type_id);

            $data['href'] = str_replace(array_keys($replace), $replace, $windowPatten);
        }

        $this->load->view('work/go', $data);


    }

    public function captcha($action = 'captcha', $task_id = null)
    {

        $data = array(
            'action' => $action,
            'task_id' => $task_id
        );

        $secret = $this->config->item('recaptcha2')['secret'];

        //echo $this->input->server('HTTP_REFERER');

        if ($this->input->post('g-recaptcha-response'))
        {

            $recaptcha = new \ReCaptcha\ReCaptcha($secret);
            if ($this->input->server('HTTP_HOST') == 'ytubey.com')
            {
                $resp = $recaptcha->setExpectedHostname('ytubey.com')
                    ->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
            } else
            {
                $resp = $recaptcha->setExpectedHostname($_SERVER['SERVER_NAME'])
                    ->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
            }
            if ($resp->isSuccess())
            {
                $this->session->set_userdata('recaptcha2_time', time() + 3000);

                // сохранить в бд время последней проверки
                redirect('/dashboard');


                //echo 'ok';
                //exit;
            }
        }

        $data['pageTitle'] = $this->lang->line('captcha_perform');
        $this->tpl->load('work/captcha', $data);
    }

    function _getAlternateLink($task_id, $channel)
    {
        // Получение ссылок на ролики с канала
        $dev = google_youtube_developer();

        $alternateLink = null;
        $this->load->model('TaskAlternateIds_Model', 'TaskAlternateIds');

        $taskAlternateId = $this->TaskAlternateIds->getItemByTaskId($task_id);

        // если нет альтернативного id или он просрочен
        if (!$taskAlternateId OR strtotime($taskAlternateId->created_at) < (time() - 86400))
        {
            // получаем по Youtube API
            $listSearch = $dev->search->listSearch('snippet', array('channelId' => $channel, 'type' => 'video'));

            try
            {
                foreach ($listSearch as $item)
                {
                    $videoId = $item->getId()->getvideoId();
                    if ($videoId)
                    {
                        $this->TaskAlternateIds->addItem(
                            array(
                                'task_id' => $task_id,
                                'vid' => $videoId,
                                'created_at' => date('Y-m-d H:i:s')
                            )
                        );

                        return 'https://www.youtube.com/watch?v=' . $videoId;
                    }
                }
            } catch (Exception $e)
            {
            }

        }
        else {
            return 'https://www.youtube.com/watch?v=' . $taskAlternateId->vid;
        }
    }

    public function get_comment()
    {
        $this->load->model('Comment_Model', 'Comment');

        $id = (int)$this->uri->segment(3);

        // получаем задачу
        $task = $this->Task->getItem($id);
        if (!$task)
        {
            $this->output->json(array('error' => $this->lang->line('error_task_not_found')));
        }

        $comment = $this->Comment->getItem($id, COMMENT_FREE);
        if ($comment)
        {
            $this->Comment->updateItem(
                $comment->id,
                array(
                    'status' => COMMENT_OPEN,
                    'time' => date('Y-m-d H:i:s')
                )
            );
            $this->output->json(array('comment' => $comment->comment_text));

        }

        //$comments = array_map('trim', preg_split('#[\r\n]+#', trim($task->extend['comment_text'])));
        //$comment  = htmlspecialchars($comments[mt_rand(0, count($comments)-1)]);

        //$this->output->json(array('comment' => $comment));
    }


    public function complete()
    {
        $id = (int)$this->uri->segment(3);

        if (!$this->user)
        {
            $this->output->json(array('location' => site_url('auth/login')));
        }

        // Бан?
        if ($this->user->banned > time())
        {
            $error = sprintf($this->lang->line('error_banned'), date('d.m.Y H:i', $this->user->banned), $this->user->ban_reason);
            $this->output->json(array('error' => $error));
        }

        // Получаем задачу
        $task = $this->Task->getItem($id);
        if (!$task)
        {
            $this->output->json(array('error' => $this->lang->line('error_task_not_found') . ' (no have task)'));
        }

        // Получаем метку
        $complete = $this->Complete->getOpened($this->user->id, $task->id);
        if (!$complete)
        {
            $this->output->json(array('error' => $this->lang->line('error_task_not_found') . ' (no have mark)'));
            exit;
        }

        // Проверка стартовой метки и прошедшего времени
        if (!$complete OR time() < $complete->time + $complete->timeout)
        {
            $this->output->json(array('error' => $this->lang->line('error_window_close_early')));
        }

        // проверяем статус выполнения
        if ($this->Complete->isFinished($this->user->id, $task))
        {
            $this->output->json(array('error' => $this->lang->line('error_task_done')));
        }


        //Проверяем активность
        //if($this->user->activity <= 0 AND empty($this->input->get('api_key')))
        //{
        //    $this->output->json(array('error' => $this->lang->line('error_activities')));
        //}
        //Проверили активность.

        // проверяем авторизацию google
        //   if(in_array($task->type_id, $this->needGoogleAuth)) {
        //    $yt = google_auth_youtube($this->user);
        //   if(!$yt) {
        //       $re = isset($this->taskTypeIds[$task->type_id]) ? $this->name.'/'.$this->taskTypeIds[$task->type_id] : '/';
        //       $this->session->set_userdata('auth_google_redirect', site_url($re));
        //       $this->output->json(array('error' => sprintf($this->lang->line('error_google_auth'), site_url('auth/google'))));
        //   }
//
        //   if(!google_youtube_check_channel($this->user, $yt)) {
//
        //      // проверяем квоту
        //      if (strpos($yt, 'quotas') !== false) {
        //          $this->output->json(array('error' => $this->lang->line('error_quotas')));
        //      }
//
        //       $this->output->json(array('error' => 'Ваш канал на YouTube недоступен.'));
        //   }
        //}

        // VK SHARE
        if ($task->type_id == TASK_VK_SHARE)
        {
            if (empty($this->user->soc_vk))
            {
                $this->output->json(array('error' => 'Пожалуйста укажите в настройках ссылку на свою страницу VK.'));
            }
        }
        // Twitter SHARE
        if ($task->type_id == TASK_TWITTER_SHARE)
        {
            if (empty($this->user->soc_twitter))
            {
                $this->output->json(array('error' => 'Пожалуйста укажите в настройках ссылку на свою страницу Twitter.'));
            }
        }

        // Меняем статус на COMPLETE_WAITING
        $this->Complete->setStatus($complete->id, COMPLETE_WAITING);

        // Цены
        $cost = $this->Transfer->calculateCost($task->action_cost, $this->costType);

        // Перевод средств
        if (!$this->Task->decrease($task->id, $task->action_cost))
        {
            $this->output->json(array('error' => $this->lang->line('error_end_task_budget')));
        }

        if ($task->type_id == TASK_VIEW)
        {
            $masterDeveloperKey = 'KJLfsk$#lasd@#d!klsdcv33slsdf!';
            //$masterDeveloperKey = 'dfg435dfh43634dhfd234'; //KJLfsk$#lasd@#d!klsdcv33slsdf!
            $serverSign = md5($masterDeveloperKey . $task->id . $this->user->api_key);

            $reciveSign = $this->input->get('sign');

            if ($serverSign != $reciveSign)
            {
                $this->output->json(array('error' => 'Sorry, but you send wrong sign.'));
            }

            // Перечисляем средства пользователю
            $this->Transfer->completeToUser($complete->id);

            // Меняем статус выполнения
            $this->Complete->setStatus($complete->id, COMPLETE_FINISHED);
        }

        // сообщаем о выполнении
        $this->output->json(
            array(
                'status' => 'success',
                'text' => sprintf($this->lang->line('task_moderate_done'), yt_cost_format($cost['user'])),
                'user_balance' => $this->user->balance
            )
        );

    }
}
//

/* End of file Work.php */
/* Location: ./application/controllers/Work.php */
