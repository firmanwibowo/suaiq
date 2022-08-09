<?php

class Auth_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function save($table, $post_data)
    {
        $query = $this->db->insert($table, $post_data);
        return $query;
    }

    function search($post_data)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->join('user_roles', 'users.role_id = user_roles.role_id');
        $this->db->where('users.user_nm', $post_data['user_nm']);
        $query = $this->db->get()->row_array();
        // print_r($query);
        // exit;
        //$query = $this->db->get_where($table, array('email' => $post_data['email']))->row_array(); //->row_array();
        return $query;
    }
}
