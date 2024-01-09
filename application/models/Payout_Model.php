<?php
Class Payout_Model extends CI_Model {

	private $table = 'payout';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function getItems($limit=100, $start=0) 
    {
        $this->db->limit((int)$limit, (int)$start);
        //$this->db->where('payed', '');
        $this->db->order_by("created", "desc"); 
        $query = $this->db->get($this->table);
        return $query->result();
    }

    function getItemsTotal() 
    {
        $this->db->select('COUNT(id) as total');
        $query = $this->db->get($this->table);
        return $query->row() ? intval($query->row()->total) : 0;
    }

    function getUnpayedItems() 
    {

        $this->db->where('payed', '');
        $this->db->order_by("created", "desc"); 
        $query = $this->db->get($this->table);
        return $query->result();
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

    function getPayouts($user_id, $limit=100, $start=0)
	{
        $this->db->limit((int)$limit, (int)$start);
        $this->db->where('user_id', (int)$user_id);
        $this->db->order_by("created", "desc"); 
        $query = $this->db->get($this->table);
        return $query->result();
	}

	function getPayoutsTotal($user_id) 
	{
        $this->db->where('user_id', (int)$user_id);
        $query = $this->db->get($this->table);
		return $query->num_rows();
	}





	


	function getReferrals($referrer_id, $limit=100, $start=0)
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


	function getTransactions($user_id, $limit=100, $start=0)
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

	function addTransactionRecord($data) 
	{
        $this->db->insert('transaction', $data);
		return $this->db->affected_rows();
	}

}