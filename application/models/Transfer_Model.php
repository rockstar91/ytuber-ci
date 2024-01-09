<?php

Class Transfer_Model extends CI_Model
{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();

        $this->load->model('Notification_Model', 'Notification');
        $this->load->model('Complete_Model', 'Complete');
    }

    // Просчет цены на основе заданого конфига $cost_rule

    public function completeToUser($complete_id, $cost_rule = null)
    {
        // Получение метки выполнения
        $complete = $this->Complete->get($complete_id);

        if (!$complete OR $complete->status != COMPLETE_WAITING) {
            return;
        }

        // Переопределение правила цены
        if ($cost_rule) {
            $complete->cost_rule = $cost_rule;
        }

        // Получение причастного пользователя
        $user = $this->User->getItem((int)$complete->user_id);

        if (!$user) {
            return false;
        }

        // Цены
        $cost = self::calculateCost($complete->action_cost, $complete->cost_rule);

        // Перечисляем баллы пользователю
        $increaseData = array(
            'done' => 1,
            'done_day' => 1,
            'earned' => $cost['referrer'],
            'balance' => $cost['user']
        );
        if (!$this->User->increase($user->id, $increaseData)) {
            return false;
        }

        // Перечисляем процент рефереру
        if ($user->referrer_id > 0) {
            $this->User->increaseBalance($user->referrer_id, $cost['referrer']);
        } else {
            $cost['system'] += $cost['referrer'];
        }

        // Перечисляем процент системе
        $this->User->increaseBalance(0, $cost['system']);

        // Обновляем счетчики задачи
        $this->db->where('id', $complete->task_id);
        $this->db->set('action_done', 'action_done+1', false);
        $this->db->set('hour_done', 'hour_done+1', false);
        $this->db->update('task');

        // Нотификации
        $noty = array(
            'user_id' => $user->id,
            'task_id' => $complete->task_id,
            'task_type_id' => $complete->type_id,
            'task_time' => $complete->timeout,
            'cost' => $cost['user'],
            'type' => 1
        );

        $this->Notification->addItem($noty);

        return true;
    }

    // Перевод средств из временной метки к выполневщему пользователю

    public function calculateCost($action_cost, $cost_rule)
    {
        $cost = $this->config->item($cost_rule, 'cost_rules');

        return array(
            'user' => $action_cost * $cost['user'],
            'referrer' => $action_cost * $cost['referrer'],
            'system' => $action_cost * $cost['system']
        );
    }

    // Перевод средств из временной метки к задаче

    public function completeToTask($complete_id)
    {
        // Получение метки выполнения 
        $complete = $this->Complete->get($complete_id);

        if (!$complete OR $complete->status != COMPLETE_WAITING) {
            return;
        }

        // Переводим средства на баланс задачи
        $this->db->where('id', $complete->task_id);
        $this->db->set('total_cost', 'total_cost+' . $complete->action_cost, false);
        //$this->db->set('action_done', 'action_done-1', false);
        //$this->db->set('hour_done', 'hour_done-1', false);
        $this->db->update('task');

        return $this->db->affected_rows();
    }
}