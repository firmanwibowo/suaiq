<?php

class Customer_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function autoNumber(){

        $this->db->select_max('cs_code', 'customer_code');
        $query = $this->db->get('customer')->result_array();
        if($query[0]['customer_code'] != '')
		{
            $urut=intval(substr($query[0]['customer_code'],2,11))+1;
            $urut="CS".substr("0000000000",1,(10-strlen($urut))).$urut;		
		}else{
			$urut="CS0000000001";
        }
        return $urut;
    }

    public function getAll()
    {
        $data = $this->db->get('customer')->result_array();
        return $data;
    }

    public function count()
    {
        $data = $this->db->count_all_results('customer');
        return $data;
    }

    public function getById($id)
    {
        $data =  $this->db->get_where('customer', array('cs_code' => $id))->row_array();
        return $data;
    }

    public function insert($data)
    {

        $data = $this->db->insert('customer', $data);
        return $data;
    }

    public function update($data, $id)
    {
        $data = $this->db->update('customer', $data, "cs_code = '".$id."'");
        return $data;
    }

    public function delete($id)
    {
        $data = $this->db->delete('customer', array('cs_code' => $id)); 
        return $data;
    }
}
