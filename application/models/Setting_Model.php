<?php
Class Setting_Model extends CI_Model {

	private $table = 'setting';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();

        $this->datetime = date('Y-m-d H:i:s');

        $this->removeOutdated();
    }

    function add($key, $val) {
        $data = array(
            'key'   => $key,
            'val'   => $val,
            'time'  => $this->datetime
        );
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

	function get($key, $expire=null) 
	{
        $this->db->where('key', $key);
        if($expire) {
            $this->db->where('time >', date('Y-m-d H:i:s', time()-$expire));
        }
        $this->db->order_by('rand()');
        $this->db->limit(1);
        $query = $this->db->get($this->table);

        return ($query->num_rows()>0) ? $query->row()->val : false;
	}

    function update($key, $val) 
    {
        $this->db->where('key', $key);
        $this->db->set('val', $val);
        $this->db->set('time', date('Y-m-d H:i:s'));
        $this->db->update($this->table);
        return $this->db->affected_rows();
    }


    function remove($key)
    {
        $this->db->where('key', $key);
        $this->db->delete($this->table);
        return $this->db->affected_rows();
    }

    function removeOutdated($expire=3600) {
        $this->db->where('time <', date('Y-m-d H:i:s', time()-$expire));
        $this->db->delete($this->table);
        return $this->db->affected_rows();
    }

}