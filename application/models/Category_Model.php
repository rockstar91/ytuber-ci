<?php

class Category_Model extends MY_Model
{

    protected $table = 'category';
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

    function getAllItems()
    {
        if (empty($this->categories)) {
            $categories = array();
            $query = $this->db->get($this->table);
            $query = parent::_lang($query);
            foreach ($query->result() as $item) {
                $categories[$item->id] = $item;
            }
            $this->categories = $categories;
        }

        return $this->categories;
    }

    function getItems($limit = 100, $start = 0)
    {
        $this->db->limit($limit, $start);
        $query = $this->db->get($this->table);
        $query = parent::_lang($query);
        return $query->result();
    }

    function getItem($id)
    {
        $categories = $this->Category->getAllItems();
        return isset($categories[$id]) ? $categories[$id] : null;
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

}