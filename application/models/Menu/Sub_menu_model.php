<?php

class Sub_Menu_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function getAllMenu()
    {
        $data = $this->db->get('menu')->result_array();
        return $data;
    }

    public function getById($id)
    {
        $data =  $this->db->get_where('menu', array('menu_id' => $id))->row_array();
        return $data;
    }

    public function insertAll($data)
    {

        $data = $this->db->insert_batch('sub_menu', $data);
        return $data;
    }

}
