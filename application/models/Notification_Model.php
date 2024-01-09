<?php 
class Notification_Model extends MY_Model { 

	protected $table = 'notification';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function getItemsTotal($user_id=null)
    {
        if($user_id != null) {
            $this->db->where('user_id', (int)$user_id);
        }
        return $this->db->count_all_results($this->table);
    }

    function getItems($user_id, $limit=100, $start=0)
    {
        $this->db->limit($limit, $start);
        $this->db->where('user_id', (int) $user_id);
        $this->db->order_by('time', 'desc');
        $query = $this->db->get($this->table);
        //$query = parent::_lang($query);
        return $query->result();
    }

    function addItem($data) {
        return $this->db->insert($this->table, $data);
    }

    function removeItem($id) {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }
}