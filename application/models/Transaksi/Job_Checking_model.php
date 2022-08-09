<?php

class Job_Checking_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function getAll(){
        $this->db->select('orders.od_no, orders.od_tgl, status.sts_code, status.sts_nm');
        $this->db->from('orders');
        $this->db->join('status', 'status.sts_code = orders.sts_code');
        $this->db->where('status.sts_code !=','ST03');
        $this->db->order_by('orders.sts_code', 'DESC');
        $this->db->order_by('orders.od_no', 'ASC');
        $data = $this->db->get()->result_array();
        return $data;
    }

    public function count()
    {
        $data = $this->db->count_all_results('orders');
        return $data;
    }

    public function getAllOrderByCode($odno){
        $sql = "SELECT DISTINCT a.od_no, e.wr_nm, c.pd_nm, a.qty, a.price, (a.qty * a.price) as total_harga, b.sts_code, b.sts_nm from suaiq.order_detil a
        INNER JOIN suaiq.status b ON b.sts_code = a.sts_code 
        INNER JOIN suaiq.products c ON c.pd_code = a.pd_code
        INNER JOIN suaiq.worker_detil d ON d.od_no = a.od_no 
        INNER JOIN suaiq.worker e ON e.wr_code = d.wr_code 
        WHERE a.pd_code = d.pd_code AND a.od_no = ?
        ORDER BY b.sts_code DESC";
        $data = $this->db->query($sql, array($odno))->result_array();
        
        return $data;
    }

    public function getByCode($id)
    {
        $this->db->select('*');
        $this->db->from('orders');
        $this->db->join('status', 'status.sts_code = orders.sts_code');
        $this->db->where('orders.od_no',$id);
        $data = $this->db->get()->row_array();
        return $data;
    }

    public function updateorders($data, $odno)
    {
        $data = $this->db->update('orders', $data, "od_no = '".$odno."'");
        return $data;
    }

    public function updatedetilorders($data, $odno)
    {
        $data = $this->db->update('order_detil', $data, "od_no = '".$odno."'");
        return $data;
    }
  
}
