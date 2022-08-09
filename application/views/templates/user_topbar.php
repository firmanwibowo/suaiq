   <!-- Content Wrapper -->
   <div id="content-wrapper" class="d-flex flex-column">

       <!-- Main Content -->
       <div id="content">

           <!-- Topbar -->
           <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

               <!-- Sidebar Toggle (Topbar) -->
               <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                   <i class="fa fa-bars"></i>
               </button>

               <!-- Topbar Navbar -->
               <ul class="navbar-nav ml-auto">

                   <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                   <li class="nav-item dropdown no-arrow d-sm-none">
                       <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                           <i class="fas fa-search fa-fw"></i>
                       </a>
                       <!-- Dropdown - Messages -->
                       <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                           <form class="form-inline mr-auto w-100 navbar-search">
                               <div class="input-group">
                                   <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                   <div class="input-group-append">
                                       <button class="btn btn-primary" type="button">
                                           <i class="fas fa-search fa-sm"></i>
                                       </button>
                                   </div>
                               </div>
                           </form>
                       </div>
                   </li>

                <!--START QUERY MENU-->
                <?php
                    $user_name = $this->session->userdata('user_nm');
                    $role_id = $this->session->userdata('role_id');
                    $query = "SELECT c.role_id FROM suaiq.users a
                    INNER JOIN suaiq.user_roles c ON c.role_id = a.role_id 
                    WHERE a.user_nm = '".$user_name."' AND c.role_id = '".$role_id."' ";

                    $datauser = $this->db->query($query)->row_array();
                ?>
                <!--END QUERY MENU-->

                <?php if($datauser['role_id'] == 2) {?>

                    <!-- Nav Item - Alerts -->
                    <li class="nav-item dropdown no-arrow mx-1">
                        <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-bell fa-fw"></i>
                            <!-- Counter - Alerts -->
                            <!-- <span class="badge badge-danger badge-counter">3+</span> -->
                            <?php
                                $user_name = $this->session->userdata('user_nm');
                                $role_id = $this->session->userdata('role_id');
                                $sql_query=$this->db->query("call suaiq.get_data_duedate('".$user_name."',  $role_id)");                     
                                $duedate = $sql_query->row_array();
                                mysqli_next_result($this->db->conn_id); 
                            ?>

                            <?php if($duedate['total']> 0) {?>
                                <span class="badge badge-danger badge-counter"><?= $duedate['total'] ?>+</span>
                            <?php  } ?>
                        </a>

                        <!-- Dropdown - Alerts -->
                        <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown" style="height: 300px; overflow: auto;">
                            <h6 class="dropdown-header">
                            <center>Time Management</center>
                            </h6>
                            <?php
                                $user_name = $this->session->userdata('user_nm');
                                $role_id = $this->session->userdata('role_id');
                                $sql_query=$this->db->query("call suaiq.get_detil_duedate('".$user_name."',  $role_id)");                     
                                $detilduedate = $sql_query->result_array();
                            ?>

                            <?php foreach ($detilduedate as $key => $value) {?>
                                <?php  
                                    $date = new DateTime($value['due_date']);
                                    $myDateTime = date_format($date, 'd-M-Y');
                                ?>
                                <a class="dropdown-item d-flex align-items-center" href="<?= base_url('JobList'); ?>">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-danger">
                                        <i class="fas fa-bullhorn"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">Daedline: <?= $myDateTime ?></div>
                                        <span class="font-weight-bold"><?= $value['od_no'] ?></span>
                                        <span class="font-weight-bold"><?= $value['pd_nm'] ?></span>
                                        <!-- <span class="font-weight-bold"><?= $value['pd_code'] ?></span> -->
                                        <?php $substr = substr($value['datediff'],0,1) ?>
                                        <?php if($substr == '-'){ ?>
                                            <div class="small text-gray-500">Daedline Is Less Than:  <?= substr($value['datediff'],1) ?> Days</div>
                                        <?php } elseif($value['datediff'] == 0) { ?>
                                            <div class="small text-gray-500">Daedline Is Today.!!</div>
                                        <?php } else { ?>
                                            <div class="small text-gray-500">Daedline Is More Than: <?= $value['datediff'] ?> Days</div>
                                       <?php }?>
                                        
                                    </div>
                                </a>
                            <?php } ?>
                        </div>
                    </li>

                    <div class="topbar-divider d-none d-sm-block"></div>

                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= strtoupper($user['user_nm']) ?></span>
                            <img class="img-profile rounded-circle" src="<?= base_url('uploads/users/') . $user['image'] ?>">
                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                Profile
                            </a>
                            <a class="dropdown-item" href="<?= base_url('user/test') ?>">
                                <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                Settings
                            </a>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                Activity Log
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Logout
                            </a>
                        </div>
                    </li>

                    </ul>

                    </nav>
                    <!-- End of Topbar -->

                <?php } else { ?>

                    <div class="topbar-divider d-none d-sm-block"></div>

                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= strtoupper($user['user_nm']) ?></span>
                            <img class="img-profile rounded-circle" src="<?= base_url('uploads/users/') . $user['image'] ?>">
                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                Profile
                            </a>
                            <a class="dropdown-item" href="<?= base_url('user/test') ?>">
                                <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                Settings
                            </a>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                Activity Log
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Logout
                            </a>
                        </div>
                    </li>

                    </ul>

                    </nav>
                    <!-- End of Topbar -->

                <?php } ?>

                 