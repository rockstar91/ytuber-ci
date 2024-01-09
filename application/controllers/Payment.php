
<?php

class Payment extends CI_Controller
{

    private $allowedSystems = ['W1', 'Yandex', 'Webmoney'];

    function __construct()
    {
        parent::__construct();
        $this->load->model('User_Model', 'User');
        $this->load->model('Payment_Model', 'Payment');
        $this->load->model('Payment_System');
    }


    function unitpay()
    {
        $this->callback();
    }

    function w1_callback()
    {
        $this->callback();
    }

    function wm_callback()
    {
        $this->callback();
    }

    function yandex_callback()
    {
        $this->callback();
    }

    function callback()
    {

        $post = serialize($this->input->post());
        file_put_contents(dirname(__FILE__) . '/payment_post.txt', $post);

        $paymentId =
            $this->input->post('WMI_PAYMENT_NO') ?? // W1
            $this->input->post('label') ??          // Yandex
            $this->input->post('LMI_PAYMENT_NO') ??   // Webmoney
            $this->input->get('params')['account']        // UnitPay
        ;

        // Получаем платеж из бд
        $payment = $this->Payment->getPayment((int) $paymentId);

        if($payment && $paymentSystem = $this->Payment_System->getSystem($payment->payment_system_id))
        {
            //  Выбираем платежную систему
            $PaymentSystem = \Payment\PaymentSystemFactory::createSystem($paymentSystem->system);
            $response = $PaymentSystem->checkRequest($this->input);

            // Обрабатываем платеж, если он произведен успешно
            if($response->paymentStatus) {
                $this->Payment->paymentProcess($response, $payment);

                if(!empty($response->printMessage))
                {
                    die($response->printMessage);
                }
            }

            echo 'OK';
        }
        else
        {
            // TODO: CREATE LOGGING INTERFACE
            echo 'FAIL';
        }
    }





    function _mail($system, $user_id, $amount, $sum)
    {
        $config = $this->config->item('mail');
        $this->load->helper('mail');
        $text = "ID-пользователя: {$user_id}<br/>\r\n";
        $text .= "Сумма оплаты: {$amount} р.<br/>\r\n";
        $text .= "Зачисленно баллов: {$sum}<br/>\r\n";
        //$text .= "Тип оплаты: {$b['notification_type']}\r\n";
        mail_send($config['admin_mail'], 'Оплата ' . $system, $text);
    }

    function fail()
    {
        $data = array(
            'InvId' => $this->input->get('InvId')
        );
        $this->load->view('payment/fail', $data);
    }

    function success()
    {
        $data = array(
            'InvId' => $this->input->get('InvId')
        );
        $this->load->view('payment/success', $data);
    }


    /* История платежей */

    function start()
    {
        $this->load->helper('user');
        $this->user = get_user();

        if (!$this->user)
        {
            redirect('auth/login');
        }

        $data['pageTitle'] = 'Оплата';

        if (
            $this->input->post() &&
            $paymentSystem = $this->Payment_System->getSystem($this->input->post('payment_system_id'))
        )
        {
            $data['paymentSystem'] = $paymentSystem;

            // Создание записи в бд
            $paymentId = $this->Payment->addPayment([
                'created'           => time(),
                'user_id'           => $this->user->id,
                'payment_system_id' => $paymentSystem->id
            ]);

            // Данные для отображения формы
            $order = [
                'id'                => $paymentId,
                'user_id'           => $this->user->id,
                'paymentSystem'     => $paymentSystem,
                'sum'               => number_format((int)$this->input->post('sum'), 2, '.', '')
            ];

            $data['order'] = $order;

            $PaymentSystem = \Payment\PaymentSystemFactory::createSystem($paymentSystem->system);
            $data['paymentForm'] = $PaymentSystem->generateForm($order['sum'], $order['id'], 'Пополнение баланса пользователя #' . $this->user->id);

        }

        $data['paymentSystemList'] = $this->Payment_System->getAllSystems();

        $this->tpl->load('payment/start', $data);
    }


    function history()
    {
        $this->load->helper('user');
        $this->user = get_user();

        if (!$this->user)
        {
            redirect('auth/login');
        }


        $data['pageTitle'] = 'История платежей';

        // count
        $this->db->where('user_id', $this->user->id);
        $this->db->where('status', 1);
        $this->db->from('payments');
        $total = $this->db->count_all_results();

        // pagination
        $this->load->library("pagination");
        $config = $this->config->item('pagination');
        $config['base_url'] = base_url('payment/history');
        $config['total_rows'] = $total;
        $config['uri_segment'] = 3;
        $this->pagination->initialize($config);
        $page = (int)$this->uri->segment($config['uri_segment']);

        $data['pagination'] = $this->pagination->create_links();

        // запрос в БД
        $this->db->limit($config["per_page"], $page);
        $this->db->select('payments.*, ps.name');
        $this->db->where('status', 1);
        $this->db->where('user_id', $this->user->id);
        $this->db->join('payment_system as ps', 'ps.id = payments.payment_system_id', 'left');
        $this->db->order_by("time", "desc");
        $query = $this->db->get('payments');
        $data['results'] = $query->result();

        $this->tpl->load('payment/history', $data);
    }
}
