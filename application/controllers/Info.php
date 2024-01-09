<?php

class Info extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->helper('user');
        $this->user = get_user();

        if (!$this->user) {
            redirect('auth/login');
        }
    }

    function faq()
    {
        $data = array();
        $data['pageTitle'] = 'FAQ';

        $lang = $this->config->item('language');

        $this->tpl->load('info/faq_' . $lang, $data);
    }

    function rules()
    {
        $data['pageTitle'] = 'Правила сервиса';
        $this->tpl->load('info/rules', $data);
    }

    function fb_instruction()
    {
        $data['pageTitle'] = 'Настройка Facebook';
        $this->tpl->load('info/fb_instruction', $data);
    }
}