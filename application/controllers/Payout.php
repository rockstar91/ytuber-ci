<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payout extends CI_Controller {

	private $name = 'payout';

 	public function __construct() 
 	{
        parent::__construct();

        $this->load->helper('user');
    	$this->user = get_user();

		if(!$this->user) {
			redirect('auth/login');
		}

        $this->load->library("pagination");
        $this->load->model('User_Model', 'User');
        $this->load->model('Payout_Model', 'Payout');
 	}

	/* Transaction */
	function index () 
	{

		$this->_mustBeLogged();

		$data = array();
		$data['pageTitle'] = 'Партнерская программа';

		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('system', 'Система', 'trim|required|callback__system');
		$this->form_validation->set_rules('account', 'Счет', 'trim|required|callback__account');
		$this->form_validation->set_rules('rub', 'Сумма', 'trim|required|numeric|greater_than_equal_to[100]|less_than_equal_to[15000]|callback__rub');
	

		if($this->form_validation->run()) {
			$decrease = $this->User->decreaseRub($this->user->id, $this->input->post('rub'));
			if($decrease) {
				$data = array(
					'user_id' 	=> $this->user->id,
					'system'	=> $this->input->post('system'),
					'account'	=> $this->input->post('account'),
					'rub'		=> $this->input->post('rub'),
					'created'	=> date('Y-m-d H:i:s')
				);
				$add = $this->Payout->addItem($data);

				$this->user->rub -= $this->input->post('rub');

				// Письмо админу
				$config = $this->config->item('mail');
				$this->load->helper('mail');
				$text  = "ID-пользователя: {$this->user->id}<br/>\r\n";
				$text .= "Сумма: {$this->input->post('rub')} р.<br/>\r\n";
				$text .= "Система: {$this->input->post('system')}<br/>\r\n";
				//$text .= "Тип оплаты: {$b['notification_type']}\r\n";
				mail_send($config['admin_mail'], 'Заявка на вывод средств', $text);


				$this->session->set_flashdata('success', 'Заявка успешно добавлена.');
				redirect('payout');
			}
		}

		// pagination
		$config = $this->config->item('pagination');
		$config['base_url']    = base_url($this->name);
		$config['total_rows']  = $this->Payout->getPayoutsTotal($this->user->id);
		$config['uri_segment'] = 3;
        $this->pagination->initialize($config);

		$page = (int) $this->uri->segment($config['uri_segment']);

		$data["results"] = $this->Payout->getPayouts($this->user->id, $config["per_page"], $page);
		$data['pagination'] = $this->pagination->create_links();

		$this->tpl->load('payout/index', $data);
	}

	/* _system */
	function _system($system) {
		$allow = array('yandex');

		if(!in_array($system, $allow)) {
			$this->form_validation->set_message('_system', 'Выберите одну из доступных систем.');
			return false;
		}

		return true;
	}

	/* _account */
	function _account($account) {
		$system = $this->input->post('system');

		if($system == 'yandex' && !preg_match('#^(\d){12,16}$#', $account)) {
			$this->form_validation->set_message('_account', 'Введите коректный счет Яндекс.Денег.');
			return false;
		}

		return true;
	}

	/* _rub */
	function _rub($rub) 
	{
		$me = $this->User->getItem((int)$this->user->id);

		if(!$me OR $rub < 100) {
			$this->form_validation->set_message('_rub', 'Минимальная сумма вывода составляет 100 рублей.');
			return false;
		}
		else if(!$me OR $me->rub < $rub) {
			$this->form_validation->set_message('_rub', 'У вас недостаточно денег.');
			return false;
		}

		return true;
	}

 	/* _mustBeLogged */
	function _mustBeLogged() 
	{
		if(!$this->user) {
			redirect('auth/login'); 
		} 
	}

 }
//

/* End of file task.php */
/* Location: ./application/controllers/task.php */