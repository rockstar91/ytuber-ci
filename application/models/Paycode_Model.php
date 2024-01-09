<?php
Class Paycode_Model extends CI_Model {

	private $table = 'paycode';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

	

	function getItem($code) 
	{
        $this->db->where('code', $code);
        $this->db->limit(1);
        $query = $this->db->get($this->table);
        return ($query->num_rows()>0) ? $query->row() : false;
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