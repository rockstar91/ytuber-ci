<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Client extends CI_Controller
{

    public $name = 'client';

    public $user = null;

    public $redirectUrls = array(
        'https://www.google.com/url?sa=t&rct=j&q=&esrc=s&source=web&cad=rja&url=[link]',
        'http://www.liveinternet.ru/journal_proc.php?action=redirect&url=[link]'
    );

    public function __construct()
    {
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

        $this->load->helper('user');
        $this->user = get_user();

        // Instagram redirect
        $this->load->model('Setting_Model', 'Setting');
        $code = $this->Setting->get('instagram_code');
        if ($code) {
            $this->redirectUrls[] = 'https://l.instagram.com/?u=[link]&e=' . $code;
        }

    }

    /* _mustBeLogged */

    function test()
    {
        $this->_mustBeLogged();

        $privateKey = 'wrt35ethdh3252gsfx3';

        $sign = $this->input->get('sign');
        $serverSign = md5($privateKey . $this->user->id);

        $status = ($sign == $serverSign) ? 1 : 0;

        //$status = (int) $this->input->get('status');

        $this->User->updateItem($this->user->id, array(
            'test_time' => date('Y-m-d H:i:s'),
            'test_status' => $status
        ));

        if ($status > 0) {
            $this->output->json('success');
        }

        $data['pageTitle'] = 'Testing...';

        $links = "  https://www.youtube.com/watch?v=A1Nef-GBEmY
                    https://www.youtube.com/watch?v=3vQq4yrbaPo
                    https://www.youtube.com/watch?v=ji5oZkjR_Rg
                    https://www.youtube.com/watch?v=jmPFEYD_0Aw
                    https://www.youtube.com/watch?v=WACsPXKOOTU";

        $links = preg_split('/\n|\r\n?/', $links);
        $links = array_map('trim', $links);


        $data['vid'] = yt_vid($links[mt_rand(0, count($links) - 1)]);


        $this->load->view('client/test', $data);

    }

    function _mustBeLogged()
    {
        if (!$this->user) {
            redirect('auth/login');
        }
    }

    function index()
    {
        $this->_mustBeLogged();

        // js-файл
        $this->db->order_by('id', 'RANDOM');
        $this->db->limit(1);
        $query = $this->db->get('client_js');
        $data['js'] = ($query->num_rows() > 0) ? $query->row() : false;

        if ($this->user->admin) {
            $data['js']->private_key = '{private_key}';
            $data['js']->filename = 'in_fglm345sdfg.js';
        }

        // записываем ключ в сессию
        $this->session->set_userdata('private_key', $data['js']->private_key);

        $data['pageTitle'] = $this->lang->line('client_title');
        $this->load->view('client/index', $data);

    }

    function stat()
    {
        $this->_mustBeLogged();

        if ($this->user->admin) {
            $min5 = date('Y-m-d H:i:s', time() - 5 * 60);
            $query = $this->db->query("SELECT COUNT(DISTINCT lastip) as total FROM user WHERE lastseen > '{$min5}'")->row();
            if ($query) {
                $client_online = $query->total;
            }
        } else {

            // Онлайн
            $this->load->driver('cache');
            $client_online = $this->cache->file->get('client_online');

            if (!$client_online) {
                $min60 = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:00')) - 2 * 60 * 60);
                $query = $this->db->query("SELECT COUNT(id) as total FROM user WHERE lastseen > '{$min60}'")->row();

                if ($query) {
                    $client_online = $query->total + 567;
                }

                $this->cache->file->save('client_online', $client_online, 60);
            }
        }

        $data = array(
            'online' => $client_online,
            'credits' => $this->user->balance,
            'membership' => '-',
            'watched' => $this->user->done,
            'id' => $this->user->id,
            'time' => time()
        );

        $this->output->json($data);
    }

    function check_auth()
    {
        if (!$this->user) {
            //$this->session->set_userdata('auth_google_redirect', site_url('client'));
            $this->output->json(array('location' => site_url('auth/login')));
        }

        //if (!google_auth_youtube($this->user)) {
        //    $this->session->set_userdata('auth_google_redirect', site_url('client'));
        //    $this->output->json(array('location' => site_url('auth/google')));
        //}
    }

    function wait()
    {
        $this->_mustBeLogged();
        $this->load->view('client/wait', array());
    }

    function watchShutdownCallback($task)
    {
        // Получение данных по задаче от ютуба
        $youtube = $this->Youtube->getRelevantCounter($task);

        // Обновляем данные в бд, если они изменились
        if ($youtube > $task->youtube) {
            $this->Task->updateItem($task->user_id, $task->id, array('youtube' => $youtube));
        }
    }

    function watch()
    {
        $type_id = TASK_VIEW; // просмотры

        if (!$this->user) {
            //$this->session->set_userdata('auth_google_redirect', site_url('client'));
            $this->output->json(array('location' => site_url('auth/login')));
        }

        // Бан?
        if ($this->user->banned > time()) {
            $error = sprintf($this->lang->line('error_banned'), date('d.m.Y H:i', $this->user->banned), $this->user->ban_reason);
            $this->output->json(array('error' => $error));
        }

        //Если не основной канал
        if(strpos($this->user->mail, 'pages.plusgoogle.com'))
        {
            $error = $this->lang->line('error_notmain_channel');
            $this->output->json(array('error' => sprintf($error, 0)));
        }

        //Если не подтвержден email
        if(!empty($this->user->confirm))
        {
            $error = 'Вы должны подтвердить email, прежде чем выполнять задачи';
            $this->output->json(array('error' => $error));
        }

		//Если рекапча
        $recaptcha2_time = $this->session->userdata('recaptcha2_time');
		if ($this->user->recaptcha_score <= 0.1 && time() > $recaptcha2_time){
			$this->output->json(array('error' => 'Bot detected, recaptcha score < 0.1. Please <a href="'.site_url('work/captcha').'">solve captcha</a>.'));
		}

        //$yt = google_auth_youtube($this->user);
        //if (!$yt) {
        //    $this->session->set_userdata('auth_google_redirect', site_url('client'));
        //    $this->output->json(array('error' => sprintf($this->lang->line('error_google_auth'), site_url('auth/google'))));
        //}

        //if (!google_youtube_check_channel($this->user, $yt)) {
        //    $this->output->json(array('error' => 'Ваш канал недоступен.'));
        //}

        $testInterval = 3600;

        // Проверка воспроизведения видео
        if (!$this->user->test_status OR strtotime($this->user->test_time) < (time() - $testInterval))
        {
            $data = array(
                'id' => 0,
                'url' => site_url('client/test'),
                'vid' => '',
                'time' => 30,
            );

            $this->output->json($data);
        }

        // Проверяем кол-во комментов и лайков

        $commentsNum = $this->Complete->countFinished($this->user->id, TASK_COMMENT, 86400);
		//$likesNum = $this->Complete->countFinished($this->user->id, TASK_LIKE, 86400);
		$videosNum = $this->Complete->countFinished($this->user->id, TASK_VIEW, 86400);

        if($videosNum > 100 AND ($likesNum < 3 ))
        {
            $this->output->json(array('error' => sprintf($this->lang->line('suspicious_activity'))));
        }


        // Удаляем стартовую метку в любом случае
        $this->Complete->remove($this->user->id, null, $type_id, COMPLETE_OPENED);


        // Лимит выполнений в час по ip
        if ($this->Complete->isHourLimitReach($type_id))
        {
            $this->output->json($this->lang->line('error_hour_limit'));
        }

        // Лимит выполнений в час по id пользователя
        if($this->Complete->isHourLimitReach($type_id, $this->user->id))
        {
            $this->output->json($this->lang->line('error_hour_limit'));
        }


        //Проверяем активность
//        $dev = google_youtube_developer();
//        $currentuser = $this->user;
//        $activechannel = $currentuser->channel;
//        $activ = $dev->activities->listActivities('snippet', array('channelId' => $activechannel));
//        if($activ->getpageInfo()->totalResults>0 OR !empty($this->input->get('api_key'))){
//        }
//        else{
//            $this->output->json(array('error' => $this->lang->line('error_activities')));
//        }
        //Проверили активность.


        $rand = mt_rand(0, 10);

        //$results = $this->Task->getItemsAvailableGeo($this->user->id, $type_id, 't.order', $rand, 1, true, true);
        $results = $this->Task->getItemsAvailableGeoWithOpened($this->user->id, $type_id, 't.order', 1, $rand, true);

        if ($results) {
            $task = $this->Task->_extendItem($results[mt_rand(0, count($results) - 1)]);

            // Возвращаем ссылку
            if ($vid = yt_vid($task->url)) {
                $youtubeUrl = 'https://www.youtube.com/watch?v=' . $vid;

                // выбранное время на youtube
                if ($time = yt_time($task->url)) {
                    $youtubeUrl .= '&' . $time;
                }

                // -+25% для времени
                $task->extend['time'] = round(mt_rand($task->extend['time'] * 0.95, $task->extend['time'] * 1.2));

                // Запись о начале просмотра в бд
                $this->Complete->defaultStatus = COMPLETE_WAITING; //TODO: учитывать в выборке статус WAITING

                $added = $this->Complete->add($this->user->id, $task, COST_AJAX, null, $task->youtube);

                if (!$added) {
                    $this->output->json($this->lang->line('error_task_perm_unavailable'));
                }


                //register_shutdown_function(array($this, 'watchShutdownCallback'), $task);

                // Формирование ссылки редиректа
                $redirectPattern = $this->redirectUrls[mt_rand(0, count($this->redirectUrls) - 1)];
                $replace = array(
                    '[link]' => urlencode($youtubeUrl),
                    '[rand6]' => strgen(6)
                );
                $redirectUrl = str_replace(array_keys($replace), $replace, $redirectPattern);

                $data = array(
                    'id' => $task->id,
                    'url' => $redirectUrl,
                    'vid' => $vid,
                    'time' => $task->extend['time'],
                );

                $this->output->json($data);
            }
        }
    }

    function mark()
    {
        $now = time();

        $id = (int)$this->uri->segment(3);
        $clientHash = $this->uri->segment(4);

        //if (!$this->user) {
        //    $this->session->set_userdata('auth_google_redirect', site_url('client'));
        //    $this->output->json(array('location' => site_url('auth/login')));
        //}

        // Бан?
        if ($this->user->banned > time()) {
            $error = sprintf($this->lang->line('error_banned'), date('d.m.Y H:i', $this->user->banned), $this->user->ban_reason);
            $this->output->json(array('error' => $error));
        }

        // Получаем задачу
        $task = $this->Task->getItem($id);
        if (!$task) {
            $this->output->json($this->lang->line('error_task_not_found'));
        }

        if ($task->type_id != TASK_VIEW) {
            $this->output->json('Wrong task type.');
        }

        // Лимит выполнений в час по задаче
        if ($task->hour_limit > 0 AND $task->hour_done >= $task->hour_limit) {
            $this->output->json($this->lang->line('error_task_hour_limit'));
        }
		//Если рекапча
		if (is_null($this->user->recaptcha_score) || $this->user->recaptcha_score == 0){
			$this->output->json(array('error' => 'bot detected'));
		}
        // Проверка подписи
        $isBot = 0;

        $privateKey = $this->session->userdata('private_key');

        // Проверяем в бд
        $this->db->where('private_key', $privateKey);
        $count = $this->db->count_all_results('client_js');

        if (empty($privateKey) OR $count <= 0) {
            $privateKey = '{private_key}';
        }

        $serverHash = md5(yt_vid($task->url) . $task->id . '0' . $isBot . $this->_useragent($task->id) . $privateKey);
        $serverHashAdblock = md5(yt_vid($task->url) . $task->id . '1' . $isBot . $this->_useragent($task->id) . $privateKey);

        if ($clientHash != $serverHash && $clientHash != $serverHashAdblock) {
            $this->output->json(array('location' => site_url('client')));
        }

        // Определение adblock
        $clientAdblock = ($clientHash == $serverHashAdblock);

        // Cost rule
        $costRule = $clientAdblock ? COST_ADBLOCK : COST_AJAX;

        // проверяем статус выполнения
        if ($this->Complete->isFinished($this->user->id, $task)) {
            $this->output->json($this->lang->line('error_task_done'));
        }

        // проверяем доступность средств
        if ($task->total_cost < $task->action_cost) {
            $this->output->json($this->lang->line('error_end_task_budget'));
        }

        // проверка по HTTP_REFERER
        $referer = $this->input->server('HTTP_REFERER');
        if (!preg_match('#.*(ytuber.ru|ytubey.com|ytuber.com)/client(/\d+)*#', $referer)) {
            $this->output->json($this->lang->line('error_window_close_early'));
        }

        // Проверка стартовой метки и прошедшего времени
        $complete = $this->Complete->getWaiting($this->user->id, $task->id);
        if (!$complete OR time() < $complete->time + $complete->timeout) {
            $this->output->json($this->lang->line('error_window_close_early'));
        }

        // Возраст канала
        if ($this->user->channel_published > 0) {
            $channel_age = time() - strtotime($this->user->channel_published);
            $channel_age = intval($channel_age / 86400);

            if ($channel_age < 90) {
                $costRule = COST_PENALTY;
            }
        }

        if (!$this->Task->decrease($complete->task_id, $complete->action_cost)) {
            $this->output->json($this->lang->line('error_end_task_budget'));
        }

        // Перевод средств
        $this->Transfer->completeToUser($complete->id, $costRule);

        // Меняем статус на COMPLETE_FINISHED
        $this->Complete->setStatus($complete->id, COMPLETE_FINISHED);

        // Сообщаем о выполнении
        $this->output->json(
            array(
                'status' => 'success',
                //'text' => 'ok',
                //'user_balance' => $this->user->balance
            )
        );
    }

    function _useragent($id)
    {
        $useragent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';

        $idstr = $id;
        $fchar = $idstr[0];
        $lchar = $idstr[strlen($idstr) - 1];

        if ($fchar > $lchar) {
            $nchar = $fchar - $lchar;
        } else {
            $nchar = $lchar - $fchar;
        }

        if ($nchar < 3) {
            $nchar = 3;
        }

        $agent = '';
        for ($i = 0; $i < strlen($useragent); $i = $i + $nchar) {
            $agent = $agent . $useragent[$i];
        }

        return $agent;
    }
}
//

/* End of file yt.php */
/* Location: ./application/controllers/yt.php */