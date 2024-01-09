<?php 
class Penalty_Model extends CI_Model { 

	private $table = 'penalty';

	
	function getTotal()
	{
		return $this->db->count_all($this->table);
	}

    function getAllItems() {
        $query = $this->db->get($this->table);
        return $query->result();
    }

    function hasItem($field, $value) {
        $this->db->where($field, $value);
        $query = $this->db->get($this->table);
        return $query->num_rows();
    }

    function addItem($data) {
        return $this->db->insert($this->table, $data);
    }

    function removeItem($id) {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }
	function UserCommentPenaltys($id) {
		$this->db->where('user_id', $id);
		$query = $this->db->get($this->table);
		return $query->result();
	}

}