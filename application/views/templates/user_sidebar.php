<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url($user['url']); ?>">
        <div class="text-center">
            <img src="<?= base_url('uploads/users/suaiq.png') ?>" class="img-circle" alt="Cinque Terre" width="45" height="40">                     
        </div>
        <div class="sidebar-brand-text mx-2" ><label style="color:cyan">SUAIQ </label> <label style="color:DarkOrchid">SYSTEM </label></div>
    </a>

    <!--START QUERY MENU-->
    <?php
    $role_id = $this->session->userdata['role_id'];
    $querymenu = "SELECT * FROM `menu`
             JOIN `user_access_menu` ON `menu`.`menu_id` = `user_access_menu`.`menu_id`
             JOIN `user_roles` ON `user_access_menu`.`role_id`  = `user_roles`.`role_id`
            WHERE `user_access_menu`.`role_id`  = $role_id AND `menu`.`is_active` = 1
            ORDER BY `menu`.`ordering` ASC";

    $menu = $this->db->query($querymenu)->result_array();
    ?>
    <!--END QUERY MENU-->


    <!-- Nav Item - Pages Collapse Menu-->
    <?php foreach ($menu as $m) : ?>
        <!-- Divider -->
        <hr class="sidebar-divider">
        <?php
        $menu = $m['menu_id'];
        $querysubmenu = "SELECT * FROM `sub_menu` WHERE `sub_menu`.`menu_id` = $menu AND `sub_menu`.`is_active` = 1 ORDER BY `sub_menu`.`ordering` ASC";
        $submenu = $this->db->query($querysubmenu)->result_array();
        ?>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#menu_<?= $m['menu_id'] ?>" aria-expanded="true" aria-controls="collapseTwo">
                <i class="<?= $m['icon'] ?>"></i>
                <span><?= $m['menu_nm'] ?></span>
                
            </a>
            <div id="menu_<?= $m['menu_id'] ?>" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <?php foreach ($submenu as $sm) : ?>
                        <?php if($sm['sub_nm'] == 'JOB CHECKING') {?>
                            <a class="collapse-item" href="<?= base_url($sm['url']); ?>">
                            <i class="fas fa-fw">&nbsp<?= $sm['sub_nm'] ?></i> <br> 
                            <?php
                                $jobchecking = "SELECT count(*) as `jumlah` FROM `suaiq`.`orders` WHERE `sts_code` != 'ST03'";
                                $jobcheckqty = $this->db->query($jobchecking)->row_array();
                            ?>
                                    <span class="jobcheckingnotification" style="font-family: Arial, Helvetica, sans-serif; position: absolute;
                                    top: 80px;
                                    left: 140px;
                                    padding: 5px 10px;
                                    border-radius: 50%;
                                    background-color: red;
                                    color: white;"> <?= $jobcheckqty['jumlah'] ?></span>            
                        </a>
                        <?php } else if($sm['sub_nm'] == 'SEND FEE') {?>
                            <a class="collapse-item" href="<?= base_url($sm['url']); ?>">
                                <i class="fas fa-fw">&nbsp<?= $sm['sub_nm'] ?></i> <br>           
                            </a>
                            <?php
                                $allfeefromuser = "SELECT sum(jumlah) as total
                                            FROM (
                                                    SELECT count(a.od_no)  as jumlah from suaiq.orders a
                                                        INNER JOIN suaiq.order_detil b ON b.od_no = a.od_no 
                                                        INNER JOIN suaiq.products c ON c.pd_code = b.pd_code 
                                                        INNER JOIN suaiq.worker_detil d ON d.od_no  = a.od_no 
                                                        INNER JOIN suaiq.worker e ON e.wr_code = d.wr_code 
                                                    WHERE  d.pd_code = b.pd_code 
                                                        AND a.sts_code = 'ST03' AND b.develop_fee_sts = 0
                                                        
                                                    union all
                                                        
                                                    SELECT count(a.od_no) as jumlah from suaiq.orders a
                                                        INNER JOIN suaiq.order_detil b ON b.od_no = a.od_no 
                                                        INNER JOIN suaiq.products c ON c.pd_code = b.pd_code 
                                                        INNER JOIN suaiq.worker_detil d ON d.od_no  = a.od_no 
                                                        INNER JOIN suaiq.worker e ON e.wr_code = d.wr_code 
                                                    WHERE  d.pd_code = b.pd_code 
                                                        AND a.sts_code = 'ST03' AND b.admin_fee_sts = 0 
                                                        
                                                    union all
                                                        
                                                    SELECT count(a.od_no) as jumlah from suaiq.orders a
                                                        INNER JOIN suaiq.order_detil b ON b.od_no = a.od_no 
                                                        INNER JOIN suaiq.products c ON c.pd_code = b.pd_code 
                                                        INNER JOIN suaiq.worker_detil d ON d.od_no  = a.od_no 
                                                        INNER JOIN suaiq.worker e ON e.wr_code = d.wr_code 
                                                    WHERE  d.pd_code = b.pd_code 
                                                        AND a.sts_code = 'ST03' AND b.worker_fee_sts = 0 
                                        ) getalljumlahfee";
                                $allfee = $this->db->query($allfeefromuser)->row_array();
                            ?>
                            <span class="jobcheckingnotification" style="font-family: Arial, Helvetica, sans-serif; position: absolute;
                                    top: 118px;
                                    left: 140px;
                                    padding: 5px 10px;
                                    border-radius: 50%;
                                    background-color: red;
                                    color: white;"><?= $allfee['total'] ?>
                            </span>
                        <?php } else if($sm['sub_nm'] == 'JOB LIST') {?>
                            <a class="collapse-item" href="<?= base_url($sm['url']); ?>">
                                <i class="fas fa-fw">&nbsp<?= $sm['sub_nm'] ?></i> <br>           
                            </a>
                            <?php
                                $username = $this->session->userdata['user_nm'];
                                $joblist = "SELECT DISTINCT count(*) AS jumlah_job_list FROM suaiq.users a
                                INNER JOIN suaiq.user_roles b ON b.role_id = a.role_id 
                                INNER JOIN suaiq.worker c ON c.user_id = a.user_id 
                                INNER JOIN suaiq.worker_detil d ON d.wr_code = c.wr_code 
                                INNER JOIN suaiq.orders e ON e.od_no  = d.od_no 
                                INNER JOIN suaiq.order_detil f ON f.od_no  = e.od_no 
                                INNER JOIN suaiq.status g ON g.sts_code = f.sts_code
                                INNER JOIN suaiq.products h ON h.pd_code = f.pd_code 
                                WHERE d.pd_code = f.pd_code AND g.sts_code != 'ST03'
                                AND a.user_nm = '".$username."'
                                ORDER BY e.od_no ASC";
                                $joblistqty = $this->db->query($joblist)->row_array();
                            ?>
                            <span class="jobcheckingnotification" style="font-family: Arial, Helvetica, sans-serif; position: absolute;
                                    top: 12px;
                                    left: 140px;
                                    padding: 5px 10px;
                                    border-radius: 50%;
                                    background-color: red;
                                    color: white;"><?= $joblistqty['jumlah_job_list'] ?>
                            </span>
                      
                        <?php } else if($sm['sub_nm'] == 'FEE APPROVAL') {?>
                            <a class="collapse-item" href="<?= base_url($sm['url']); ?>">
                                <i class="fas fa-fw">&nbsp<?= $sm['sub_nm'] ?></i> <br>           
                            </a>
                            <?php
                                $adminfee = "SELECT DISTINCT COUNT(*) AS countfeedevelop FROM suaiq.orders a
                                INNER JOIN suaiq.order_detil b ON b.od_no = a.od_no 
                                INNER JOIN suaiq.products c ON c.pd_code = b.pd_code 
                                INNER JOIN suaiq.worker_detil d ON d.od_no  = a.od_no 
                                INNER JOIN suaiq.worker e ON e.wr_code = d.wr_code 
                                WHERE  d.pd_code = b.pd_code AND a.sts_code = 'ST03' AND b.develop_fee_sts = 1";
                                $adminfeecount = $this->db->query($adminfee)->row_array();
                            ?>
                              <span class="jobcheckingnotification" style="font-family: Arial, Helvetica, sans-serif; position: absolute;
                                    top: 10px;
                                    left: 140px;
                                    padding: 5px 10px;
                                    border-radius: 50%;
                                    background-color: red;
                                    color: white;"><?= $adminfeecount['countfeedevelop'] ?>
                            </span>

                        <?php } else if($sm['sub_nm'] == 'CEK INCOME') {?>
                            <a class="collapse-item" href="<?= base_url($sm['url']); ?>">
                                <i class="fas fa-fw">&nbsp<?= $sm['sub_nm'] ?></i> <br>           
                            </a>
                            <?php
                                $adminfee = "SELECT DISTINCT COUNT(*) AS countfeeworker FROM suaiq.orders a
                                INNER JOIN suaiq.order_detil b ON b.od_no = a.od_no 
                                INNER JOIN suaiq.products c ON c.pd_code = b.pd_code 
                                INNER JOIN suaiq.worker_detil d ON d.od_no  = a.od_no 
                                INNER JOIN suaiq.worker e ON e.wr_code = d.wr_code 
                                WHERE  d.pd_code = b.pd_code AND a.sts_code = 'ST03' AND b.worker_fee_sts = 1 AND e.wr_nm = '".$this->session->userdata('user_nm')."'";
                                $adminfeecount = $this->db->query($adminfee)->row_array();
                            ?>
                              <span class="jobcheckingnotification" style="font-family: Arial, Helvetica, sans-serif; position: absolute;
                                    top: 10px;
                                    left: 140px;
                                    padding: 5px 10px;
                                    border-radius: 50%;
                                    background-color: red;
                                    color: white;"><?= $adminfeecount['countfeeworker'] ?>
                            </span>
                     
                     
                        <?php } else { ?>
                            <a class="collapse-item" href="<?= base_url($sm['url']); ?>">
                                <i class="fas fa-fw">&nbsp<?= $sm['sub_nm'] ?></i> <br>           
                            </a>
                        <?php } ?>    
                        <!-- <?php if (strtoupper($sm['sub_nm']) == strtoupper($sm['sub_nm'])) : ?>
                            <a class="collapse-item active" href="<?= base_url($sm['url']); ?>">
                                <i class="fas fa-fw fa-sign-out-alt">&nbsp<?= $sm['sub_nm'] ?></i>
                            </a>
                        <?php else : ?>
                            <a class="collapse-item" href="<?= base_url($sm['url']); ?>">
                                <i class="fas fa-fw fa-sign-out-alt">&nbsp<?= $sm['sub_nm'] ?></i>
                            </a>
                        <?php endif; ?> -->


                    <?php endforeach; ?>
                </div>
            </div>
        </li>
    <?php endforeach; ?>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block mt-100">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->