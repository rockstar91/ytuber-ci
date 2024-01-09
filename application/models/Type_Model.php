<?php

class Type_Model extends MY_Model
{

    protected $table = 'type';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function getTotal()
    {
        return $this->db->count_all($this->table);
    }

    function getAllItems()
    {
        $this->db->order_by('order');
        $query = $this->db->get($this->table);
        $query = parent::_lang($query);
        return $query->result();
    }

    function getItems($limit = 100, $start = 0)
    {
        $this->db->limit($limit, $start);
        $query = $this->db->get($this->table);
        $query = parent::_lang($query);
        return $query->result();
    }

    function addItem($data)
    {
        return $this->db->insert($this->table, $data);
    }

    function removeItem($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }

    function getHourLimit($id)
    {
        $type = $this->getItem($id);
        return $type ? $type->hour_limit : false;
    }

    function getItem($id)
    {
        $this->db->where('id', (int)$id);
        $this->db->limit(1);
        $query = $this->db->get($this->table);
        $rows = $query->result();
        $query = parent::_lang($query);
        return isset($rows[0]) ? $rows[0] : false;
    }

    function getCompleteDays($id)
    {
        $type = $this->getItem($id);
        return $type ? $type->complete_days : false;
    }

    function getCompleteWaitingTimeout($id)
    {
        $type = $this->getItem($id);
        return $type ? $type->complete_waiting_timeout : false;
    }

    function getWindowPattern($id)
    {
        $type = $this->getItem($id);
        return $type ? $type->window_pattern : false;
    }
}