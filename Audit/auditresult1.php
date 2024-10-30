<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Tables</title>

    <link rel="stylesheet" href="../main.css">
    <!-- Custom fonts for this template -->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <style>
      .Ahover div:hover{
        background-color: lightblue;
        color: gray;
      }
        .vertical-lr-text {
            transform: rotate(-90deg);
            writing-mode: vertical-rl;
            transform: rotate(180deg);
            text-align: left;
            padding-top: 10px;
        }
    </style>

</head>

<body id="page-top">
    <?php 
    session_start();
    if(empty($_SESSION['admin'])){
        header("Location:../login.php");
    }
    $admin = $_SESSION['admin'];
    include '../database.php';
    $query = "SELECT * FROM AuditData1 WHERE MONTH(enddate) = MONTH(GETDATE()) AND YEAR(enddate) = YEAR(GETDATE()) AND staudit = 'ok' AND selection = '0.5'";
    $result = sqlsrv_query($conn, $query);
    $count=0;
    if ($result === false) {
        echo "เกิดข้อผิดพลาดในการค้นหาข้อมูล: " . print_r(sqlsrv_errors(), true);
    } else {
        $rowCount = sqlsrv_has_rows($result);
        if (!$rowCount) {
            $count+=1;
        } else {}
    }
    $query = "SELECT * FROM AuditData1 WHERE
    (DATEDIFF(QUARTER, enddate, GETDATE()) >= 1 OR enddate IS NOT NULL)AND staudit = 'ok' AND selection = '1'";
    $result2 = sqlsrv_query($conn, $query);
    if ($result2 === false) {
       echo "เกิดข้อผิดพลาดในการค้นหาข้อมูล: " . print_r(sqlsrv_errors(), true);
    } else {
        $rowCount = sqlsrv_has_rows($result2);
        if (!$rowCount) {
            $count+=1;
        } else {}
    }
    ?>

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="../dashboard.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Smart Locker</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="../dashboard.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Interface
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>จัดการพนักงาน</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Custom Components:</h6>
                        <a class="collapse-item" href="../Emp/showEmployee.php">พนักงานทั้งหมด</a>
                        <a class="collapse-item" href="../Emp/admin_locker_new_employee.php">จัดการพนักงาน</a>
                        <a class="collapse-item" href="../Emp/adminAddhome.php">เพิ่มพนักงาน</a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseThree"
                    aria-expanded="true" aria-controls="collapseThree">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>ข้อมูลล็อคเกอร์</span>
                </a>
                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Custom Components:</h6>
                        <a class="collapse-item" href="../Out/lockerout.php">ที่เก็บรองเท้าภายนอก</a>
                        <a class="collapse-item" href="../Buddy/lockerbuddy.php">ที่เก็บรองเท้าบัดดี้</a>
                        <a class="collapse-item" href="../Shirt/lockershirt.php">ล็อคเกอร์เก็บของ</a>
                        <a class="collapse-item" href="../Log/showlog.php">ประวัติการทำงาน</a>
                        <a class="collapse-item" href="../Log/showbreaklog.php">ประวัติการแจ้งเสีย</a>
                    </div>
                </div>
            </li>
            <li class="nav-item active">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFour"
                    aria-expanded="true" aria-controls="collapseFour">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>การตรวจสอบ</span>
                </a>
                <div id="collapseFour" class="collapse show" aria-labelledby="headingFour" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Custom Components:</h6>
                        <?php 
                        if (isset($_SESSION['selection'])) {
                          if ($_SESSION['selection']==0.5) {
                            ?>
                            <a class="collapse-item active" href="../Audit/ChooseAudit.php?selection=0.5">ครึ่ง</a>
                            <a class="collapse-item" href="../Audit/ChooseAudit.php?selection=1">เต็ม</a>
                            <?php
                          }
                          else if (isset($_SESSION['selection'])==1) {
                            ?>
                            <a class="collapse-item" href="../Audit/ChooseAudit.php?selection=0.5">ครึ่ง</a>
                            <a class="collapse-item active" href="../Audit/ChooseAudit.php?selection=1">เต็ม</a>
                            <?php
                          }
                        }else{
                        ?>
                        <a class="collapse-item" href="../Audit/ChooseAudit.php?selection=0.5">ครึ่ง</a>
                        <a class="collapse-item" href="../Audit/ChooseAudit.php?selection=1">เต็ม</a>
                        <?php } ?>
                    </div>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#Allreport"
                    aria-expanded="true" aria-controls="Allreport">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>การทำรายงานผล</span>
                </a>
                <div id="Allreport" class="collapse" aria-labelledby="headingFour" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Custom Components:</h6>
                        <a class="collapse-item" href="../AllReport/MainReport.php">ตามแผนกพนักงาน</a>
                        <a class="collapse-item" href="../AllReport/date_select.php">รายงานการตรวจสอบ</a>
                        <a class="collapse-item" href="../AllReport/locker_filter.php">ตามล็อคเกอร์</a>
                    </div>
                </div>
            </li>
            
            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <form class="form-inline">
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
                        </button>
                    </form>

                    
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->
                                <?php
                                if($count==0){
                                    echo'<span class="badge badge-danger badge-counter"></span>';
                                }else{
                                    echo'<span class="badge badge-danger badge-counter">'.$count.'</span>';
                                }
                                ?>
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Alerts Center
                                </h6>
                                <?php
                                $query = "SELECT * FROM AuditData1 WHERE MONTH(enddate) = MONTH(GETDATE()) AND YEAR(enddate) = YEAR(GETDATE()) AND staudit = 'ok' AND selection = '0.5'";
                                $result = sqlsrv_query($conn, $query);
                                if ($result === false) {
                                    echo "เกิดข้อผิดพลาดในการค้นหาข้อมูล: " . print_r(sqlsrv_errors(), true);
                                } else {
                                    $rowCount = sqlsrv_has_rows($result);
                                    if (!$rowCount) {
                                        ?>
                                        <a class="dropdown-item d-flex align-items-center" href="#">
                                            <div class="mr-3">
                                                <div class="icon-circle bg-warning">
                                                    <i class="fas fa-exclamation-triangle text-white"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="small text-gray-500">December 12, 2019</div>
                                                ไม่มีข้อมูลแบบครึ่งในเดือนนี้ กรุณาเพิ่มข้อมูล!
                                            </div>
                                        </a>
                                        <?php
                                    } else {}
                                }
                                $query = "SELECT * FROM AuditData1 WHERE
                                (DATEDIFF(QUARTER, enddate, GETDATE()) >= 1 OR enddate IS NOT NULL)AND staudit = 'ok' AND selection = '1'";
                                $result2 = sqlsrv_query($conn, $query);
                                if ($result2 === false) {
                                    echo "เกิดข้อผิดพลาดในการค้นหาข้อมูล: " . print_r(sqlsrv_errors(), true);
                                } else {
                                    $rowCount = sqlsrv_has_rows($result2);
                                    if (!$rowCount) {
                                        ?>
                                        <a class="dropdown-item d-flex align-items-center" href="#">
                                            <div class="mr-3">
                                                <div class="icon-circle bg-warning">
                                                    <i class="fas fa-exclamation-triangle text-white"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="small text-gray-500">December 12, 2019</div>
                                                ไม่มีข้อมูลใน3เดือนนี้แบบเต็ม กรุณาเพิ่มข้อมูล!
                                            </div>
                                        </a>
                                        <?php
                                    } else {}
                                }
                                ?>
                                <!-- <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a> -->
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $admin; ?></span>
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="../signature_php/sign_master.php">
                                    <i class="fas fa-signature fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Signature
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

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <?php
                    include '../database.php';
                    if (isset($_GET['id_selection'])){
                      $id_selection = $_GET['id_selection'];
                    ?>
                    <!-- Page Heading -->
                    <!-- <h1 class="h3 mb-2 text-gray-800">รายชื่อพนักงานทั้งหมด</h1> -->
                    <div class="row mb-3">
                        <div class="col-2 ps-3 pe-3">
                            <?php echo'<a href="../PrintPDF/PrintPDF.php?lo=auditresult&id_selection='.$id_selection.'" target="_blank"class="btn btn-primary btn-icon-split w-100">'?>
                                <span class="icon text-white-50 w-25">
                                    <i class="fas fa-download"></i>
                                </span>
                                <span class="text w-75">ปริ้น</span>
                            </a>
                        </div>
                        <div class="col-8"></div>
                        <div class="col-2 ps-3 pe-3">
                            <a href="javascript:history.back()"class="btn btn-info btn-icon-split w-100">
                                <span class="icon text-white-50 w-25">
                                    <i class="fas fa-arrow-right"></i>
                                </span>
                                <span class="text w-75">ย้อนกลับ</span>
                            </a>
                        </div>
                    </div>
                    
                    <!-- DataTales Example -->
                    <?php
                    
                    ?>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered text-center" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th class='align-middle border'>ลำดับ</th>
                                            <th class='align-middle border'>อาคาร</th>
                                            <th class='align-middle border'>เวลาที่ตรวจสอบ</th>
                                            <th class='align-middle border'>คำนำหน้า</th>
                                            <th class='align-middle border'>ล็อคเกอร์</th>
                                            <th class='align-middle border'>รหัสตู้</th>
                                            <th class='align-middle border'>แผนก-รหัสพนักงาน</th>
                                            <th class='border vertical-lr-text'>1. ไม่มีสัตว์พาหะอยู่ในล็อคเกอร์</th>
                                            <th class='border vertical-lr-text'>2. ห้ามติดสติกเกอร์ใดๆ ที่ตู้ล็อคเกอร์</th>
                                            <th class='border vertical-lr-text'>3. ห้ามนำจาน-ชามของบริษัทฯมาเก็บในตู้ล็อคเกอร์</th>
                                            <th class='border vertical-lr-text'>4. ห้ามนำสิ่งของทุกชนิดมาเก็บไว้ในตู้ล็อคเกอร์ว่าง 
                                              <br>หรือตู้ล็อคเกอร์ของผู้อื่นโดยไม่ได้รับอนุญาต</th>
                                            <th class='border vertical-lr-text'>5. ห้ามนำอาหารและเครื่องดื่มเข้ามาเก็บในตู้ล็อคเกอร์</th>
                                            <th class='border vertical-lr-text'>6. ห้ามรับประทานอาหารและเครื่องดื่มภายในห้องแต่งตัว</th>
                                            <th class='border vertical-lr-text'>7. ห้ามนำสินค้าทุกชนิดมาจำหน่ายในห้องแต่งตัว</th>
                                            <th class='border vertical-lr-text'>8. ห้ามงัดและเคลื่อนย้ายตู้ล็อคเกอร์</th>
                                            <th class='border vertical-lr-text'>9. สภาพตู้ล็อคเกอร์ไม่ชำรุด</th>
                                            <th class='border vertical-lr-text'>อื่นๆ</th>
                                            <th class='align-middle'>audit</th>
                                        </th>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $sql3 = "SELECT AuditData1.*,building.* FROM AuditData1 
                                    JOIN building ON building.building_id = AuditData1.build 
                                    WHERE format_id = '$id_selection' 
                                    ";
                                    $stmt3 = sqlsrv_query($conn,$sql3);
                                    while ($row = sqlsrv_fetch_array($stmt3, SQLSRV_FETCH_ASSOC)) {
                                      $entryDate = $row['startdate'] !== null ? $row['startdate']->format('Y-m-d H:i:s') : ''; // ตรวจสอบ EntryDate ก่อนใช้ format()
                                      $exitDate = $row['enddate'] !== null ? $row['enddate']->format('Y-m-d H:i:s') : ''; // ตรวจสอบ ExitDate ก่อนใช้ format()
                                      echo "<tr><td class='align-middle p-2'>" .$count . "</td>";
                                      $count++;

                                      echo "<td class='align-middle p-2'>" . $row['building_name'] . "</td>";
                                      echo "<td class='align-middle p-2'>" .$entryDate . "</td>";
                                      echo "<td class='align-middle p-2'>" . $row['InitialT'] . "</td>";
                                      echo "<td class='align-middle p-2'>" . $row['typeaudit'] . "</td>";
                                      echo "<td class='align-middle p-2'>" . $row['lockernumber'] . "</td>";
                                      echo "<td class='align-middle p-2'>" . $row['departmentno'] .'-'.$row['userid']. "</td>";
                                      if($row['check1']===1){
                                        echo"<td>✓</td>";
                                      }
                                      elseif($row['check1']===0 ){
                                          echo"<td>✗</td>";
                                      }else{echo"<td></td>";}
                                      if($row['check2']===1){
                                          echo"<td>✓</td>";
                                      }
                                      elseif($row['check2']===0){
                                          echo"<td>✗</td>";
                                      }else{echo"<td></td>";}
                                      if($row['check3']===1){
                                          echo"<td>✓</td>";
                                      }
                                      elseif($row['check3']===0){
                                          echo"<td>✗</td>";
                                      }else{echo"<td></td>";}
                                      if($row['check4']===1){
                                          echo"<td>✓</td>";
                                      }
                                      elseif($row['check4']===0){
                                          echo"<td>✗</td>";
                                      }else{echo"<td></td>";}
                                      if($row['check5']===1){
                                          echo"<td>✓</td>";
                                      }
                                      elseif($row['check5']===0){
                                          echo"<td>✗</td>";
                                      }else{echo"<td></td>";}
                                      if($row['check6']===1){
                                          echo"<td>✓</td>";
                                      }
                                      elseif($row['check6']===0){
                                          echo"<td>✗</td>";
                                      }else{echo"<td></td>";}
                                      if($row['check7']===1){
                                          echo"<td>✓</td>";
                                      }
                                      elseif($row['check7']===0){
                                          echo"<td>✗</td>";
                                      }else{echo"<td></td>";}
                                      if($row['check8']===1){
                                          echo"<td>✓</td>";
                                      }
                                      elseif($row['check8']===0){
                                          echo"<td>✗</td>";
                                      }else{echo"<td></td>";}
                                      if($row['check9']===1){
                                          echo"<td>✓</td>";
                                      }
                                      elseif($row['check9']===0){
                                          echo"<td>✗</td>";
                                      }else{echo"<td></td>";}
                                      if($row['other']==='1' || $row['other']=== ""){
                                          echo"<td>✓</td>";
                                      }
                                      else{
                                          // echo"<td>✗</td>";
                                          echo "<td class='align-middle p-2'>" . $row['other'] . "</td>";
                                      }
                                      echo "<td class='align-middle p-2'>" . $row['auditname'] . "</td>";
                                      }
                                      echo '</tr>'
                                    ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php 
                }
              ?>  
                
                
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2020</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="../login.php">Logout</a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- None Modal-->
    <div class="modal fade" id="NoneModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ไม่มีข้อมูลพนักงานอยู่ในตู้</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <!-- <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div> -->
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">ยืนยัน</button>
                </div>
            </div>
        </div>
    </div>

    
    <!-- Have Modal-->
    <div class="modal fade" id="HaveModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">มีการเพิ่มข้อมูลการตรวจสอบชนิดนี้อยู่แล้ว</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <!-- <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div> -->
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">ยืนยัน</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../js/demo/datatables-demo.js"></script>

    <script>
      <?php
        if (isset($_GET['message'])) {
            if ($_GET['message']=='nonedata') {
                ?>
                $("#NoneModal").modal('show');
                <?php
            } else if ($_GET['message']=='havedata') {
                ?>
                $("#HaveModal").modal('show');
                <?php
            }
        } 
      ?>
      
    </script>

</body>

</html>
