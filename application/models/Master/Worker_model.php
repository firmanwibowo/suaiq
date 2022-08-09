<?php

class Worker_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function autoNumber(){

        $this->db->select_max('wr_code', 'worker_code');
        $query = $this->db->get('worker')->result_array();
        if($query[0]['worker_code'] != '')
		{
			$x=$query;
            $urut=intval(substr($query[0]['worker_code'],2,4))+1;
            $urut="WK".substr("00",1,(2-strlen($urut))).$urut;	
		}else{
			$urut="WK01";
        }
        return $urut;
    }

    public function getUser(){
        $this->db->select('user_id, user_nm')->from('users');
        $this->db->where('role_id = "2" AND `user_id` NOT IN (SELECT `user_id` FROM `worker`)', NULL, FALSE);
        $data = $this->db->get()->result_array();
        return $data;
    }

    public function getAll()
    {
        $data = $this->db->get('worker')->result_array();
        return $data;
    }

    public function count()
    {
        $data = $this->db->count_all_results('worker');
        return $data;
    }

    public function getById($id)
    {
        $this->db->select('*');
        $this->db->from('worker');
        $this->db->join('divisi', 'divisi.div_code = worker.div_code');
        $this->db->where('worker.wr_code', $id);
        $data = $this->db->get()->row_array();
        return $data;
    }

    public function getDivisiById($id)
    {
        $data =  $this->db->get_where('divisi', array('div_code' => $id))->row_array();
        return $data;
    }

    public function getUserById($id)
    {
        $data =  $this->db->get_where('users', array('user_id' => $id))->row_array();
        return $data;
    }

    public function insert($data)
    {

        $data = $this->db->insert('worker', $data);
        return $data;
    }

    public function update($data, $id)
    {
        $data = $this->db->update('worker', $data, "wr_code = '".$id."'");
        return $data;
    }

    public function delete($id)
    {
        $data = $this->db->delete('worker', array('wr_code' => $id)); 
        return $data;
    }
}
