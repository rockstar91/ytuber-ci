<?php
class Promotion extends CI_Controller {
 
	function __construct()
	{
        parent::__construct();
        
        $this->load->helper('user');
    	$this->user = get_user();

		if(!$this->user) {
			redirect('auth/login');
		}
	}

	function index() {
		$this->submit();

		$data = array();
		$data['pageTitle'] = 'Продвижение';
		$this->tpl->load('promotion/index', $data);
	}

	function submit() {
		// форма
		$this->load->library('form_validation');
		$this->form_validation->set_rules('type', 'Тип', 'trim|required');
		$this->form_validation->set_rules('link', 'Ссылка', 'trim|required|valid_url|callback__link');

		if($this->form_validation->run()) {
			$type = $this->input->post('type');
			$link = $this->input->post('link');

			// конфиг
			$this->load->helper('mail');
			$config = $this->config->item('mail');

			$message = '';

			$message .= 'ID: '.$this->user->id."<br/>\r\n";
			$message  .= "IP: ".$this->input->ip_address()."<br/>\r\n";
			$message  .= "Имя: {$this->user->name}<br/>\r\n"; 
			$message  .= "Ссылка: {$link}<br/>\r\n";
			
			mail_send($config['admin_mail'], 'Продвижение', $message);

			$this->session->set_flashdata('success', 'Ваша ссылка была отправлена модератору, вы получите вознаграждение после проверки. Обычно это происходит в течении 24-х часов.');
			redirect('promotion');
		}
	}

	function _link($link) {
		$type = $this->input->post('type');
		
		if($type == 'youtube' && !preg_match('#^http(s){0,1}://(www|m)\.youtube\.com/watch\?v=([a-z0-9-_]{11})$#i', $link)) {
			$this->form_validation->set_message('_link', 'Введите ссылку на YouTube-видео.');
            return false;
		}
		return true;
	}
}