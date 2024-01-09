<?php

class Comment_Model extends MY_Model
{

    protected $table = 'comment';
    private $categories = array();

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function getTotal()
    {
        return $this->db->count_all($this->table);
    }

    function getItem($task_id, $status=COMMENT_FREE)
    {
        $this->db->limit(1);
        $this->db->where('task_id', $task_id);
        $this->db->where('status', $status);
        $query = $this->db->get($this->table);
        return ($query->num_rows() > 0) ? $query->row() : false;
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

    function removeByTaskId($task_id)
    {
        $this->db->where('task_id', $task_id);
        return $this->db->delete($this->table);
    }

    function updateItem($id, $data)
    {
        $this->db->where('id', (int)$id);
        $this->db->update($this->table, $data);
        return $this->db->affected_rows();
    }

    function getItemsBy($where, $limit=null, $offset=0)
    {
        // условия
        if(is_array($where))
        {
            foreach ($where as $k=>$v)
            {
                $this->db->where($k, $v);
            }
        }

        // лимит
        if($limit)
        {
            $this->db->limit((int) $offset, (int)$limit);
        }

        $query = $this->db->get($this->table);

        // возврат результата
        if($limit === 1 && $query->num_rows() > 0)
        {
            return $query->row();
        }
        else
        {
            return $query->result();
        }
    }
		function FreeCommentsCount($id)
		{
		$this->db->where('status', COMMENT_FREE);
		$this->db->where('task_id', $id);
		$comment = $this->db->get('comment');
		return $comment->num_rows();
		}

}