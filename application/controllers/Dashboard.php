<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

    private $name = 'dashboard';

    public function __construct()
    {
        parent::__construct();

        $this->load->helper('user');
        $this->user = get_user();

        if (!$this->user)
        {
            redirect('auth/login');
        }

        //$this->output->enable_profiler(TRUE);

        $this->load->helper('user');
        $this->load->model('Task_Model', 'Task');
        $this->load->model('Category_Model', 'Category');
        $this->load->model('Type_Model', 'Type');
        $this->load->model('User_Model', 'User');
        $this->load->model('Notification_Model', 'Notification');
        $this->load->model('Complete_Model', 'Complete');

        $this->lang->load('dashboard');

        $this->load->helper('recaptcha');
    }

    function getTask() 
    {
        $results = $this->Task->getItemsAvailableGeoWithOpened($this->user->id, TASK_VIEW, 't.order', 1, 0, true);
        print_r($results);
    }

    public function get_bonus()
    {
        $this->load->model('Bonus_Model', 'Bonus');

        if (recaptcha_verify() && $this->Bonus->isTargetsReach() && !$this->user->daily_bonus_received)
        {
            $bonus = 200;

            if ($this->User->decreaseBalance(ACCOUNT_BONUS, $bonus, false))
            {
                // перечисляем баллы
                $data = array(
                    'balance' => $bonus,
                    'daily_bonus_received' => 1,
                    'daily_bonus_count' => 1
                );
                $this->User->increase($this->user->id, $data);

                $noty = array(
                    'user_id' => $this->user->id,
                    'cost' => $bonus,
                    'type' => NOTY_DAILY_BONUS
                );

                $this->Notification->addItem($noty);
            }
        }

        redirect('dashboard');
    }

    function _text()
    {
        if ($this->User->monthPaymentsSum($this->user->id) >= 100)
        {
            return true;
        } else
        {
            $this->form_validation->set_message('_text', 'Эта функция доступна только для пользователей, купивших баллы более чем на 100 р. за последний месяц.');
            return false;
        }
    }

    function index()
    {
        // обработка формы
        $this->submit();

        $data['pageTitle'] = $this->lang->line('dashboard_title');

        $data['user'] = get_user();// $this->User->getItem($this->user->id);
        $data['taskTotal'] = $this->Task->getTotal($this->user->id);
        $data['referralsTotal'] = $this->User->getReferralsTotal($this->user->id);

        if (!$this->user->daily_bonus_received)
        {
            $this->load->model('Bonus_Model', 'Bonus');
            $data['bonusTargetsReach'] = $this->Bonus->isTargetsReach();
            $data['bonusData'] = $this->Bonus->getData();
        }

        // Рефералы
        $data['referrals'] = $this->User->getReferrals($this->user->id, 5);

        // Новости
        $query = $this->db
            ->limit(3, 0)
            ->order_by('date DESC')
            ->get('news');

        $data['news'] = $query->result();

        // Нотификации
        $data['notification'] = $this->Notification->getItems($this->user->id, 5);

        $this->tpl->load('dashboard', $data);
    }

    function submit()
    {
        $this->load->library('form_validation');
        //$this->form_validation->set_rules('email_hidden', 'Email', 'trim|valid_email');
        $this->form_validation->set_rules('email', 'Email', 'trim|valid_email');
        $this->form_validation->set_rules('subject', $this->lang->line('support_subject'), 'trim|required');
        $this->form_validation->set_rules('text', $this->lang->line('support_text'), 'trim|required');

        if ($this->form_validation->run())
        {
            $email = $this->input->post('email');
            $subject = $this->input->post('name');
            $text = $this->input->post('text');

            // если email не указан, берем из профиля
            if (!$email)
            {
                $email = $this->user->mail;
            }

            // конфиг
            $this->load->helper('mail');
            $config = $this->config->item('mail');

            $message = '';

            $message .= 'ID: <a href="' . site_url('admin/user/' . $this->user->id) . '">' . $this->user->id . "</a><br/>\r\n";
            if ($paymentsSum = $this->User->allPaymentsSum($this->user->id))
            {
                $message .= '<strong style="color: green;">Оплаты: ' . $paymentsSum . "</strong><br/>\r\n";
            }

            $message .= "IP: " . $this->input->ip_address() . "<br/>\r\n";
            $message .= "Имя: {$this->user->name}<br/>\r\n";
            $message .= "Email: {$email}<br/>\r\n";
            $message .= "Сообщение: {$text}<br/>\r\n";

            $reply_to = array('mail' => $email, 'name' => $this->user->name);

            //
            if ($this->user->id == 505783)
            {
                $config['mail'] = 'lukyanov@webistan.ru';
            }

            mail_send($config['admin_mail'], 'Обращение в тех. поддержку', $message, $reply_to);

            $this->session->set_flashdata('success', $this->lang->line('support_success'));
            redirect('dashboard');
        }
    }

    // Активность за последние 30 дней

    function activity()
    {
        $days = 7;
        $time = time() - 86400 * $days;
        $this->db->select('time');
        $this->db->where('time >', $time);
        $this->db->where('status', COMPLETE_FINISHED);
        $this->db->where('user_id', $this->user->id);
        $this->db->order_by('time');
        $query = $this->db->get('done');

        // Формируем пустой массив дней
        $result = array();
        for ($i = 1; $i <= $days; $i++)
        {
            $day = date('Y-m-d', $time + $i * 86400);
            $result[$day] = 0;
        }

        // Считаем кол-во выполнений по дням
        foreach ($query->result() as $item)
        {
            $day = date('Y-m-d', $item->time);
            if (isset($result[$day]))
            {
                $result[$day]++;
            }
        }

        $json = array();
        foreach ($result as $k => $v)
        {
            $json[] = array(
                'y' => $k,
                'a' => $v
            );
        }

        $this->output->json($json);
    }


}
//

/* End of file task.php */
/* Location: ./application/controllers/task.php */