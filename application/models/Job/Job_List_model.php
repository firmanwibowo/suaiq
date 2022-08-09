<?php

class Job_List_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function getAllJobByWorkerName($workernm){
        $sql = "SELECT DISTINCT e.od_no, h.pd_code, h.pd_nm, f.qty, g.sts_nm FROM suaiq.users a
        INNER JOIN suaiq.user_roles b ON b.role_id = a.role_id 
        INNER JOIN suaiq.worker c ON c.user_id = a.user_id 
        INNER JOIN suaiq.worker_detil d ON d.wr_code = c.wr_code 
        INNER JOIN suaiq.orders e ON e.od_no  = d.od_no 
        INNER JOIN suaiq.order_detil f ON f.od_no  = e.od_no 
        INNER JOIN suaiq.status g ON g.sts_code = f.sts_code
        INNER JOIN suaiq.products h ON h.pd_code = f.pd_code 
        WHERE d.pd_code = f.pd_code 
        AND a.user_nm = ? AND g.sts_code != 'ST03'
        ORDER BY e.od_no ASC";
        $data = $this->db->query($sql, array($workernm))->result_array();
        
        return $data;
    }

    
    public function getOrder($workernm, $od_no, $pd_code)
    {
        $sql = "SELECT DISTINCT e.od_no, h.pd_code, h.pd_nm, f.qty, g.sts_code, g.sts_nm FROM suaiq.users a
        INNER JOIN suaiq.user_roles b ON b.role_id = a.role_id 
        INNER JOIN suaiq.worker c ON c.user_id = a.user_id 
        INNER JOIN suaiq.worker_detil d ON d.wr_code = c.wr_code 
        INNER JOIN suaiq.orders e ON e.od_no  = d.od_no 
        INNER JOIN suaiq.order_detil f ON f.od_no  = e.od_no 
        INNER JOIN suaiq.status g ON g.sts_code = f.sts_code
        INNER JOIN suaiq.products h ON h.pd_code = f.pd_code 
        WHERE d.pd_code = f.pd_code 
        AND a.user_nm = ? AND e.od_no = ? AND h.pd_code = ?";
        $data = $this->db->query($sql, array($workernm, $od_no, $pd_code))->row_array();
        return $data;
    }

    public function updateorders($data, $odno)
    {
        $data = $this->db->update('orders', $data, "od_no = '".$odno."'");
        return $data;
    }

    public function updatedetilorders($data, $odno, $pdcode)
    {
        $data = $this->db->update('order_detil', $data, array('od_no' => $odno, 'pd_code' => $pdcode));
        return $data;
    }
}
