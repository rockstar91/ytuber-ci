<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Stat extends CI_Controller
{

    private $name = 'stat';

    public function __construct()
    {
        parent::__construct();

        $this->load->helper('user');
        $this->user = get_user();

        if (!$this->user) {
            redirect('auth/login');
        }

        if (!$this->user->admin) {
            show_404();
        }

        $this->load->model('Task_Model', 'Task');
        $this->load->model('Category_Model', 'Category');
        $this->load->model('Type_Model', 'Type');
        $this->load->model('User_Model', 'User');
    }

    public function info()
    {
        phpinfo();
    }

    public function allPayments() 
    {

        ini_set('memory_limit', '256M');
        $query = $this->db->query("SELECT * FROM payments WHERE status = 1")->result();
        foreach ($query as $row) {

            $total = $w1 = $yd = $ydme = $wmr = $up = 0;

            //print_r($row); exit;
            $amount = $row->amount;

            if ($row->payment_system_id == 2) { //'p2p-incoming'
                $amount = $row->amount * 0.995;
                $yd += $amount;
            } else if ($row->payment_system_id == 1) { //'card-incoming'
                $amount = $row->amount * 0.98;
                $yd += $amount;
            } else if ($row->payment_system_id == 4) { //'WMR'
                $amount = $row->amount * 0.992; 
                $wmr += $amount;
            } else if ($row->payment_system_id == 3) { // W1
                $amount = $row->amount * 0.90;
                $w1 += $amount;
            } else if ($row->payment_system_id == 5) { // UnitPay
                $amount = $row->amount * 0.90; // 5%
                $up = $amount;
            }

            $total += $amount;

            $mt = date('m.Y', $row->time);
            if (isset($month[$row->payment_system_id][$mt])) {
                $month[$row->payment_system_id][$mt] += $amount;
            } else {
                $month[$row->payment_system_id][$mt] = 0;
            }

            // после 21.02.2021
            if(($row->time > strtotime('05.05.2016 01:00:00') && $row->time <= strtotime('22.03.2019 11:22:23')) OR $row->time >= strtotime('21.02.2021 09:25:37')) 
            {
                @$month['me'][$mt] += $wmr + $yd;
                @$month['vn'][$mt] += $w1 + $up;
            }
            else 
            {
                @$month['me'][$mt] += $wmr;
                @$month['vn'][$mt] += $w1 + $up + $yd;
            }

            @$month['total'][$mt] += $amount;

        }

        $diff = 0;

        foreach ($month['total'] as $mt => $value) {
            @$month['diff'][$mt] = ($value / 2) - $month['me'][$mt];
            $diff += $month['diff'][$mt];
        }

        $meTotal = 0;
        foreach ($month['me'] as $key => $value) {
            $meTotal += $value;
        }

        $vnTotal = 0;
        foreach ($month['vn'] as $key => $value) {
            $vnTotal += $value;
        }


        echo "me total: ".$meTotal."\r\n";
        echo "vn total: ".$vnTotal."\r\n";
        print_r($month);

    }

    /* index */
    public function index()
    {
        // Список
        $data['pageTitle'] = 'Статистика';
        ini_set('memory_limit', '256M');

        if ($this->input->get('act') == 'userip') {
            $ipData = array(); //SELECT name, COUNT(DISTINCT emp_id) AS qty FROM org
            $query = $this->db->query("SELECT COUNT(id) as total, SUM(balance) as balance, ip FROM user GROUP BY ip ORDER BY total DESC");
            foreach ($query->result() as $row) {
                if ($row->total > 1) {
                    echo "{$row->total} {$row->ip} {$row->balance}<br/>\r\n";
                }
            }
        }

        $days30 = date('Y-m-d H:i:s', time() - 3600 * 24 * 30);
        $hour24 = date('Y-m-d H:i:s', time() - 3600 * 24);
        $min5 = date('Y-m-d H:i:s', time() - 5 * 60);

        ###
        $arr[] = 'Пользователи';

        $query = $this->db->query("SELECT COUNT(id) as total FROM user")->row();
        if ($query) {
            $arr[] = array('Всего пользователей', $query->total);
        }

        $query = $this->db->query("SELECT COUNT(id) as total FROM user WHERE balance > 0")->row();
        if ($query) {
            $arr[] = array('С ненулевым балансом', $query->total);
        }

        $query = $this->db->query("SELECT COUNT(id) as total FROM user WHERE time > '{$hour24}'")->row();
        if ($query) {
            $arr[] = array('Зарегистрировались за последние 24 часа', $query->total);
        }

        $query = $this->db->query("SELECT COUNT(id) as total FROM user WHERE time > '{$hour24}' AND confirm = ''")->row();
        if ($query) {
            $arr[] = array('Подтвердили email за последние 24 часа', $query->total);
        }

        $query = $this->db->query("SELECT COUNT(id) as total FROM user WHERE lastseen > '{$min5}'")->row();
        if ($query) {
            $arr[] = array('Были на сайте за последние 5 минут (онлайн)', $query->total);
        }

        $query = $this->db->query("SELECT COUNT(id) as total FROM user WHERE lastseen > '{$hour24}'")->row();
        if ($query) {
            $arr[] = array('Были на сайте за последние 24 часа', $query->total);
        }

        $query = $this->db->query("SELECT COUNT(id) as total FROM user WHERE lastseen > '{$days30}'")->row();
        if ($query) {
            $arr[] = array('Были на сайте за последние 30 дней (активные)', $query->total);
        }

        ###
        $arr[] = 'Выполнение заданий';

        $t1 = time() - 1 * 60;
        $query = $this->db->query("SELECT COUNT(id) as total FROM done WHERE time > '{$t1}'")->row();
        if ($query) {
            $arr[] = array('За последнюю минуту', $query->total);
        }

        $t5 = time() - 5 * 60;
        $query = $this->db->query("SELECT COUNT(id) as total FROM done WHERE time > '{$t5}'")->row();
        if ($query) {
            $arr[] = array('За последние 5 минут', $query->total);
        }

        $t60 = time() - 60 * 60;
        $query = $this->db->query("SELECT COUNT(id) as total FROM done WHERE time > '{$t60}'")->row();
        if ($query) {
            $arr[] = array('За последний час', $query->total);
        }

        $t24h = time() - 60 * 60 * 24;
        $query = $this->db->query("SELECT COUNT(id) as total FROM done WHERE time > '{$t24h}'")->row();
        if ($query) {
            $arr[] = array('За последние 24 часа', $query->total);
        }

        $time = strtotime(date('Y-m-d'));
        $query = $this->db->query("SELECT COUNT(id) as total FROM done WHERE time >= '{$time}'")->row(); // GROUP BY type_id
        if ($query) {
            $arr[] = array('За сегодня (' . date('Y-m-d') . ')', $query->total);
        }


        $types = $this->Type->getAllItems();

        foreach ($types as $type) {
            $data = array(
                COMPLETE_OPENED => 0,
                COMPLETE_WAITING => 0,
                COMPLETE_EXPIRED => 0,
                COMPLETE_FINISHED => 0,
                COMPLETE_FAILED => 0,
                COMPLETE_PENALTY => 0
            );

            $result = $this->db->query("SELECT status, COUNT(id) as total FROM done WHERE time > '{$t24h}' AND type_id={$type->id} GROUP BY status")->result();

            foreach ($result as $item) {
                if (isset($data[$item->status])) {
                    $data[$item->status] = $item->total;
                }
            }

            $arr[] = array($type->name . ' 24ч', implode(' / ', $data));
        }


        $query = $this->db->query("SELECT COUNT(id) as total FROM done WHERE time > '{$t24h}' AND cost_rule=" . COST_API)->row();
        if ($query) {
            $arr[] = array('Выполнения по API за 24 часа', $query->total);
        }


        ###
        $arr[] = 'Задания';

        $query = $this->db->query("SELECT COUNT(id) as total FROM task")->row();
        if ($query) {
            $arr[] = array('Всего заданий', $query->total);
        }

        $query = $this->db->query("SELECT COUNT(id) as total FROM task WHERE total_cost >= action_cost")->row();
        if ($query) {
            $arr[] = array('Активных заданий', $query->total);
        }

        $query = $this->db->query("SELECT COUNT(id) as total FROM task WHERE added > '{$hour24}'")->row();
        if ($query) {
            $arr[] = array('Добавлено заданий за 24 часа', $query->total);
        }

        $query = $this->db->query("SELECT COUNT(id) as total FROM task WHERE updated > '{$hour24}'")->row();
        if ($query) {
            $arr[] = array('Обновлено заданий за 24 часа', $query->total);
        }

        ###
        $arr[] = 'Общее';

        $query = $this->db->query("SELECT SUM(balance) as total FROM user WHERE id <> 0")->row();
        if ($query) {
            $arr[] = array('Всего баллов у пользователей', $query->total);
            $balance_total = $query->total;
        }

        $query = $this->db->query("SELECT SUM(balance) as total FROM user WHERE id <> 0 AND lastseen > '{$hour24}'")->row();
        if ($query) {
            $arr[] = array('Баллов у активных пользователей (1д)', $query->total);
        }

        $query = $this->db->query("SELECT SUM(balance) as total FROM user WHERE id <> 0 AND  lastseen > '{$days30}'")->row();
        if ($query) {
            $arr[] = array('Баллов у активных пользователей (30д)', $query->total);
        }

        $query = $this->db->query("SELECT balance as total FROM user WHERE id = 0")->row();
        if ($query) {
            $arr[] = array('Баланс системы', $query->total);
            $balance_sys = $query->total;
        }

        $query = $this->db->query("SELECT SUM(action_cost) as total FROM done WHERE status = " . COMPLETE_WAITING)->row();
        if ($query) {
            $arr[] = array('Баланс выполнений', $query->total);
            $balance_done = $query->total;
        }

        $query = $this->db->query("SELECT SUM(total_cost) as total FROM task WHERE removed = 0 AND disabled = 0 ")->row();
        if ($query) {
            $arr[] = array('Баланс заданий', $query->total);
            $balance_task = $query->total;
        }

        $time = time() - 86400;
        $query = $this->db->query("SELECT SUM(action_cost) as total FROM done WHERE status = " . COMPLETE_FINISHED . " AND time > {$time}")->row();
        if ($query) {
            $arr[] = array('Оборот за 24 часа', $query->total);
        }

        $arr[] = array('Всего баллов + Баланс заданий', $balance_total + $balance_task + $balance_done);

        $arr[] = array('Всего', $balance_total + $balance_task + $balance_sys + $balance_done);

        #
        $arr[] = 'Системные балансы';

        $query = $this->db->query("SELECT id, name, balance FROM user WHERE id < 7");
        foreach ($query->result() as $user) {
            $arr[] = array($user->name, $user->balance);
        }

        #
        $arr[] = 'Средняя цена за час';

        $types = array(
            1 => 'view',
            2 => 'like',
            3 => 'comment',
            4 => 'subscribe',
            7 => 'commentlike',
            201 => 'reply',
            101 => 'vk_share',
            102 => 'twitter_share'
        );

        $t = time() - 3600;

        foreach ($types as $type_id => $name) {
            $query = $this->db->query("
                            SELECT AVG(d.action_cost) as total FROM done d 
                            WHERE d.time > {$t} AND d.type_id = {$type_id} AND d.status = " . COMPLETE_FINISHED . "
                    ")->row();
            if ($query) {
                $arr[] = array($name, $query->total);
            }

        }

        $arr[] = 'Оплаты';

        $query = $this->db->query("SELECT SUM(amount) as total FROM payments WHERE status = 1 AND time > ". strtotime('01.01.2021 00:00:00') )->row();
        if ($query) {
            $arr[] = array('Всего', $query->total);
        }

        $total = $w1 = $rk = $yd = $ydme = $wmr = 0;
        $query = $this->db->query("SELECT * FROM payments WHERE status = 1 AND time > ". strtotime('01.01.2021 00:00:00') )->result();
        foreach ($query as $row) {
            $amount = $row->amount;

            if ($row->type == 'p2p-incoming') {
                $amount = $row->amount * 0.995;
                $yd += $amount;
            } else if ($row->type == 'card-incoming') {
                $amount = $row->amount * 0.98;
                $yd += $amount;
            } else if ($row->type == 'WMR') {
                $wmr += $row->amount;
            } else if ($row->system == 'w1') {
                $w1 += $row->amount;
            } else if ($row->type == 'robokassa') {
                $rk += $row->amount;
            }

            $total += $amount;

            $mt = date('m.Y', $row->time);
            if (isset($month[$mt])) {
                $month[$mt] += $amount;
            } else {
                $month[$mt] = 0;
            }
        }

        if ($query) {
            $arr[] = array('Всего (-комиссия)', $total);
        }

        foreach ($month as $k => $v) {
            $arr[] = array($k, $v);
        }


        $time = strtotime(date('Y-m'));
        $query = $this->db->query("SELECT SUM(amount) as total FROM payments WHERE time >= {$time} AND status = 1")->row();
        if ($query) {
            $arr[] = array('С начала месяца', $query->total);
        }

        $time = strtotime(date('Y-m-d'));
        $query = $this->db->query("SELECT SUM(amount) as total FROM payments WHERE time >= {$time} AND status = 1")->row();
        if ($query) {
            $arr[] = array('За сегодня (' . date('Y-m-d') . ')', $query->total);
        }

        $yesterday = strtotime(date('Y-m-d')) - 3600 * 24;
        $query = $this->db->query("SELECT SUM(amount) as total FROM payments WHERE time >= {$yesterday} AND time <= {$time} AND status = 1")->row();
        if ($query) {
            $arr[] = array('За вчера', $query->total);
        }

        $time = time() - 3600 * 24;
        $query = $this->db->query("SELECT SUM(amount) as total FROM payments WHERE time >= {$time} AND status = 1")->row();
        if ($query) {
            $arr[] = array('За 24 часа', $query->total);
        }

        $data['table'] = '<table class="table table-striped table-bordered table-hover">';
        foreach ($arr as $val) {
            if (!is_array($val)) {
                $data['table'] .= '<tr><td colspan="2"><b>' . $val . '</b></td></tr>';
                continue;
            }
            $data['table'] .= "<tr><td>{$val[0]}</td><td>{$val[1]}</td></tr>";
        }
        $data['table'] .= '</table>';

        $this->tpl->load('stat/index', $data);
    }
}
//

/* End of file task.php */
/* Location: ./application/controllers/task.php */
