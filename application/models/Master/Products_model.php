<?php

class Products_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function autoNumber(){

        $this->db->select_max('pd_code', 'products_code');
        $query = $this->db->get('products')->result_array();
        if($query[0]['products_code'] != '')
		{
			$x=$query;
            $urut=intval(substr($query[0]['products_code'],2,5))+1;
            $urut="PD".substr("000",1,(3-strlen($urut))).$urut;	
		}else{
			$urut="PD001";
        }
        return $urut;
    }

    public function getAll()
    {
        $data = $this->db->get('products')->result_array();
        return $data;
    }

    public function count()
    {
        $data = $this->db->count_all_results('products');
        return $data;
    }

    public function getById($id)
    {
        $data =  $this->db->get_where('products', array('pd_code' => $id))->row_array();
        return $data;
    }

    public function insert($data)
    {

        $data = $this->db->insert('products', $data);
        return $data;
    }

    public function update($data, $id)
    {
        $data = $this->db->update('products', $data, "pd_code = '".$id."'");
        return $data;
    }

    public function delete($id)
    {
        $data = $this->db->delete('products', array('pd_code' => $id)); 
        return $data;
    }
}
