<?php

/*
 * Copyright 2017 User.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 * Description of Complete_Model
 *
 * @author User
 */
Class Complete_Model extends CI_Model
{
    public $defaultStatus = COMPLETE_OPENED;
    private $table = 'done';
    private $type;

    function __construct()
    {
        parent::__construct();

        $this->now = round(time() / 60) * 60;

        $this->load->model('Type_Model', 'Type');
    }

    // Получение метки
    function get($id)
    {
        $this->db->where('id', (int)$id);
        $query = $this->db->get($this->table);
        return ($query->num_rows() > 0) ? $query->row() : false;
    }

    function add($user_id, &$task, $cost_rule = null, $account_id = null, $data = null)
    {
        $time = time();
        // необходимая задержка перед выполнением
        $timeout = 0;
        // время, до которого задача может быть выполнена
        $expires = $time + $this->Type->getCompleteWaitingTimeout($task->type_id);

        // Устанавливаем timeout и expires, если у задачи есть время
        if (isset($task->extend['time'])) {
            $timeout = $task->extend['time'];
            $expires = $time + $task->extend['time'] + 300;
        }

        // Количество меток об этой задаче
        $started = $this->countWaiting($task->id) + $this->countOpened($task->id);

        $doneRemain = $task->total_cost / $task->action_cost;

        if($task->type_id == TASK_TYPE_LIKE) {
            $doneRemain = 1; // может быть открыта только одним человеком
        }

        // Не хватит бюджета на всех 
        if ($started >= $doneRemain) {
            return false;
        }

        // Не хватит лимита в час на всех
        //if ($task->hour_limit > 0 && ($task->hour_done + $started) >= $task->hour_limit) {
        //    return false;
        //}

        $this->removeOutdatedOpened();
        $this->remove($user_id, $task->id, $task->type_id);

        // domain
        $domain = $this->input->server('HTTP_HOST') == 'ytubey.com' ? DOMAIN_YTUBEY : DOMAIN_YTUBER;

        // add new
        $data = array(
            'user_id' => $user_id,
            'task_id' => $task->id,
            'type_id' => $task->type_id,
            //'account_id'    => (int) $account_id,
            'ip_bin' => inet_pton($this->input->ip_address()),
            'action_cost' => $task->action_cost,
            'cost_rule' => (int)$cost_rule,
            'time' => $time,
            'expires' => (int)$expires,
            'timeout' => (int)$timeout,
            'data' => (int)$data,
            'domain' => $domain,
            'status' => $this->defaultStatus
        );

        $this->db->insert($this->table, $data);
        return $this->db->affected_rows();
    }

    // Удаление метки
    /*
     * @param $user_id, $task_id, $type_id, $status
     * @return integer
     */

    function countOpened($task_id)
    {
        $this->db->where('task_id', $task_id);
        $this->db->where('expires >', time());
        $this->db->where('status', COMPLETE_OPENED);
        $query = $this->db->get($this->table);
        return $query->num_rows();
    }

    function countWaiting($task_id)
    {
        $this->db->where('task_id', $task_id);
        $this->db->where('expires >', time());
        $this->db->where('status', COMPLETE_WAITING);
        $query = $this->db->get($this->table);
        return $query->num_rows();
    }

    // Удаление метки о задачах, которые были открыты, но не завершены

    function removeOutdatedOpened()
    {
        $this->db->where('expires <', time());
        $this->db->where('status', COMPLETE_OPENED);
        $this->db->delete($this->table);
        return $this->db->affected_rows();
    }

    // Возвращает кол-во открытых задач с тем-же id

    function remove($user_id, $task_id = null, $type_id = null, $status = null)
    {
        $this->db->where('user_id', (int)$user_id);
        if ($task_id) {
            $this->db->where('task_id', (int)$task_id);
        }
        if ($type_id) {
            $this->db->where('type_id', (int)$type_id);
        }
        if ($status) {
            $this->db->where('status', (int)$status);
        }
        $this->db->delete($this->table);
        return $this->db->affected_rows();
    }

    function getUserFinishedCostSum($user_id, $offset = 86400)
    {
        $this->db->select('SUM(action_cost) as total');
        $this->db->where('user_id', (int)$user_id);
        $this->db->where('time >', time() - $offset);
        $this->db->where('status', COMPLETE_FINISHED);
        $query = $this->db->get($this->table);

        return ($query->num_rows() > 0) ? $query->row()->total : false;
    }

    // Возвращает кол-во открытых задач с тем-же id
    function countUnfinished($task_id=null, $user_id=null, $type_id=null)
    {
        if($task_id) {
            $this->db->where('task_id', $task_id);
        }
        if(!is_null($user_id)) {
            $this->db->where('user_id', $user_id);
        }
        if($type_id) {
            $this->db->where('type_id', $type_id);
        }
        //$this->db->where('expires >', time());
        $this->db->where('status <', COMPLETE_FINISHED);
        $query = $this->db->get($this->table);
        return $query->num_rows();
    }

    function getCountAllFinishedTypes($user_id, $offset = 0)
    {
        $this->db->select('COUNT(id) as total, type_id');
        $this->db->where('user_id', (int)$user_id);
        if ($offset > 0) {
            $timestamp = time() - $offset;
            $this->db->where('time >', $timestamp);
        }
        $this->db->where('status', COMPLETE_FINISHED);
        $this->db->group_by('type_id');

        $query = $this->db->get($this->table);

        $result = array();
        foreach ($query->result() as $item)
        {
            $result[$item->type_id] = $item->total;
        }

        return $result;
    }

    function countFinished($user_id, $type_id, $offset = 0)
    {
        $allFinishedTypes = $this->getCountAllFinishedTypes($user_id, $offset);

        return isset($allFinishedTypes[$type_id]) ? $allFinishedTypes[$type_id] : null;

        /*
        $this->db->select('id');
        $this->db->where('user_id', (int)$user_id);
        $this->db->where('type_id', (int)$type_id);
        if ($offset > 0) {
            $timestamp = time() - $offset;
            $this->db->where('time >', $timestamp);
        }
        $this->db->where('status', COMPLETE_FINISHED);
        $query = $this->db->get($this->table);
        return $query->num_rows();
        */
    }

    function countFinishedByType($user_id, $offset = 0)
    {

        $this->db->select('COUNT(id) as total, type_id');
        $this->db->where('user_id', (int)$user_id);
        if ($offset > 0) {
            $timestamp = time() - $offset;
            $this->db->where('time >', $timestamp);
        }
        $this->db->where('status', COMPLETE_FINISHED);
        $this->db->group_by('type_id');
        $query = $this->db->get($this->table);
        return $query->result();
    }

    function updateItem($id, $data)
    {
        $this->db->where('id', (int)$id);
        $this->db->update($this->table, $data);
        return $this->db->affected_rows();
    }

    // Увеличение счетчика у других открытых меток с этим-же task_id
    function updateData($task_id)
    {
        $this->db->where('task_id', (int)$task_id);
        $this->db->set('data', 'data+1', false);
        $this->db->update($this->table);

        return $this->db->affected_rows();
    }

    function setStatus($id, $status)
    {
        $this->db->where('id', (int)$id);
        $this->db->set('time', time());
        $this->db->set('status', (int)$status);
        $this->db->update($this->table);

        return $this->db->affected_rows();
    }

    // Получение меток по параметрам

    function getOpened($user_id, $task_id)
    {
        $query = $this->getItemsBy($user_id, $task_id, COMPLETE_OPENED, time());
        return ($query->num_rows() > 0) ? $query->row() : false;
    }

    // Получение метки со статусом COMPLETE_OPENED

    function getItemsBy($user_id = false, $task_id = false, $status = false, $expires = false)
    {
        if ($user_id !== false) {
            $this->db->where('user_id', (int)$user_id);
        }
        if ($task_id) {
            $this->db->where('task_id', (int)$task_id);
        }
        if ($status) {
            $this->db->where('status', (int)$status);
        }
        if ($expires) {
            $this->db->where('expires >', (int)$expires);
        }

        return $this->db->get($this->table);
    }

    // Получение метки со статусом COMPLETE_WAITING

    function getWaiting($user_id, $task_id)
    {
        $query = $this->getItemsBy($user_id, $task_id, COMPLETE_WAITING);
        return ($query->num_rows() > 0) ? $query->row() : false;
    }

    // Получение метки со статусом COMPLETE_WAITING
    function getFailed($user_id, $task_id)
    {
        $query = $this->getItemsBy($user_id, $task_id, COMPLETE_FAILED);
        return ($query->num_rows() > 0) ? $query->row() : false;
    }

    function getPenalty($user_id, $task_id) 
    {
        $query = $this->getItemsBy($user_id, $task_id, COMPLETE_PENALTY);
        return ($query->num_rows() > 0) ? $query->result() : false;
    }

    // проверяет, выполнена ли задача пользователем
    function isFinished($user_id, &$task)
    {
        $completeDays = $this->Type->getCompleteDays($task->type_id);

        $this->db->where('user_id', (int)$user_id);
        $this->db->where('task_id', (int)$task->id);

        if ($completeDays) {
            $time = time() - $completeDays * 3600;
        } else {
            $time = time() - 24 * 3600;
        }
        $this->db->where('time > ', $time);
        //$this->db->where('status > ', COMPLETE_OPENED);
        $this->db->where('status', COMPLETE_FINISHED);

        $this->db->limit(1);
        $query = $this->db->get($this->table);
        return ($query->num_rows() > 0) ? true : false;
    }


    function isHourLimitReach($type_id = 0, $user_id = null)
    {
        $time = $this->now - 3600;

        $this->db->select('COUNT(id) as total');
        $this->db->where('time >', $time);
        $this->db->where('status', COMPLETE_FINISHED);

        if (is_null($user_id)) {
            $ip_bin = inet_pton($this->input->ip_address());
            $this->db->where('ip_bin', $ip_bin);
        } else {
            $this->db->where('user_id', $user_id);
        }

        // фильтр по типу 
        if ($type_id > 0) {
            $this->db->where('type_id', $type_id);
        } else {
            $type_id = 'any';
        }

        $query = $this->db->get($this->table)->row();

        $typeHourLimit = $this->Type->getHourLimit($type_id);

        if ($type_id && $query->total >= $typeHourLimit) {
            return true;
        }

        return false;
    }
}