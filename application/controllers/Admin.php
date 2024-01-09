<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use Cocur\BackgroundProcess\BackgroundProcess;

class Admin extends CI_Controller
{

    private $name = 'admin';

    public function __construct()
    {
        parent::__construct();

        $this->load->helper('user');
        $this->user = get_user();

        if (!$this->user) {
            redirect('auth/login');
        }

        if (!$this->user->admin && !$this->user->moderator) {
            show_404();
        }

        $this->load->library("pagination");

        $this->load->model('Task_Model', 'Task');
        $this->load->model('Category_Model', 'Category');
        $this->load->model('Type_Model', 'Type');
        $this->load->model('User_Model', 'User');
        $this->load->model('Payments_Model', 'Payments');
    }

    function test() {

        $process = new BackgroundProcess('sleep 5');
        $process->run();

        echo sprintf('Crunching numbers in process %d', $process->getPid());
        while ($process->isRunning()) {
            echo '.';
            sleep(1);
        }
        echo "\nDone.\n";
    }
	
    function index()
    {
        $data['pageTitle'] = 'Панель администратора';
        $this->tpl->load('admin/index', $data);
    }

    function generate_client_javascript()
    {
        $this->load->helper('strgen');
        $abSet = 'qazxswedcvfrtgbnhyujmkiolpQAZXSWEDCVFRTGBNHYUJMKIOLP';

        $path = APPPATH . '../static/client/';

        $file = file_get_contents($path . 'in_fglm345sdfg.js');

        $tmpname = 'tmp_fdhrth456jd.js';

        for ($i = 0; $i < 10; $i++) {
            $filename = strgen(16) . '.js';
            $private_key = strgen(16);

            $replace = array(
                'MD5' => strgen(8, $abSet),
                'video_window' => strgen(8, $abSet),
                '{private_key}' => $private_key
            );

            $data = str_replace(array_keys($replace), $replace, $file);

            //echo $data; exit;

            file_put_contents($path . $tmpname, $data);

            // Обфускация кода
            if (is_file($path . $tmpname)) {
                $param = " --deadCodeInjection true --deadCodeInjectionThreshold 1 --controlFlowFlattening true --controlFlowFlatteningThreshold 1 --selfDefending true --mangle true --rotateStringArray true --stringArray true --stringArrayEncoding 'rc4' --stringArrayThreshold 1";

                echo shell_exec('javascript-obfuscator static/client/' . $tmpname . ' --output static/client/' . $filename . $param);
            }

            // Добавление записи в бд
            if (is_file($path . $filename)) {
                $data = array(
                    'private_key' => $private_key,
                    'filename' => $filename,
                    'time' => date('Y-m-d H:i:s')
                );
                $this->db->insert('client_js', $data);
            }

            unlink($path . $tmpname);

            echo $private_key . ' - ' . $filename . '<br>';
        }

    }

    function generate_client_test_javascript()
    {
        $this->load->helper('strgen');
        $path = APPPATH . '../static/js/';
        $file = file_get_contents($path . 'client_test_orig.js');

        $filename = 'client_test_' . strgen(8) . '.js';

        // Обфускация кода
        if (is_file($path . 'client_test_orig.js')) {
            $param = " --deadCodeInjection true --deadCodeInjectionThreshold 1 --controlFlowFlattening true --controlFlowFlatteningThreshold 1 --selfDefending true --mangle true --rotateStringArray true --stringArray true --stringArrayEncoding 'rc4' --stringArrayThreshold 1";

            echo shell_exec('javascript-obfuscator static/js/client_test_orig.js --output static/js/' . $filename . $param);
        }
    }
	
	function user_comment_penaltys()
	{
		$id = (int)$this->uri->segment(3);
		$this->load->model('Penalty_Model', 'Penalty');
        $query = $this->Penalty->UserCommentPenaltys($id);
        $data['result'] = $query;
        $this->tpl->load('admin/user_penalty_comment.php', $data);
	}
	
	function banByChannels(){
	$array = explode("\r\n",$this->input->post('channelList'));
	$channels = array_unique($array);
	foreach($channels as $channel){
	$this->db->where('channel', $channel);
	$query = $this->db->get('user');
	$reason = "2.8";
	$user = $query->row();
	$user_id = $user->id;
	
	$this->_userBan($user_id, 86400 * 365 * 3, $reason);
	}
	redirect('admin');
	}
	
	function goToUserFromChannel(){
		$channel = $this->input->post('userchannel');
		$this->db->where('channel', $channel);
		$query = $this->db->get('user');
		$user = $query->row();
		$user_id = $user->id;
		redirect('admin/user/'.$user_id);
	}
	
    function user_subsribe_penaltys()
	{
        $this->load->model('Complete_Model', 'Complete');
		$user_id = (int)$this->uri->segment(3);
        $result = $this->Complete->getPenalty($user_id, null);
        $data['result'] = $result;

        print_r($result);
        
        $this->tpl->load('admin/user_subsribe_penaltys.php', $data);
	}

    function banned_sum_balance()
    {

    }

    function ban_with_ref()
    {
        $user_id = 330056;

        $query = $this->db->query('SELECT id FROM user WHERE referrer_id=' . (int)$user_id);

        foreach ($query->result() as $user) {
            $this->_userBan($user->id, 86400 * 365 * 3, '2.8');
        }
        $this->_userBan($user_id, 86400 * 365 * 3, '2.8');
    }
	
	function CurrentUserBan($currentuser){
		echo "ban user... " . $currentuser;
		$user_id = $currentuser;
        $this->_userBan($user_id, 86400 * 365 * 3, '2.8');
	}
	
    function user_ban()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('user_id', 'User Id', 'trim|required|integer');
        $this->form_validation->set_rules('reason', 'Reason', 'trim|required');

        if ($this->form_validation->run()) {
            $user_id = (int) $this->input->post('user_id');
            $reason = $this->input->post('reason');

            //$user_id = (int)$this->uri->segment(3);
            $this->_userBan($user_id, 86400 * 365 * 3, $reason);

            echo 'ok';
        }
        else {
            echo 'false';
        }

    }
	function user_recaptha_score_change(){
		 $user_id = $this->uri->segment(3);
		    $data = array(
            'recaptcha_score' => '0.9'
        );
		$this->User->updateItem((int)$user_id, $data);
		redirect('admin/user/'.$user_id);
	}
		function setactivity(){
		 $user_id = $this->uri->segment(3);
		    $data = array(
            'activity' => '1'
        );
		$this->User->updateItem((int)$user_id, $data);
		redirect('admin/user/'.$user_id);
	}
		function checkactivity(){
		 $user_id = $this->uri->segment(3);
		 $user = $this->User->getItem($user_id);
		 
		 $data = array(
            'activity' => '0'
			);
               try {

                    //Проверяем активность
                    $dev = google_youtube_developer();
                    $activity = $dev->activities->listActivities('snippet', array('channelId' => $user->channel));

                    if (isset($activity->getpageInfo()->totalResults))
                    {
                        $data['activity'] = $activity->getpageInfo()->totalResults;
                    }
                }
                catch (Exception $e)
                {
                    $data['activity'] = 0;
                }

        $data['activity_updated_at'] = date('Y-m-d H:i:s');
		$this->User->updateItem((int)$user_id, $data);
		redirect('admin/user/'.$user_id);
	}
    function user_unban() {
        $user_id = $this->uri->segment(3);

        $data = array(
            'banned' => 0,
            'ban_reason' => ''
        );

        $this->User->updateItem((int)$user_id, $data);

        redirect('admin/user/'.$user_id);
    }
		
	function user_noavatar() {
		
            $reason = 'no avatar, image';
			$user_id = (int)$this->uri->segment(3);
            $this->_userBan($user_id, 86400, $reason);
			
			redirect('admin/users_top');
    }

    function _userBan($user_id, $time, $reason, $tasksDisable = true)
    {
        $data = array(
            'banned' => time() + $time,
            'ban_reason' => $reason
        );
        $this->User->updateItem((int)$user_id, $data);

        if ($tasksDisable) {
            $this->db->where('user_id', (int)$user_id);
            $this->db->update('task', array('disabled' => 1));
        }
    }

    function _userUnban($user_id)
    {
        $data = array(
            'banned' => 0,
            'ban_reason' => ''
        );
        $this->User->updateItem((int)$user_id, $data);
    }

    function cron_log()
    {
        $file = $this->uri->segment(3);

        $result = '';

        if (is_file(APPPATH . 'logs/cron/' . $file . '.log')) {
            $data['pageTitle'] = 'Cron log for "' . $file . '"';

            $arr = file(APPPATH . 'logs/cron/' . $file . '.log');
            $arr = array_reverse($arr);

            $result = '<pre style="line-height: 0.8;">';
            foreach ($arr as $k => $val) {
                if ($k >= 1000) break;
                $result .= $val . "\r\n";
            }
            $result .= '</pre>';

            $data['result'] = $result;
            $this->tpl->load('admin/blank', $data);
        } else {
            show_404();
        }
    }


    function transactions_top()
    {
        $recipients = $senders = array();

        $query = $this->db->query('SELECT COUNT(sender) as transactions, SUM(sum) as total, recipient FROM transaction GROUP BY recipient ORDER BY transactions DESC;');
        foreach ($query->result() as $row) {
            if ($this->User->allPaymentsSum($row->recipient) < 100) {
                $recipients[] = $row->recipient;
            }
            if ($row->transactions > 50) {
                $qw = $this->db->query('SELECT sender FROM transaction WHERE recipient = ' . $row->recipient . ' GROUP BY sender');
                foreach ($qw->result() as $r) {
                    if ($this->User->allPaymentsSum($r->sender) < 100) {
                        $senders[] = $r->sender;
                    }
                }
            }
        }
        echo count($senders);
        print_r($users);
    }

    function payout()
    {
        $this->load->model('Payout_Model', 'Payout');

        // Совершение выплаты по id
        $payout_id = (int)$this->input->get('payout_id');
        if ($payout_id) {
            $date = date('Y-m-d H:i:s');
            $this->Payout->updateItem($payout_id, array('payed' => $date));
            $this->output->json(array('date' => $date));
        }

        $data['pageTitle'] = 'Выплаты';

        //$data["result"] = $this->Payout->getUnpayedItems();

        // pagination
        $config = $this->config->item('pagination');
        $config['base_url'] = base_url($this->name . '/payout');
        $config['total_rows'] = $this->Payout->getItemsTotal();
        $config['uri_segment'] = 3;
        $config['per_page'] = 18;
        $this->pagination->initialize($config);

        $page = (int)$this->uri->segment($config['uri_segment']);

        $data["result"] = $this->Payout->getItems($config["per_page"], $page);
        $data['pagination'] = $this->pagination->create_links();


        $this->tpl->load('admin/payout', $data);
    }

    function refunds()
    {

        $this->load->model('Refund_Model', 'Refund');

        $data['pageTitle'] = 'Возвраты';

        // pagination
        $config = $this->config->item('pagination');
        $config['base_url'] = base_url($this->name . '/refunds');
        $config['total_rows'] = $this->Refund->getRefundsTotal();
        $config['uri_segment'] = 3;
        $config['per_page'] = 18;
        $this->pagination->initialize($config);

        $page = (int)$this->uri->segment($config['uri_segment']);

        $data["result"] = $this->Refund->getRefunds($config["per_page"], $page);
        $data['pagination'] = $this->pagination->create_links();


        $this->tpl->load('admin/table', $data);
    }

    function payments()
    {
        $data['pageTitle'] = 'Оплаты';

        // pagination
        $config = $this->config->item('pagination');
        $config['base_url'] = base_url($this->name . '/payments');
        $config['total_rows'] = $this->Payments->getPaymentsTotal();
        $config['uri_segment'] = 3;
        $config['per_page'] = 18;
        $this->pagination->initialize($config);

        $page = (int)$this->uri->segment($config['uri_segment']);

        $data["results"] = $this->Payments->getPayments($config["per_page"], $page);
        $data['pagination'] = $this->pagination->create_links();


        $this->tpl->load('admin/payments', $data);
    }

    /* Users */
    function users()
    {
        $data['pageTitle'] = 'Пользователи';

        // pagination
        $config = $this->config->item('pagination');
        $config['base_url'] = base_url($this->name . '/users');
        $config['total_rows'] = $this->User->getUsersTotal();
        $config['uri_segment'] = 3;
        $config['per_page'] = 18;
        $this->pagination->initialize($config);

        $page = (int)$this->uri->segment($config['uri_segment']);

        $data["results"] = $this->User->getUsers($config["per_page"], $page);
        $data['pagination'] = $this->pagination->create_links();

        $this->tpl->load('admin/users', $data);
    }

    function users_top()
    {
        $type_id = (int)$this->uri->segment(3);
        $limit = 100;


        $data['pageTitle'] = 'ТОП по выполнениям задач (24ч)';

        $time = time() - 3600;

        $where = "d.time > {$time}";
        $where .= $type_id ? " AND d.type_id = {$type_id}" : '';
		
        $sql = "
            SELECT avatar, u.id, u.channel, u.channel_published, u.done, u.balance, u.lastip, u.mail, COUNT(d.user_id) as counter, recaptcha_score FROM done d
            LEFT JOIN user u ON(u.id = d.user_id)
            WHERE {$where}
            GROUP BY d.user_id
            ORDER BY counter DESC
            LIMIT 500
        ";
        $data['result'] = $this->db->query($sql)->result();

        foreach($data['result'] as &$item) {
            $item->id = anchor('admin/user/'.$item->id, $item->id);
        }

        $this->tpl->load('admin/table', $data);
    }

    function users_top_purchase()
    {

        if (!$this->user->admin) {
            show_404();
        }

        $data['pageTitle'] = 'ТОП по оплатам';

        $time = time() - (60 * 60 * 24 * 30);
        $where = "p.time > {$time}";

        $sql = "
        	SELECT u.id, u.referrer_id, u.name, u.channel, u.balance, u.done, u.lastip, u.lastseen, SUM(amount) as total, COUNT(amount) as count FROM payments p
        	LEFT JOIN user u ON(u.id = p.user_id)
        	WHERE p.status = 1 AND {$where}
            GROUP BY p.user_id
            ORDER BY total DESC
        ";
        $data['result'] = $this->db->query($sql)->result();

        $this->tpl->load('admin/table', $data);
    }

    function user()
    {
        $id = (int)$this->uri->segment(3);

        $data['pageTitle'] = 'Информация о пользователе #' . $id;
        $data['id'] = $id;
        $this->tpl->load('admin/user', $data);
    }

    function user_info()
    {
        $id = (int)$this->uri->segment(3);

        $data['pageTitle'] = 'Информаци о пользователе #' . $id;

        if ($user = $this->User->getItem($id)) {
            $user->password = '***';
            $data['result'] = $user;
        }

        $this->tpl->load('admin/table', $data);
    }

    function user_transactions()
    {
        $id = (int)$this->uri->segment(3);

        $data['pageTitle'] = 'Информация о переводах пользователя #' . $id;
        // pagination
        $config = $this->config->item('pagination');
        $config['base_url']    = base_url($this->name.'/user_transactions/'.$id);
        $config['total_rows']  = $this->User->getTransactionsTotal($id);
        $config['uri_segment'] = 4;
        $this->pagination->initialize($config);

        $page = (int) $this->uri->segment($config['uri_segment']);

        $data["result"] = $this->User->getTransactions($id, $config["per_page"], $page);
        $data['pagination'] = $this->pagination->create_links();

        $this->tpl->load('admin/table', $data);
    }

    function user_payments()
    {
        $id = (int)$this->uri->segment(3);

        $data['pageTitle'] = 'Информация о платежах пользователя #' . $id;

        $this->db->where('user_id', (int)$id);
        $this->db->order_by("created", "desc");
        $query = $this->db->get('payments');
        $data['result'] = $query->result();

        foreach ($data['result'] as &$item) {
            unset($item->detail, $item->comission);
            $item->created = date('Y.m.d H:i', $item->created);
            $item->time = date('Y.m.d H:i', $item->time);
        }

        $this->tpl->load('admin/table', $data);
    }

    function user_refunds()
    {
        $id = (int)$this->uri->segment(3);

        $data['pageTitle'] = 'Информация о возвратах пользователя #' . $id;

        $this->db->where('user_id', (int)$id);
        $this->db->order_by("created_at", "desc");
        $query = $this->db->get('refund');
        $data['result'] = $query->result();

        $this->tpl->load('admin/table', $data);
    }

    function user_channelinfo()
    {
        $this->load->helper('google');

        $id = (int)$this->uri->segment(3);
        $part = $this->uri->segment(4) ? $this->uri->segment(4) : 'id';
        $user = $this->User->getItem($id);

        $data['pageTitle'] = 'Информация о канале пользователя #' . $id;


        $text = '<h3>Информация от пользователя</h3>';

        // Получаем авторизацию от пользователя
        $yt = google_auth_youtube($user, false);
        if (!$yt) {
            $text .= "<pre>no user auth</pre>";
        } else {

            try {
                $listChannels = $yt->channels->listChannels($part, array('mine' => true));

                $detectChannel = $listChannels->getItems()[0]->getId();
                if (!empty($detectChannel)) {
                    $text .= '<p>Канал: <code>' . $detectChannel . '</code></p>';
                    $user->channel = $detectChannel;
                }
                $text .= '<pre>' . print_r($listChannels, true) . '</pre>';
            } catch (Exception $e) {
                $text .= '<pre>' . print_r($e->getMessage(), true) . '</pre>';
            }

        }

        // По developer-key
        $dev = google_youtube_developer();
        $listChannelsDev = $dev->channels->listChannels($part, array('id' => $user->channel));
        $text .= '<h3>Информация от девелопера</h3>';
        $text .= '<pre>' . print_r($listChannelsDev, true) . '</pre>';

		
		//Активность
		$text .= '<h3>Активность канала</h3>';
		$activechannel = $user->channel;
		$activ = $dev->activities->listActivities('snippet', array('channelId' => $activechannel));
        $text .= '<pre>' . print_r($activ, true) . '</pre>';
		
        $data['result'] = $text;

        $this->tpl->load('admin/blank', $data);
    }


    function user_tasks()
    {
        $id = (int)$this->uri->segment(3);

        if ($id > 0 && $tasks = $this->Task->getItems($id)) {

            foreach ($tasks as &$item) {
                // тип
                $type = $this->Type->getItem($item->type_id);
                $item->type_id = isset($type->name) ? $type->name : '-';
            }

            $data['pageTitle'] = 'Задачи пользователя #' . $id;
            $data['result'] = $tasks;
        }
        $this->tpl->load('admin/table', $data);
    }

    function user_stat()
    {
        $id = (int)$this->uri->segment(3);

        $types = $this->Type->getAllItems();

        foreach ($types as $type) {

        }

        $this->db->select('COUNT(id) as total, type_id, status, cost_rule');
        $this->db->where('user_id', $id);
        $this->db->where('time >', time() - (86400 * 30));
        $this->db->group_by('type_id, status, cost_rule');
        $query = $this->db->get('done');

        echo '<pre>';
        print_r($query->result());
    }


    function task_done()
    {

        $task_id = (int)$this->uri->segment(3);

        $this->db->where('task_id', $task_id);
        $query = $this->db->get('done');

        $ipv6 = 0;
        $ipv4 = 0;
        $users = array();
        $ips = array();
        foreach ($query->result() as $item) {

            // тип ip
            $ip = inet_ntop($item->ip_bin);
            $is_ipv6 = filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6);

            if ($is_ipv6) {
                $ipv6++;
            } else {
                $ipv4++;
            }

            // повторные выполнения по пользователям
            if (isset($users[$item->user_id])) {
                $users[$item->user_id]++;
            } else {
                $users[$item->user_id] = 1;
            }

            // повторные выполнения по ip
            if (isset($ips[$ip])) {
                $ips[$ip]++;
            } else {
                $ips[$ip] = 1;
            }

        }

        echo '<h1>Статистика по выполнению задачи ' . $task_id . '</h1>';

        echo 'ipv4: ' . $ipv4 . ', ipv6: ' . $ipv6;

        echo '<h2>Повторные выполнения по пользователям</h2>';
        foreach ($users as $user_id => $count) {
            if ($count > 1) {
                echo $user_id . ' - ' . $count . '<br/>';
            }
        }

        echo '<h2>Повторные выполнения по ip</h2>';
        foreach ($ips as $ip => $count) {
            if ($count > 1) {
                echo $ip . ' - ' . $count . '<br/>';
            }
        }
    }

    function penalty_spam()
    {
        $this->load->model('Penalty_Model', 'Penalty');

        $data['pageTitle'] = 'Штрафы за спам';
        $data['result'] = $this->Penalty->getAllItems();
        $this->tpl->load('admin/table', $data);
    }
}
//

/* End of file task.php */
/* Location: ./application/controllers/task.php */