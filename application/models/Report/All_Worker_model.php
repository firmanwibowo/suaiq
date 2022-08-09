<?php

class All_Worker_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function getNewWorker($param){
        
        $sql = "SELECT * FROM suaiq.change_worker 
        WHERE DATE_FORMAT(od_tgl,'%Y-%m-%d') BETWEEN '".$param['startdate']."' AND '".$param['enddate']."'
        ORDER BY reason, od_no ASC";
        
        $data = $this->db->query($sql, array())->result_array();
        return $data;
    }

}
