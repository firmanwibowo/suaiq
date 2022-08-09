<?php

class Menu_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function getAll()
    {
        $data = $this->db->get('menu')->result_array();
        return $data;
    }

    public function getById($id)
    {
        $data =  $this->db->get_where('menu', array('menu_id' => $id))->row_array();
        return $data;
    }

    public function insert($data)
    {

        $data = $this->db->insert('menu', $data);
        return $data;
    }

    public function count()
    {
        $data = $this->db->count_all_results('menu');
        return $data;
    }

    public function update($data, $id)
    {
        $data = $this->db->update('menu', $data, "menu_id = $id");
        return $data;
    }

    public function delete($id)
    {
        $data = $this->db->delete('menu', array('menu_id' => $id)); 
        return $data;
    }
}
