 <?php
class User extends CI_Controller {
 
 	private $name = 'user';

	function __construct()
	{
		parent::__construct();
		$this->load->model('User_Model', 'User');
	    $this->load->library("pagination");

        $this->load->helper('user');
    	$this->user = get_user();

		if(!$this->user) {
			redirect('auth/login');
		}

	    $this->load->helper('user');
	    $this->lang->load('user');
	}


    /* Paycode */
    function paycode() 
    {
        $this->load->model('Paycode_Model', 'Paycode');

        $data['pageTitle'] = 'Предоплаченный код';

        $this->load->library('form_validation');
        $this->form_validation->set_rules('paycode', 'Код', 'trim|required|xss_clean|callback__paycode');

        if($this->form_validation->run()) {
            $this->session->set_flashdata('success', "Код на сумму <b>".$this->input->post('paycode')."</b> зачислен на ваш счет.");
            redirect('user/paycode');
        }

        $this->tpl->load('user/paycode', $data);
    }

    function _paycode($code) 
    {
        if($item = $this->Paycode->getItem($code)) {
            $this->User->increaseBalance($this->user->id, $item->sum);
            $this->Paycode->removeItem($item->id);
            return $item->sum;
        }
        else {
            $this->form_validation->set_message('_paycode', 'Указанный код не найден.');
            return false;
        }
    }


	/* Referrals */
	function referrals () 
	{
		$this->_mustBeLogged();

		$data = array();
		$data['pageTitle'] = $this->lang->line('referrals_title');

		// top 
		$query = $this->db->query("SELECT id, name, done, earned FROM user WHERE earned > 0 AND referrer_id = {$this->user->id} ORDER BY earned DESC LIMIT 5");
		$data['top'] = $query->result();

		// act
		//$date = date('Y-m-d H:i:s', time() - (3 * 86400));
		//$query = $this->db->query("SELECT COUNT(id) as total FROM user WHERE referrer_id = {$this->user->id} AND lastseen > '{$date}'")->row();
		$data['total_act'] = $this->User->getActiveReferralsTotal($this->user->id);

		// total
		$data['total_refferals'] = $this->User->getReferralsTotal($this->user->id);

		// earned
		$query = $this->db->query("SELECT SUM(earned) as total FROM user WHERE earned > 0 AND referrer_id = {$this->user->id}")->row();
		$data['total_earned'] = $query ? floatval($query->total) : 0;

		// pagination
		$config = $this->config->item('pagination');
		$config['base_url']    = base_url($this->name.'/referrals');
		$config['total_rows']  = $data['total_refferals']; //$this->User->getReferralsTotal($this->user->id);
		$config['uri_segment'] = 3;
		$config['per_page']	   = 18;
        $this->pagination->initialize($config);

		$page = (int) $this->uri->segment($config['uri_segment']);

		$data["results"] = $this->User->getReferrals($this->user->id, $config["per_page"], $page);
		$data['pagination'] = $this->pagination->create_links();

		$this->tpl->load('user/referrals', $data);
	}
        
	/* Transaction */
	function transaction () 
	{

		$this->_mustBeLogged();

		$data = array();
		$data['pageTitle'] = $this->lang->line('transaction_title');

		$this->load->library('form_validation');		

		$data['error'] = null;

		// Бан пользователя
		$user = $this->User->getItem($this->user->id);
		if($user->banned > time()) {
            $data['error'] = sprintf($this->lang->line('error_banned'), date('d.m.Y H:i', $user->banned), $user->ban_reason);
		}

		$this->form_validation->set_rules('recipient', $this->lang->line('recipient'), 'trim|required|integer|callback__recipient|callback__payer');
		$this->form_validation->set_rules('sum', $this->lang->line('transaction_sum'), 'trim|required|numeric|greater_than[0.1]|less_than[50000]|callback__sum');
	

		if($this->form_validation->run() && !$data['error']) {
			$transaction = $this->User->makeTransaction($this->user->id, $this->input->post('recipient'), $this->input->post('sum'), true);
			if($transaction) {
				// письмо получателю
				$recipient = $this->User->getItem($this->input->post('recipient'));
				if($recipient && $recipient->sub_transaction) {
					$this->load->helper('mail');
					mail_send_tpl($recipient->mail, $this->lang->line('subject_transaction'), 'user_transaction.php', $this->user);
					//$text = "Пользователь <b>#{$this->user->id}</b> перевел вам <b>{$this->input->post('sum')}</b> балл(а/ов).";
					//mail_send($recipient->mail, 'Перевод средств', $text);
				}

				$this->session->set_flashdata('success', $this->lang->line('success_transaction'));
				redirect('user/transaction');
			}
		}

		// pagination
		$config = $this->config->item('pagination');
		$config['base_url']    = base_url($this->name.'/transaction');
		$config['total_rows']  = $this->User->getTransactionsTotal($this->user->id);
		$config['uri_segment'] = 3;
        $this->pagination->initialize($config);

		$page = (int) $this->uri->segment($config['uri_segment']);

		$data["results"] = $this->User->getTransactions($this->user->id, $config["per_page"], $page);
		$data['pagination'] = $this->pagination->create_links();

		$this->tpl->load('user/transaction', $data);
	}


	/* Setting */
	function setting() 
	{
		$this->_mustBeLogged();

		$data = array();
		$data['pageTitle'] = $this->lang->line('setting_title');



        $this->load->helper('google');
        // Получаем авторизацию от пользователя
        $data['channel'] = NULL;
 
		$this->load->library('form_validation');

		$config = array(
	        array(
                'field' => 'name',
                'label' => $this->lang->line('name'),
                'rules' => 'trim|required'
	        ),
	        array(
                'field' => 'password',
                'label' => $this->lang->line('password'),
                'rules' => 'trim|min_length[5]|max_length[16]'
	        ),
	        array(
                'field' => 'password_confirm',
                'label' => $this->lang->line('password_confirm'),
                'rules' => 'trim|min_length[5]|max_length[16]|callback__password_confirm'
	        ),
	        array(
                'field' => 'sub_news',
                'label' => '',
                'rules' => 'trim'
	        ),
	        array(
                'field' => 'sub_transaction',
                'label' => '',
                'rules' => 'trim'
	        ),
	        array(
                'field' => 'sub_statistic',
                'label' => '',
                'rules' => 'trim'
	        ),
	        array(
                'field' => 'sub_notification',
                'label' => '',
                'rules' => 'trim'
	        ),
	        array(
                'field' => 'soc_youtube',
                'label' => '',
                'rules' => 'trim|callback__soc_youtube'
	        ),
	        array(
                'field' => 'soc_vk',
                'label' => '',
                'rules' => 'trim|callback__soc_vk'
	        ),
	        array(
                'field' => 'soc_twitter',
                'label' => '',
                'rules' => 'trim|strtolower|callback__soc_twitter'
	        ),
		);
		
		$this->form_validation->set_rules($config);

		if($this->form_validation->run()) {
			// save data
			//$post = $this->input->post();
			if($this->input->post('resend_confirm') && !empty($this->user->confirm)) {
				// высылаем ссылку для подтверждения
				$this->load->helper('mail');
				mail_send_tpl($this->user->mail, $this->lang->line('subject_confirm'), 'user_setting.php', $this->user);

				$data['success'] = $this->lang->line('success_confirm');
			}
			if($this->input->post('api_key_generate')) {
				// генерируем новый api_key
				if($this->User->generateApiKey($this->user->id)) {
					$data['success'] = $this->lang->line('success_api');
				} 
			}

			$updateData = array(
				'name'				=> $this->input->post('name', true),
				'sub_news'			=> (booL)$this->input->post('sub_news'),
				'sub_transaction'	=> (bool)$this->input->post('sub_transaction'),
				'sub_statistic'		=> (bool)$this->input->post('sub_statistic'),
				'sub_notification'	=> (bool)$this->input->post('sub_notification'),
				//'soc_vk'			=> $this->input->post('soc_vk'),
				//'channel'			=> $this->input->post('soc_youtube'),
				//'soc_twitter'		=> mb_strtolower($this->input->post('soc_twitter'))
			);

			if($this->input->post('soc_vk')){
				$updateData['soc_vk'] = $this->input->post('soc_vk');
			}

			if($this->input->post('soc_twitter')){
				$updateData['soc_twitter'] = $this->input->post('soc_twitter');
			}

			if($this->input->post('soc_youtube')){
				$updateData['channel'] = $this->input->post('soc_youtube');
			}

			if($this->input->post('password')) {
				$updateData['password'] 		= $this->input->post('password');
				$updateData['password_hash']	= password_hash($this->input->post('password'), PASSWORD_BCRYPT);
			}

			if($this->User->updateItem($this->user->id, $updateData)) {
				$data['success'] = $this->lang->line('success_update');
			}
		}

		$data['user'] = $this->User->getItem($this->user->id); 

		$this->tpl->load('user/setting', $data);
	}

 	function _payer() {
		return true;
 	}

	/* _recipient */
	function _recipient($id) 
	{
		if(!$this->User->getItem((int)$id)) {
			$this->form_validation->set_message('_recipient', $this->lang->line('error_recipient_id'));
			return false;
		}
		else if ((int)$id == $this->user->id) {
			$this->form_validation->set_message('_recipient', $this->lang->line('error_recipient_self'));
			return false;
		}

		return true;
	}

	/* _sum */
	function _sum($sum) 
	{
	    $this->load->model('Complete_Model', 'Complete');
		$me = $this->User->getItem((int)$this->user->id);
		// сумма баллов по выполненным задачам за неделю
		//$remain = $this->Complete->getUserFinishedCostSum($this->user->id, 86400*7);
		$remain = 500;

		/*if(!$me->channel_available) {
			$this->form_validation->set_message('_sum', 'Вы не можете переводить баллы.');
			return false;
		}*/
		if(!$me OR $me->balance < $sum) {
			$this->form_validation->set_message('_sum', $this->lang->line('error_sum_few'));
			return false;
		}
		
		else if($me->done < 1000) {
			$this->form_validation->set_message('_sum', $this->lang->line('error_sum_done_limit'));
			return true;
		}
		else if(!$me OR ($me->balance-$remain) < $sum) {
			$this->form_validation->set_message('_sum', sprintf($this->lang->line('error_sum_remain'), $remain));
			return false;
		}
		return true;
	}

	/* _password_confirm */
	function _password_confirm($password_confirm) 
	{
		$password = $this->input->post('password');
		if($password_confirm === $password) {
			return true;
		}
		else if(empty($password_confirm) && empty($password)) {
			return true;
		}
		else {
			$this->form_validation->set_message('_password_confirm', $this->lang->line('error_password_confirm'));
			return false;
		}
	}

	function _soc_youtube($soc_youtube) 
	{
		if(empty($soc_youtube))
		{
			$result = true;
		}

		else if(preg_match('#([^\/\?&]{24})(\?|$)#u', $soc_youtube, $match)) 
		{
			$result = true;

			$channel = $match[1];
			$result = $channel;

			if(!$this->User->isUnique('channel', $channel, $this->user->id)) {
				$result = false;
				$error = 'Этот Youtube-канал уже к другому аккаунту.';
			}
		}

		else {
			$result = false;
			$error = 'Введите корректную ссылку на свою Youtube-канал (https://www.youtube.com/channel/UCSLkl3Jcgh2jFd1_Wg6eTQA).';
		}


		if(!$result && isset($error)) {
			$this->form_validation->set_message('_soc_youtube', $error);
			return $result;
		} 

		return $result;
	}
	
	function _soc_vk($soc_vk) {

		// Ссылка может быть не указана
		if(empty($soc_vk)) {
			$result = true;
		}
		// Если ссылка указана, то только vk-страница пользователя
		else if(preg_match('#^https://vk.com/id([0-9]+)$#i', $soc_vk, $match)) {
			$result = true;

			//$json = file_get_contents('https://api.vk.com/api.php?oauth=1&v=5&method=users.get&user_ids='.$match[1]);
			//$data = json_decode($json);

			//if(!isset($data->response[0]->id)) {
			//	$result = false;
			//	$error = 'Не найдена указанная VK-страница.';
			//}
			//else {
				//$link = 'https://vk.com/id'.$data->response[0]->id;
				$link = $soc_vk;
				$result = $link;

				if(!$this->User->isUnique('soc_vk', $link, $this->user->id)) {
					$result = false;
					$error = 'Ссылка на данную VK-страницу уже привязана к другому аккаунту.';
				}
			//}
		}
		else {
			$result = false;
			$error = 'Введите корректную ссылку на свою страницу VK (https://vk.com/<b>id123</b>).';
		}
		
		if(!$result && isset($error)) {
			$this->form_validation->set_message('_soc_vk', $error);
			return $result;
		} 

		return $result;
	}

	function _soc_twitter($soc_twitter) {

		// Ссылка может быть не указана
		if(empty($soc_twitter)) {
			$result = true;
		}
		// Если ссылка указана, то только vk-страница пользователяhttps://twitter.com/lukyanov_oleg
		else if(preg_match('#^https://twitter.com/([a-z0-9_-]+)$#', $soc_twitter)) {
			$result = true;
			if(!$this->User->isUnique('soc_twitter', $soc_twitter, $this->user->id)) {
				$result = false;
				$error = 'Ссылка на данную Twitter-страницу уже привязана к другому аккаунту.';
			}
		}
		else {
			$result = false;
			$error = 'Введите корректную ссылку на свою страницу Twitter.';
		}
		
		if(!$result && isset($error)) {
			$this->form_validation->set_message('_soc_twitter', $error);
			return $result;
		} 

		return $result;
	}

	/*
	function _soc_fb($soc_fb) {

		// Ссылка может быть не указана
		if(empty($soc_fb)) {
			$result = true;
		}
		// Если ссылка указана, то только vk-страница пользователяhttps://twitter.com/lukyanov_oleg
		else if(preg_match('#^https://www.facebook.com/([\.a-z0-9_-]+)$#', $soc_fb)) {
			$result = true;
			if(!$this->User->isUnique('soc_fb', $soc_fb, $this->user->id)) {
				$result = false;
				$error = 'Ссылка на данную Facebook-страницу уже привязана к другому аккаунту.';
			}
		}
		else {
			$result = false;
			$error = 'Введите корректную ссылку на свою страницу Facebook.';
		}
		
		if(!$result && isset($error)) {
			$this->form_validation->set_message('_soc_fb', $error);
			return $result;
		} 

		return $result;
	}
	*/

	/* _mustBeLogged */
	function _mustBeLogged() 
	{
		if(!$this->user) {
			redirect('auth/login'); 
		} 
	}

}