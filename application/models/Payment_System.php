<?php

Class Payment_System extends CI_Model
{
    protected $table = 'payment_system';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function getAllSystems()
    {
        return $this->db->get($this->table)->result();
    }


    function getSystem($id)
    {
        $this->db->where('id', (int)$id);
        $query = $this->db->get($this->table);
        return ($query->num_rows()>0) ? $query->row() : false;
    }

    function updateSystem($id, $data)
    {
        $this->db->where('id', (int)$id);
        $this->db->update($this->table, $data);
        return $this->db->affected_rows();
    }

}