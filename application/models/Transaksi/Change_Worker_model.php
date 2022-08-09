<?php

class Change_Worker_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }



    public function getAll()
    {
        $sql = "SELECT a.od_no, f.sts_nm, c.wr_nm, e.pd_code, e.pd_nm, d.price, d.qty, (100 - d.admin_fee - d.develop_fee) as fee, ((d.price * d.qty * (100 - d.admin_fee - d.develop_fee )) / 100) as total FROM suaiq.orders a
        INNER join suaiq.worker_detil b ON b.od_no = a.od_no 
        INNER join suaiq.worker c ON c.wr_code = b.wr_code 
        INNER join suaiq.order_detil d ON d.od_no = a.od_no 
        INNER join suaiq.products e ON e.pd_code = d.pd_code 
        INNER join suaiq.status f ON f.sts_code = a.sts_code 
        WHERE b.pd_code = e.pd_code  AND a.sts_code != 'ST03' ";
        
        $data = $this->db->query($sql, array())->result_array();
        return $data;
    }


    public function getById($odno, $pdcode)
    {
        $sql = "SELECT a.od_no, f.sts_nm, c.wr_code, c.wr_nm, e.pd_code, e.pd_nm, d.price, d.qty, (100 - d.admin_fee - d.develop_fee) as fee, ((d.price * d.qty * (100 - d.admin_fee - d.develop_fee )) / 100) as total FROM suaiq.orders a
        INNER join suaiq.worker_detil b ON b.od_no = a.od_no 
        INNER join suaiq.worker c ON c.wr_code = b.wr_code 
        INNER join suaiq.order_detil d ON d.od_no = a.od_no 
        INNER join suaiq.products e ON e.pd_code = d.pd_code 
        INNER join suaiq.status f ON f.sts_code = a.sts_code 
        WHERE b.pd_code = e.pd_code  AND a.sts_code != 'ST03' AND a.od_no = '".$odno."' AND e.pd_code = '".$pdcode."' ";
        
        $data =   $data = $this->db->query($sql, array())->row_array();
        return $data;
    }

    public function insert($data)
    {

        $data = $this->db->insert('change_of_workers', $data);
        return $data;
    }

    public function update($data, $od_no, $product_code)
    {
        $this->db->where('od_no', $od_no);
        $this->db->where('pd_code', $product_code);
        $data = $this->db->update('worker_detil', $data);
    
        return $data;
    }

    public function getWorkerSame($od_no, $product_code,  $worker_code)
    {
        $sql = "SELECT * FROM suaiq.change_of_workers a
        INNER JOIN suaiq.orders b on a.od_no = b.od_no
        WHERE od_no = '".$od_no."' AND pd_code = '".$product_code."'  AND wr_code = '".$worker_code."' AND sts_code != 'ST03'";
        
        $data =   $data = $this->db->query($sql, array())->row_array();
        return $data;
    }

}
