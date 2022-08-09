<?php

class Fee_Approval_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }


    public function getDevelopFee(){
        $sql = "SELECT DISTINCT a.od_no, e.wr_nm,c.pd_code, c.pd_nm, b.price, b.qty, (b.price * b.qty) AS total_harga, b.develop_fee, ((b.price * b.qty * b.develop_fee) / 100) AS komisi_develop, b.develop_fee_sts from suaiq.orders a
        INNER JOIN suaiq.order_detil b ON b.od_no = a.od_no 
        INNER JOIN suaiq.products c ON c.pd_code = b.pd_code 
        INNER JOIN suaiq.worker_detil d ON d.od_no  = a.od_no 
        INNER JOIN suaiq.worker e ON e.wr_code = d.wr_code 
        WHERE  d.pd_code = b.pd_code AND a.sts_code = 'ST03' AND b.develop_fee_sts = 1";
        $data = $this->db->query($sql, array())->result_array();
        
        return $data;
    }

    public function updatedetilorders($data, $odno)
    {

        $this->db->trans_begin();
        $this->db->update_batch('order_detil', $data, $odno);

        if ($this->db->trans_status() === FALSE)
        {
                return $this->db->trans_rollback();
        }
        else
        {
                return $this->db->trans_commit();
        }
    }
  
}
