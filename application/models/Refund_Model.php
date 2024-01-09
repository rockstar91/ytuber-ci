<?php
Class Refund_Model extends CI_Model {

	private $table = 'refund';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
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
    	if($id > 0) {
	        $this->db->where('id', (int) $id);
	        $this->db->delete($this->table);
	        return $this->db->affected_rows();
    	}
    	return false;
    }

    function getRefundsTotal()
    {
        $this->db->select('COUNT(id) as total');
        //$this->db->where('status', 1);
        $query = $this->db->get($this->table);
        return $query->row() ? intval($query->row()->total) : 0;
    }

    function getRefunds($limit = 100, $start = 0)
    {
        $this->db->limit((int)$limit, (int)$start);
        //$this->db->where('status', 1);
        $this->db->order_by("created_at", "desc");
        $query = $this->db->get($this->table);
        return $query->result();
    }

}