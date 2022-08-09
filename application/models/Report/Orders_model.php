<?php

class Orders_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function getFinishOrders($param){
        
        $sql = "SELECT DISTINCT a.od_no, a.od_tgl, f.sts_nm, c.wr_nm, e.pd_nm, d.price, d.qty, (d.price * d.qty) as total FROM suaiq.orders a
        INNER join suaiq.worker_detil b ON b.od_no = a.od_no 
        INNER join suaiq.worker c ON c.wr_code = b.wr_code 
        INNER join suaiq.order_detil d ON d.od_no = a.od_no 
        INNER join suaiq.products e ON e.pd_code = d.pd_code 
        INNER join suaiq.status f ON f.sts_code = a.sts_code 
        WHERE b.pd_code = e.pd_code  AND a.sts_code = 'ST03'
        AND DATE_FORMAT(a.od_tgl,'%Y-%m-%d') BETWEEN '".$param['startdate']."' AND '".$param['enddate']."'";
        
        $data = $this->db->query($sql, array())->result_array();
        return $data;
    }

}
