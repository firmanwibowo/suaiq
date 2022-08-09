<?php

class Status_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function autoNumber(){

        $this->db->select_max('sts_code', 'status_code');
        $query = $this->db->get('status')->result_array();
        if($query[0]['status_code'] != '')
		{
			$x=$query;
            $urut=intval(substr($query[0]['status_code'],2,4))+1;
            $urut="ST".substr("00",1,(2-strlen($urut))).$urut;	
		}else{
			$urut="ST01";
        }
        return $urut;
    }

    public function getAll()
    {
        $data = $this->db->get('status')->result_array();
        return $data;
    }

    public function count()
    {
        $data = $this->db->count_all_results('status');
        return $data;
    }

    public function getById($id)
    {
        $data =  $this->db->get_where('status', array('sts_code' => $id))->row_array();
        return $data;
    }

    public function insert($data)
    {

        $data = $this->db->insert('status', $data);
        return $data;
    }

    public function update($data, $id)
    {
        $data = $this->db->update('status', $data, "sts_code = '".$id."'");
        return $data;
    }

    public function delete($id)
    {
        $data = $this->db->delete('status', array('sts_code' => $id)); 
        return $data;
    }
}
