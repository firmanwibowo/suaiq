<?php

class User_entry_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function getAll()
    {
        $this->db->from('users');
        $this->db->join('user_roles', 'users.role_id = user_roles.role_id');
        $data = $this->db->get()->result_array();
        //$data = $this->db->get('users')->result_array();
        return $data;
    }

    public function getById($id)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->join('user_roles', 'users.role_id = user_roles.role_id');
        $this->db->where('users.user_id', $id);
        $data = $this->db->get()->row_array();
        return $data;
    }

    public function insert($data)
    {

        $data = $this->db->insert('users', $data);
        return $data;
    }

    public function count()
    {
        $data = $this->db->count_all_results('users');
        return $data;
    }

    public function update($data, $id)
    {
        $data = $this->db->update('users', $data, "user_id = $id");
        return $data;
    }

    public function searchbyname()
    {
        $data = $this->db->update('users', $data, "user_id = $id");
        return $data;
    }

    function search($username)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where(strtoupper('users.user_nm'), strtoupper($username));
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function delete($id)
    {
        $data = $this->db->delete('users', array('user_id' => $id)); 
        return $data;
    }
}
