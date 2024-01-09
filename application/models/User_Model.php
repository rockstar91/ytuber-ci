<?php

Class User_Model extends CI_Model
{

    protected $table = 'user';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function login($mail, $password)
    {
        $this->db->where('mail', $mail);
        $this->db->where('password', $password);
        $this->db->where('disabled', 0);

        $this->db->limit(1);

        $query = $this->db->get($this->table);

        return ($query->num_rows() > 0) ? $query->row() : false;
    }

    function loginHash($mail, $password)
    {
        $this->db->where('mail', $mail);
        $this->db->where('disabled', 0);
        $this->db->limit(1);

        $user = $this->db->get($this->table)->row();

        if ($user AND password_verify($password, $user->password_hash)) {
            return $user;
        }

        return false;
    }

    function getItem($id, $fields = null)
    {
        if ($fields) {
            $this->db->select($fields);
        }
        $this->db->where('id', (int)$id);
        $this->db->where('disabled', 0);
        $this->db->limit(1);
        $query = $this->db->get($this->table);
        return ($query->num_rows() > 0) ? $query->row() : false;
    }

    function getItemBy($field = 'id', $value = null)
    {
        $this->db->where($field, $value);
        $this->db->where('disabled', 0);
        $this->db->limit(1);
        $query = $this->db->get($this->table);
        return ($query->num_rows() > 0) ? $query->row() : false;
    }

    function addItem($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->affected_rows();
    }

    function updateItem($id, $data)
    {
        $this->db->where('id', (int)$id);
        $this->db->update($this->table, $data);
        return $this->db->affected_rows();
    }

    function removeItem($id)
    {
        if ($id > 0) {
            $this->db->where('id', (int)$id);
            $this->db->delete($this->table);
            return $this->db->affected_rows();
        }
        return false;
    }


    function isUnique($field, $value, $not_user_id = null)
    {
        if (!is_null($not_user_id)) {
            $this->db->where('id !=', (int)$not_user_id);
        }
        $this->db->where($field, $value);
        $query = $this->db->get($this->table);
        return ($query->num_rows() > 0) ? false : true;
    }

    function updateLastseen($id)
    {
        $data = array(
            'lastseen' => date('Y-m-d H:i:s'),
            'lastip' => $this->input->ip_address()
        );

        $this->db->where('id', (int)$id);
        $this->db->update($this->table, $data);
        return $this->db->affected_rows();
    }

    function getBalance($id)
    {
        $this->db->select('id,balance');
        $this->db->where('id', $id);
        $this->db->limit(1);
        $query = $this->db->get($this->table);
        return ($query->num_rows() > 0) ? $query->row()->balance : false;
    }

    function getReferrals($referrer_id, $limit = 100, $start = 0)
    {
        $this->db->limit((int)$limit, (int)$start);
        $this->db->where('referrer_id', (int)$referrer_id);
        $this->db->order_by("time", "desc");
        $query = $this->db->get($this->table);
        return $query->result();
    }

    function getReferralsTotal($referrer_id)
    {
        $this->db->select('COUNT(id) as total');
        $this->db->where('referrer_id', intval($referrer_id));
        $query = $this->db->get($this->table);

        return $query->row() ? intval($query->row()->total) : 0;
    }

    function getActiveReferralsTotal($referrer_id)
    {
        $lastseen = date('Y-m-d H:i:s', time() - (3 * 86400));
        $time = date('Y-m-d H:i:s', time() - (14 * 86400));

        $this->db->select('COUNT(id) as total');
        $this->db->where('referrer_id', intval($referrer_id));
        $this->db->where('lastseen >', $lastseen); // были менее 7 дней назад
        $this->db->where('time <', $time); // зарегистрировались более 14 дней назад
        $this->db->where('channel_available', 1); // канал доступен
        $this->db->where('done >', 50); // есть выполнения задач
        $query = $this->db->get($this->table);

        return $query->row() ? intval($query->row()->total) : 0;
    }

    function getUsers($limit = 100, $start = 0)
    {
        $this->db->limit((int)$limit, (int)$start);
        $this->db->order_by("time", "desc");
        $query = $this->db->get($this->table);
        return $query->result();
    }

    function getUsersTotal()
    {
        $this->db->select('COUNT(id) as total');
        $query = $this->db->get($this->table);
        return $query->row() ? intval($query->row()->total) : 0;
    }

    function getTransactions($user_id, $limit = 100, $start = 0)
    {
        $this->db->limit((int)$limit, (int)$start);
        $this->db->or_where('sender', (int)$user_id);
        $this->db->or_where('recipient', (int)$user_id);
        $this->db->order_by("time", "desc");
        $query = $this->db->get('transaction');
        return $query->result();
    }

    function getTransactionsTotal($user_id)
    {
        $this->db->or_where('sender', (int)$user_id);
        $this->db->or_where('recipient', (int)$user_id);
        $query = $this->db->get('transaction');
        return $query->num_rows();
    }

    function makeTransaction($sender, $recipient, $sum, $record = null)
    {
        $result = false;
        if ($this->decreaseBalance($sender, $sum)) {
            $result = $this->increaseBalance($recipient, $sum);
            if ($result && $record) {
                $data = array(
                    'sender' => $sender,
                    'recipient' => $recipient,
                    'sum' => $sum,
                    'time' => date('Y-m-d H:i:s')
                );
                $result = $this->addTransactionRecord($data);
            }
        }
        return $result;
    }

    function decreaseBalance($id, $sum = 0, $notNeg = true)
    {
        $this->db->where('id', $id);
        if ($notNeg) {
            $this->db->where('balance >=', $sum);
        }
        $this->db->set('balance', 'balance-' . $sum, false);
        $this->db->update($this->table);
        return $this->db->affected_rows();
    }

    function increaseBalance($id, $sum = 0)
    {
        $this->db->where('id', $id);
        $this->db->set('balance', 'balance+' . $sum, false);
        $this->db->update($this->table);

        if ($sum == 0) {
            return true;
        }

        return $this->db->affected_rows();
    }

    function addTransactionRecord($data)
    {
        $this->db->insert('transaction', $data);
        return $this->db->affected_rows();
    }

    function getDone($id)
    {
        $this->db->select('id,done');
        $this->db->where('id', $id);
        $this->db->limit(1);
        $query = $this->db->get($this->table);
        return ($query->num_rows() > 0) ? $query->row()->done : false;
    }

    function generateApiKey($id)
    {
        $this->load->helper('strgen');
        $api_key = strgen(40);

        $i = 0;
        while (true) {
            $query = $this->db->select('id')->where('api_key', $api_key)->get($this->table);
            if ($query->num_rows() <= 0) {
                $this->db->where('id', $id)->update($this->table, array('api_key' => $api_key));
                return $this->db->affected_rows();
                break;
            }

            if ($i >= 10) break;
            $i++;
        }

        return false;
    }

    function increase($user_id, $data = array())
    {
        if (!is_array($data)) {
            return;
        }

        $this->db->where('id', $user_id);
        foreach ($data as $key => $value) {
            $this->db->set($key, $key . '+' . $value, false);
        }
        $this->db->update($this->table);

        return $this->db->affected_rows();
    }

    function increaseDone($id)
    {
        $this->db->where('id', $id);
        $this->db->set('done', 'done+1', false);
        $this->db->update($this->table);
        return $this->db->affected_rows();
    }

    function increaseEarned($id, $earned = 0)
    {
        $this->db->where('id', $id);
        $this->db->set('earned', 'earned+' . $earned, false);
        $this->db->update($this->table);
        return $this->db->affected_rows();
    }

    function decreaseRub($id, $rub = 0)
    {
        $this->db->where('id', $id);
        $this->db->where('rub >=', $rub);
        $this->db->set('rub', 'rub-' . $rub, false);
        $this->db->update($this->table);
        return $this->db->affected_rows();
    }

    function allPaymentsSum($user_id)
    {
        $this->db->select('SUM(amount) as total');
        $this->db->where('user_id', (int)$user_id);
        $this->db->where('status', 1);
        $query = $this->db->get('payments');

        if ($row = $query->row()) {
            return $row->total;
        }
    }

    function monthPaymentsSum($user_id)
    {
        $timeOffset = time() - 3600 * 24 * 30;

        $this->db->select('SUM(amount) as total');
        $this->db->where('user_id', (int)$user_id);
        $this->db->where('status', 1);
        $this->db->where('time > ', $timeOffset);
        $query = $this->db->get('payments');

        if ($row = $query->row()) {
            return $row->total;
        }
    }

    function monthCoinsSum($user_id)
    {
        $timeOffset = time() - 3600 * 24 * 30;

        $this->db->select('SUM(sum) as total');
        $this->db->where('user_id', (int)$user_id);
        $this->db->where('status', 1);
        $this->db->where('time > ', $timeOffset);
        $query = $this->db->get('payments');

        if ($row = $query->row()) {
            return $row->total;
        }
    }

    function monthRefundSum($user_id)
    {
        $this->db->select('SUM(value) as total');
        $this->db->where('user_id', (int)$user_id);
        $this->db->where('created_at >', 'DATE_SUB(NOW(), INTERVAL 30 DAY)', false);
        $query = $this->db->get('refund');

        if ($row = $query->row()) {
            return $row->total;
        }
    }

    /*
    function getUserBalance($id)
    {
        $user = $this->getItem($id);
        return isset($user->balance) ? $user->balance : false;
    }*/
}