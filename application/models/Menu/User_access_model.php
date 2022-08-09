<?php

class User_access_model extends CI_Model
{
    // function __construct()
    // {
    //     parent::__construct();
    // }

    public function getAllMenu()
    {
        $data = $this->db->get('menu')->result_array();
        return $data;
    }

    public function getAllRole()
    {
        $data = $this->db->get('user_roles')->result_array();
        return $data;
    }

    public function getMenuById($id)
    {
        $data =  $this->db->get_where('menu', array('menu_id' => $id))->row_array();
        return $data;
    }

    public function getRoleById($id)
    {
        $data =  $this->db->get_where('user_roles', array('role_id' => $id))->row_array();
        return $data;
    }

    public function accessValidasi($roleid, $menuid)
    {
        $data =  $this->db->get_where('user_access_menu', array('role_id' => $roleid, 'menu_id' => $menuid))->row_array();
        return $data;
    }
    public function insertAll($data)
    {

        $data = $this->db->insert_batch('user_access_menu', $data);
        return $data;
    }

}
