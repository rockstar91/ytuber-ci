<?php

class Paycode extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('User_Model', 'User');
        $this->load->library("pagination");

        $this->load->helper('user');
        $this->user = get_user();

        if (!$this->user) {
            redirect('auth/login');
        }

        $this->load->helper('user');
        $this->lang->load('user');
    }

    function index()
    {
        echo 123;
    }


    /* Paycode */
    function usecode()
    {


        $this->load->model('Paycode_Model', 'Paycode');

        $data['pageTitle'] = 'Предоплаченный код';

        $this->load->library('form_validation');
        $this->form_validation->set_rules('paycode', 'Код', 'trim|required|xss_clean|callback__paycode');

        if ($this->form_validation->run()) {
            $this->session->set_flashdata('success', "Код на сумму <b>" . $this->input->post('paycode') . "</b> зачислен на ваш счет.");
            redirect('user/paycode');
        }

        $this->tpl->load('user/paycode', $data);
    }

    function _paycode($code)
    {
        if ($item = $this->Paycode->getItem($code)) {
            $this->User->increaseBalance($this->user->id, $item->sum);
            $this->Paycode->removeItem($item->id);
            return $item->sum;
        } else {
            $this->form_validation->set_message('_paycode', 'Указанный код не найден.');
            return false;
        }
    }

}
