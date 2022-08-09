<?php

class Divisi_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function autoNumber(){

        $this->db->select_max('div_code', 'divisi_code');
        $query = $this->db->get('divisi')->result_array();
        if($query[0]['divisi_code'] != '')
		{
			$x=$query;
            $urut=intval(substr($query[0]['divisi_code'],2,5))+1;
            $urut="DV".substr("0000",1,(4-strlen($urut))).$urut;	
		}else{
			$urut="DV0001";
        }
        return $urut;
    }

    public function getAll()
    {
        $data = $this->db->get('divisi')->result_array();
        return $data;
    }

    public function count()
    {
        $data = $this->db->count_all_results('divisi');
        return $data;
    }

    public function getById($id)
    {
        $data =  $this->db->get_where('divisi', array('div_code' => $id))->row_array();
        return $data;
    }

    public function insert($data)
    {

        $data = $this->db->insert('divisi', $data);
        return $data;
    }

    public function update($data, $id)
    {
        $data = $this->db->update('divisi', $data, "div_code = '".$id."'");
        return $data;
    }

    public function delete($id)
    {
        $data = $this->db->delete('divisi', array('div_code' => $id)); 
        return $data;
    }
}
