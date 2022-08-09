<?php

class Trx_Order_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function autoNumber(){

        $date = date('d');
        $month = date('m');
        $year = date('Y');

        $sql = "SELECT MAX(od_no) AS order_no FROM orders WHERE SUBSTRING(od_no, 14, 2) = ?";
        $query = $this->db->query($sql, array($month))->result_array();
        
        if($query[0]['order_no'] != '')
		{
			$x=$query;
            $urut=intval(substr($query[0]['order_no'],22,28))+1;
            $urut="SUAIQ/ORD/$date/$month/$year/".substr("0000000",1,(7-strlen($urut))).$urut;

		}else{
			$urut="SUAIQ/ORD/$date/$month/$year/0000001";
        }
        return $urut;
    }

    public function insertOrder($dataorder){
        $this->db->trans_begin();
        $this->db->insert('orders', $dataorder);

        if ($this->db->trans_status() === FALSE){
                return $this->db->trans_rollback();
        }else{
                return $this->db->trans_commit();
        }

    }

    public function insertOrderDetil($dataorderdetil){
        $this->db->trans_begin();
        $this->db->insert_batch('order_detil', $dataorderdetil);

        if ($this->db->trans_status() === FALSE){
                return $this->db->trans_rollback();
        }else{
                return $this->db->trans_commit();
        }

    }

    public function insertWorkerDetil($dataworkerdetil){
        $this->db->trans_begin();
        $this->db->insert_batch('worker_detil', $dataworkerdetil);

        if ($this->db->trans_status() === FALSE){
                return $this->db->trans_rollback();
        }else{
                return $this->db->trans_commit();
        }
    }

    public function getAllProductActive()
    {
        $this->db->where('status', 1);
        $data = $this->db->get('products')->result_array();
        return $data;
    }

}
