<?php
/**
 * Created by PhpStorm.
 * User: me
 * Date: 02.05.2020
 * Time: 13:58
 */


class TaskAlternateIds_Model extends CI_Model
{

    protected $table = 'task_alternate_ids';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();

        $this->datetime = date('Y-m-d H:i:s');
    }

    function getItem($id)
    {
        $this->db->where('id', (int) $id);
        $this->db->limit(1);
        $query = $this->db->get($this->table);
        return ($query->num_rows()>0) ? $query->row() : false;
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

    function getItemByTaskId($task_id)
    {
        $this->db->where('task_id', (int)$task_id);
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit(1);


        $query = $this->db->get($this->table);

        if ($query->num_rows()>0)
        {
            return $query->row();
        }
    }

    function getItemsByTaskId($task_id, &$created_at=null)
    {

        $this->db->where('task_id', (int)$task_id);
        $this->db->order_by('created_at', 'DESC');


        $query = $this->db->get($this->table);

        if ($query->num_rows()>0)
        {
            $created_at = $query->row()->created_at;
        }

        return $query->result();
    }

    function removeItemsByTaskId($task_id)
    {
        $this->db->where('id', (int)$task_id);
        return $this->db->delete($this->table);
    }

}