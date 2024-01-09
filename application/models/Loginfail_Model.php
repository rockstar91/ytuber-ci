<?php

Class Loginfail_Model extends CI_Model
{

    private $table = 'loginfail';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->datetime = date('Y-m-d H:i:s');
    }

    function add($mail, $password)
    {
        $data = array(
            'ip' => $this->input->ip_address(),
            'time' => $this->datetime,
            'mail' => $mail,
            'password' => $password
        );
        $this->db->insert($this->table, $data);

        //$this->removeOlder();

        return $this->db->affected_rows();
    }

    function count()
    {
        $this->db->where('time >', 'NOW() - INTERVAL 1 HOUR', false);
        $this->db->where('ip', $this->input->ip_address());
        return $this->db->count_all_results($this->table);
    }

    function removeOlder()
    {
        $this->db->where('time <', 'NOW() - INTERVAL 5 HOUR', false);
        $this->db->delete($this->table);
    }


}