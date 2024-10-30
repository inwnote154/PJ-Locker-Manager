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

                    <!-- Topbar Search -->
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
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
                    <!-- Page Heading -->
                    <!-- <h1 class="h3 mb-2 text-gray-800">รายชื่อพนักงานทั้งหมด</h1> -->
                    <div class="col ps-3 pe-3 mb-3">
                        <a href="ChooseAudit.php"class="btn btn-primary btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fas fa-arrow-right"></i>
                            </span>
                            <span class="text">ย้อนกลับ</span>
                        </a>
                    </div>
                    <div class="col ps-3 pe-3">
                    </div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <?php
                            if(isset($_POST['now'])){
                                $nowyear = $_POST['now'];
                            }else{$nowyear = date('Y');}
                            ?>
                            <h6 class="m-0 font-weight-bold text-primary">การตรวจสอบข้อมูลปี <?php echo $nowyear; ?></h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <?php
                                            if(isset($_GET['type'])){
                                            $_SESSION['type']=$_GET['type'];
                                            }
                                            $columns = ['A', 'B', 'C', 'D', 'E', 'F'];

                                            // สร้างหัวข้อคอลัมน์
                                            foreach ($columns as $col) {
                                                echo "<th>$col</th>";
                                            }
                                            ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $rows = 12;
                                    $months = ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน',
                                            'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];
                                    $countmonth = 1;
                                    // สร้างแถวและข้อมูล
                                    for ($i = 0; $i < $rows; $i++) {
                                        $countbuild  =1;
                                        echo "<tr>";
                                        echo "<td>{$months[$i]}</td>";

                                        // ตรวจสอบว่ามีข้อมูลในเดือนนั้นหรือไม่
                                        foreach ($columns as $col) {
                                            // $monthName = $months[$i];
                                            $columnName = $col;

                                            // เพิ่มการตรวจสอบข้อมูลในนี้
                                            if (checkDataExists($countmonth, $countbuild,$nowyear)) {
                                                if(checkAllFinish($countmonth, $countbuild,$nowyear)){
                                                    echo '<td class="bg-warning" width="12%">
                                                    <a class="text-white" href="auditresult.php?build='.$countbuild.'&year='.$nowyear.'&month='.$countmonth.'" >
                                                        <div class="w-100 h-100">(ยังไม่กดยืนยัน)</div>
                                                    </a>
                                                    </td>';
                                                }
                                                else{
                                                    echo '<td class="bg-success" width="12%">
                                                <a class="text-white" href="auditresult.php?build='.$countbuild.'&year='.$nowyear.'&month='.$countmonth.'" >
                                                    <div class="w-100 h-100">(มีข้อมูล)</div>
                                                </a>
                                                </td>';}
                                            } else {
                                                echo '<td width="12%">
                                                <a class="" href="auditresult.php?build='.$countbuild.'&year='.$nowyear.'&month='.$countmonth.'">
                                                    <div class="w-100 h-100">-</div>
                                                </a>
                                                </td>';
                                            }
                                            $countbuild++;
                                        }
                                        $countmonth++;

                                        echo "</tr>";
                                    }
                                    
                                    ?>

                                    </tbody>
                                </table>
                            </div>
                            <div class="col">
                                <div class="row">
                                    <div class="col-3 h4 mb-2 text-gray-800">เลือกปีที่ต้องการตรวจสอบ</div>
                                    <div class="col ps-3 pe-3">
                                        <form action="audittable.php" method="post" class="row">
                                            <select class="form-control form-control-sm col" name="now" id="now">
                                                <?php
                                                $year = date('Y');
                                                for($i=0;$i<5;$i++){
                                                    echo'<option value="'.$year.'">'.$year.'</option>';
                                                    $year--;
                                                }
                                                ?>
                                            </select>
                                            <input type="hidden" name="year">
                                            <button href="audittable.php" type="sumbit" class="col-auto ml-2 btn btn-info btn-icon-split btn-sm">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-check"></i>
                                                </span>
                                                <span class="text">submit</span>
                                            </button>
                                        </form>
                                        
                                        <div class="col ps-3 pe-3">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>                    

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

</body>

</html>
<?php
function checkDataExists($month, $column,$selectedDate) {
    // ทำการเชื่อมต่อกับฐานข้อมูล MSSQL
    include '../database.php';
    $type  = $_SESSION['type'];
    if (!$conn) {
        die(print_r(sqlsrv_errors(), true));
    }

    // ทำการตรวจสอบว่ามีข้อมูลในเดือนนั้นหรือไม่{
    if($_SESSION['selection'] == 1){
        $sql = "SELECT COUNT(*) as count FROM AuditData1 WHERE MONTH(startdate) = ? AND build = ? AND selection = '1'AND YEAR(startdate) = ? AND typeaudit = ? ";
    }
    else{
        $sql = "SELECT COUNT(*) as count FROM AuditData1 WHERE MONTH(startdate) = ? AND build = ? AND selection = '0.5' AND YEAR(startdate) = ? AND typeaudit = ?";

    }
    $params = array($month, $column,$selectedDate,$type);
    $stmt = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    $count = $result['count'];

    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn);
    if ($count>0) {
        
        return true;
    } else {
        return false;
    }

}
function checkAllFinish($month, $column,$selectedDate) {
    // ทำการเชื่อมต่อกับฐานข้อมูล MSSQL
    include '../database.php';
    $type  = $_SESSION['type'];
    if (!$conn) {
        die(print_r(sqlsrv_errors(), true));
    }

    // ทำการตรวจสอบว่ามีข้อมูลในเดือนนั้นหรือไม่{
    if($_SESSION['selection'] == 1){
        $sql = "SELECT COUNT(*) as count FROM AuditData1 WHERE MONTH(startdate) = ? AND build = ? AND selection = '1' AND staudit = 'process' AND YEAR(startdate) = ? AND typeaudit = ?";
    }
    else{
        $sql = "SELECT COUNT(*) as count FROM AuditData1 WHERE MONTH(startdate) = ? AND build = ? AND selection = '0.5' AND staudit = 'process' AND YEAR(startdate) = ? AND typeaudit = ?";

    }
    $params = array($month, $column,$selectedDate,$type);
    $stmt = sqlsrv_query($conn, $sql, $params);
    $result = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        $count = $result['count'];
        sqlsrv_free_stmt($stmt);
        sqlsrv_close($conn);
    if ($count>0) {
        return true;
    } else {
        return false;
    }

}
?>
