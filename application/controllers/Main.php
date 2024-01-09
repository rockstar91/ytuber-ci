<?php
class Main extends CI_Controller {

	function __construct()
	{
		parent::__construct();

        $this->load->helper('user');
    	$this->user = get_user();

		$this->lang->load('main');
	}

	public function comleteTest()
	{
		$this->load->model('Complete_Model', 'Complete');
		$result = $this->Complete->getItemsBy(0);
		print_r($result);
	}

	public function isGplusUser()
	{
        $this->load->model('Task_Model', 'Task');
        $this->load->model('User_Model', 'User');

        $this->db->where('task_id', 859826);
        $this->db->where('status', COMPLETE_FINISHED);

        $query = $this->db->get('done');

        foreach($query->result() as $complete)
        {
        	$user = $this->User->getItem($complete->user_id);

	        $key  = 'AIzaSyCZ-DOCr20LHyEVzcl5ehC6q6-kAWu9CSM';
            $link = 'https://www.googleapis.com/plus/v1/people/'.$user->gid.'?key='.$key;


			$c = curl_init($link);
			curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
			$content = curl_exec($c);

            //$json = file_get_contents($link);
            $data = json_decode($content);

            echo $user->channel.'	'.$user->gid.'	';

            if(isset($data->error->code) && $data->error->code == 404)
            {
            	echo "404 \r\n";
            }
            else
            {
            	echo "ok \r\n";
            }

        }
	}

    public function recaptcha3()
    {
        $this->load->helper('recaptcha');

    	$post = $this->input->post();

    	if(count($post) > 0 && recaptcha_verify())
    	{
    		echo '<h1>ok</h1>';
    	}

		$this->load->view('main/recaptcha3');
    }

    public function recaptcha_verify()
    {
        $this->load->model('User_Model', 'User');

        $siteKey = $this->config->item('recaptcha3')['pub'];;
        $secret = $this->config->item('recaptcha3')['secret'];

        // Effectively we're providing an API endpoint here that will accept the token, verify it, and return the action / score to the page
        // In production, always sanitize and validate the input you retrieve from the request.
        $recaptcha = new \ReCaptcha\ReCaptcha($secret);
		if($this->input->server('HTTP_HOST') == 'ytubey.com'){
        $resp = $recaptcha->setExpectedHostname('ytubey.com')
            ->setExpectedAction($this->input->get('action'))
            ->setScoreThreshold(0.1)
            ->verify($this->input->get('token'), $_SERVER['REMOTE_ADDR']);
		}
		else{
			 $resp = $recaptcha->setExpectedHostname('ytuber.ru')
            ->setExpectedAction($this->input->get('action'))
            ->setScoreThreshold(0.1)
            ->verify($this->input->get('token'), $_SERVER['REMOTE_ADDR']);
		}

        // Update score in database
       // if($resp->isSuccess() && $resp->getScore() != $this->user->recaptcha_score)
		  
		if($resp->isSuccess())
        {
            $this->User->updateItem($this->user->id, array('recaptcha_score'=> $resp->getScore()));
        }
		else{
			$this->User->updateItem($this->user->id, array('recaptcha_score'=> '0'));
		}
		
        header('Content-type:application/json');

		echo json_encode($resp->toArray());
		
	}


	function index()
	{
		// referer
		$referrer_id = $this->uri->segment(1) ? (int) $this->uri->segment(1) : (int) $this->input->get('r');
		if($referrer_id > 0) {
			$this->load->model('User_Model', 'User');
			if($user = $this->User->getItem($referrer_id)) {
				$this->session->set_userdata('referrer_id', $referrer_id);
			}
			redirect();
		}

		$this->load->driver('cache');
		$index_counters = $this->cache->file->get('index_counters');

		if(!$index_counters) {
			$now = strtotime(date('Y-m-d H:i:00'));

			$query = $this->db->query("SELECT id as total FROM user ORDER BY id DESC LIMIT 1;")->row();
			if($query) {
				$index_counters[1] = $query->total;
			}

			$min60   = date('Y-m-d H:i:s', $now - 2*60*60);
			$query = $this->db->query("SELECT COUNT(id) as total FROM user WHERE lastseen > '{$min60}'")->row();
			if($query) {
				$index_counters[2] = $query->total + 567;
			}

			$query = $this->db->query("SELECT id as total FROM task ORDER BY id DESC LIMIT 1;")->row();
			if($query) {
				$index_counters[3] = $query->total;
			}

			$query = $this->db->query("SELECT id as total FROM done ORDER BY time DESC LIMIT 1;")->row();
			if($query) {
				$index_counters[4] = $query->total;
			}

			foreach($index_counters as &$val) {
				$val = number_format($val, 0, '.', ' ');
			}

			$this->cache->file->save('index_counters', $index_counters, 600);
		}

		$data = array(
			'counters' => $index_counters
		);
		$this->load->view('index', $data);
	}

	function contact()
	{
        $this->load->model('User_Model', 'User');
        $this->load->helper('recaptcha');

		$name  = $this->input->post('name');
		$email = $this->input->post('email');
		$text  = $this->input->post('text');

		if(!recaptcha_verify()) {
			$this->output->json(array('text' => $this->lang->line('error_captcha')));
		}

		if(strlen($name) < 1) {
			$this->output->json(array('text' => $this->lang->line('error_short_name')));
		}

		if(!preg_match("#^[-0-9a-z_\.]+@[-0-9a-z_^\.]+\.[a-z]{2,6}$#i", $email)) {
			$this->output->json(array('text' => $this->lang->line('error_email')));
		}

		if(strlen($text) < 4) {
			$this->output->json(array('text' => $this->lang->line('error_text')));
		}


		$this->load->helper('mail');
		$config = $this->config->item('mail');

		$message = '';

		if($this->user) {
			$message .= 'ID: '.$this->user->id."<br/>\r\n";
			if($paymentsSum = $this->User->allPaymentsSum($this->user->id)) {
				$message .= '<strong style="color: green;">Оплаты: '.$paymentsSum."</strong><br/>\r\n";
			}
		}

		$message  .= "IP: ".$this->input->ip_address()."<br/>\r\n";
		$message  .= "Имя: {$name}<br/>\r\n";
		$message  .= "Email: {$email}<br/>\r\n";
		$message  .= "Сообщение: {$text}<br/>\r\n";

		$reply_to = array(
			'mail' => $email,
			'name' => $name
		);

		mail_send($config['admin_mail'], 'Сообщение из формы', $message, $reply_to);

		$this->output->json(array('status' => 'success', 'text' => $this->lang->line('success_send')));
	}


	function test_mail() {
		$reply_to = [
		];

		$message = 'test';
		
		$this->load->helper('mail');
		$config = $this->config->item('mail');
		mail_send($config['admin_mail'], 'test', $message );
	}
}
