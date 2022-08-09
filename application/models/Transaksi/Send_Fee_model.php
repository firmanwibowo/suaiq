<?php

class Send_Fee_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function getDataUserAll(){
        $sql = "SELECT DISTINCT c.wr_code, c.wr_nm FROM suaiq.orders a
                INNER join suaiq.worker_detil b ON b.od_no = a.od_no 
                INNER join suaiq.worker c ON c.wr_code = b.wr_code 
                INNER join suaiq.order_detil d ON d.od_no = a.od_no 
                INNER join suaiq.products e ON e.pd_code = d.pd_code 
                INNER join suaiq.status f ON f.sts_code = a.sts_code 
                WHERE 1 = 1 AND a.sts_code = 'ST03' and b.pd_code = d.pd_code 
                AND d.worker_fee_sts = 0";
        $data = $this->db->query($sql, array())->result_array();
        return $data;
    }

    public function getAllFee($data){
        $sql = "SELECT DISTINCT a.od_no, e.wr_nm,c.pd_code, c.pd_nm, b.price, b.qty, (b.price * b.qty) AS total_harga, ".$data['fee']." from suaiq.orders a
                    INNER JOIN suaiq.order_detil b ON b.od_no = a.od_no 
                    INNER JOIN suaiq.products c ON c.pd_code = b.pd_code 
                    INNER JOIN suaiq.worker_detil d ON d.od_no  = a.od_no 
                    INNER JOIN suaiq.worker e ON e.wr_code = d.wr_code 
                 WHERE  d.pd_code = b.pd_code 
                    AND a.sts_code = 'ST03'  ".$data['feests']."";
        $data = $this->db->query($sql, array())->result_array();
        return $data;
    }

    public function updateDetilOrder($data, $odno,$pdcode){
    
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
