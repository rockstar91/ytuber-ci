<?php

Class Payment_Model extends CI_Model
{
    const PAYMENT_STATUS_WAIT = 0;
    const PAYMENT_STATUS_PAID = 1;

    protected $table = 'payments';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function getPayment($payment_id)
    {
        $this->db->where('id', $payment_id);
        $this->db->limit(1);
        $query = $this->db->get($this->table);
        return ($query->num_rows()>0) ? $query->row() : false;
    }

    function getPaymentsTotal()
    {
        $this->db->select('COUNT(id) as total');
        $this->db->where('status', 1);
        $query = $this->db->get($this->table);
        return $query->row() ? intval($query->row()->total) : 0;
    }

    function getPayments($limit = 100, $start = 0)
    {
        $this->db->limit((int)$limit, (int)$start);
        $this->db->where('status', 1);
        $this->db->order_by("time", "desc");
        $query = $this->db->get($this->table);
        return $query->result();
    }

    function addPayment($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    function removePayment($id)
    {
        $this->db->where('id', $id);
        $this->db->delete($this->table);
        return $this->db->affected_rows();
    }

    function updatePayment($id, $data)
    {
        $this->db->where('id', (int)$id);
        $this->db->update($this->table, $data);
        return $this->db->affected_rows();
    }

    function calculateCoins($amount)
    {
        $factor = 22.5;
        if ($amount >= 300)
        {
            $factor = 22.5;
        }
        if ($amount >= 1200)
        {
            $factor = 26.25;
        }
        if ($amount >= 2100)
        {
            $factor = 30;
        }
        if ($amount >= 3000)
        {
            $factor = 36;
        }

        return $amount * $factor;
    }

    function affiliateTransfer($user_id, $paymentSum)
    {
        $this->load->model('User_Model', 'User');

        $rub = $paymentSum * 0.05; // 15 процентов от платежа

        $user = $this->User->getItem($user_id);
        if ($user)
        {
            return $this->User->increase($user->referrer_id, array('rub' => $rub));
        }
        return false;
    }

    function paymentProcess(Payment\Model\BaseResponse $response, $payment)
    {
        if($payment->status == self::PAYMENT_STATUS_PAID)
        {
            return;
        }

        $this->load->model('User_Model', 'User');

        // Кол-во зачисляемых баллов
        $coinsSum = $this->calculateCoins($response->paymentSum);

        // Снимаем баллы у системы
        $this->User->decreaseBalance(ACCOUNT_PAYMENT, $coinsSum, false);

        // Пополняем баланс пользователя
        $this->User->increaseBalance($payment->user_id, $coinsSum);

        // Обновлякс запись в БД
        $this->updatePayment($payment->id, [
            'amount' => $response->paymentSum,
            'sum' => $coinsSum,
            'detail' => serialize($this->input->post()),
            'time' => time(),
            'status' => self::PAYMENT_STATUS_PAID
        ]);

        // Перечесления рефереру по партнерской программе
        $this->affiliateTransfer($payment->user_id, $response->paymentSum);
    }

}