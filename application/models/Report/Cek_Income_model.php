<?php

class Cek_Income_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }


    public function getWorkerFee($worker){
        $sql = "SELECT  a.od_no, c.pd_code, c.pd_nm, (((b.price * b.qty) * (100 - b.admin_fee - b.develop_fee)) / 100) as income FROM suaiq.orders a
		INNER JOIN suaiq.order_detil b ON b.od_no = a.od_no 
		INNER JOIN suaiq.products c ON c.pd_code = b.pd_code 
		INNER JOIN suaiq.worker_detil d ON d.od_no  = a.od_no 
		INNER JOIN suaiq.worker e ON e.wr_code = d.wr_code 
WHERE  d.pd_code = b.pd_code AND a.sts_code = 'ST03' AND b.worker_fee_sts = 1 AND e.wr_nm = '".$worker."'";
        $data = $this->db->query($sql, array())->result_array();
        
        return $data;
    }

    public function updatedetilorders($data, $odno,$pdcode)
    {

        $this->db->trans_begin();
        $this->db->where('od_no', $odno);
        $this->db->where('pd_code', $pdcode);
        $this->db->update('order_detil', $data);
        
        if ($this->db->trans_status() === FALSE){
            return $this->db->trans_rollback();
        }else{
            return $this->db->trans_commit();
        }
    }
  
}
