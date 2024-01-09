<?php

Class Payments_Model extends CI_Model
{

    private $table = 'payments';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
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

    function addItem($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->affected_rows();
    }


    function removeItem($id)
    {
        $this->db->where('id', $id);
        $this->db->delete($this->table);
        return $this->db->affected_rows();
    }

}