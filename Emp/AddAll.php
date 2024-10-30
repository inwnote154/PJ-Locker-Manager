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
    
    <!-- <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css"> -->
    <!-- <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script> -->
    <!-- <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->
</head>
<body id="page-top">

    <script>
        function showPopup() {
            // Display the popup
            document.getElementById("popup-container").style.display = "block";
        }

        function hidePopup() {
            // Hide the popup
            document.getElementById("popup-container").style.display = "none";
        }
    </script>
    <div id="popup-container-edit">
        <!-- Content of the popup -->
        <p>แก้ไขข้อมูลพนักงานเรียบร้อยแล้ว</p>
        <center><button onclick="hidePopup_edit()" type="button" class="m-0 p-0 btn btn-outline-success set1 rounded-5">ยืนยัน</button></center>
    </div>
    <script>
        <?php
            // Check if message is present in the URL
            if (isset($_GET['message'])) {
                ?>
                showPopup_edit()
                <?php
            }
            // else {
            //     echo "<p>No message received.</p>";
            // }
        ?>
        function showPopup_edit() {
            // Display the popup
            document.getElementById("popup-container-edit").style.display = "block";
        }

        function hidePopup_edit() {
            // Hide the popup
            document.getElementById("popup-container-edit").style.display = "none";
        }
    </script>

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
            <li class="nav-item active">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>จัดการพนักงาน</span>
                </a>
                <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Custom Components:</h6>
                        <a class="collapse-item" href="../Emp/showEmployee.php">พนักงานทั้งหมด</a>
                        <a class="collapse-item active" href="../Emp/admin_locker_new_employee.php">จัดการพนักงาน</a>
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
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFour"
                    aria-expanded="true" aria-controls="collapseFour">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>การตรวจสอบ</span>
                </a>
                <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Custom Components:</h6>
                        <a class="collapse-item" href="../Audit/ChooseAudit.php?selection=0.5">ครึ่ง</a>
                        <a class="collapse-item" href="../Audit/ChooseAudit.php?selection=1">เต็ม</a>
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
                    <div class="row">
                        <div class="col-lg-3"></div>
                        <div class="col-lg-6">

                            <!-- Default Card Example -->
                            <div class="card mb-6 text-dark shadow">
                                <div class="card-header">
                                    เพิ่มข้อมูลพนักงานเข้าตู้
                                </div>
                                <div class="card-body">
                                  <form action="All_in_locker.php" method="post">
                                    <table class="container-fluid">
                                        <tr>
                                            <td class=' p-2 pb-4' width='30%'>พนักงาน</td>
                                            <td class=' p-2 pb-4' width='70%'>
                                            <div>
                                                <?php
                                                $idcard = $_GET['idcard'];
                                                $name = $_GET['name'];
                                                echo ('<input class="form-control form-control-sm" type="hidden" id="employee_id" 
                                                name="employee_id" value="'.$idcard.'"readonly>
                                                <input type="hidden" id="AllEdit" 
                                                name="AllEdit" value="1"readonly>
                                                <input class="form-control form-control-sm" type="text" id="" 
                                                name="" value="'.$idcard.' '.$name.'"readonly>');
                                                ?>
                                                </select>
                                            </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class=' p-2 pb-4' width='30%'>รหัสตู้ห้องแต่งตัวพนักงาน</td>
                                            <td class=' p-2 pb-4' width='70%'>
                                            <div>
                                                <select class="form-control form-control-sm selectpicker select2" id="employee_shirt" name="employee_shirt" 
                                                data-live-search="true">
                                                <option value="" selected disabled>Choose...</option>
                                                <?php
                                                $sql1 = "SELECT * FROM locker_shirt WHERE UsStatus = 'ว่าง'
                                                ";
                                                $stmt = sqlsrv_query($conn, $sql1);
                                                while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                                    echo'<option value="'.$row['shirt_number'].'">'.$row['shirt_number'].' '
                                                    .'</option>';       
                                                }
                                                ?>
                                                </select>
                                            </div>                          
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class=' p-2 pb-4' width='30%'>รหัสตู้เก็บรองเท้าบัดดี้</td>
                                            <td class=' p-2 pb-4' width='70%'>
                                            <div>
                                                <select class="form-control form-control-sm selectpicker select3"  id="employee_buddy" name="employee_buddy" 
                                                data-live-search="true">
                                                <option value="" selected disabled>Choose...</option>
                                                <?php
                                                $sql1 = "SELECT * FROM buddy_locker WHERE UsStatus = 'ว่าง'
                                                ";
                                                $stmt = sqlsrv_query($conn, $sql1);
                                                while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                                    echo'<option value="'.$row['buddy_number'].'">'.$row['buddy_number'].' '
                                                    .'</option>';       
                                                }
                                                ?>
                                                </select>
                                            </div>                          
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class=' p-2 pb-4' width='30%'>รหัสตู้เก็บรอเท้าภายนอก</td>
                                            <td class=' p-2 pb-4' width='70%'>
                                            <div>
                                                <select class="form-control form-control-sm selectpicker select4"  id="employee_out" name="employee_out" 
                                                data-live-search="true">
                                                <option value="" selected disabled>Choose...</option>
                                                <?php
                                                $sql1 = "SELECT * FROM locker_out WHERE UsStatus = 'ว่าง'
                                                ";
                                                $stmt = sqlsrv_query($conn, $sql1);
                                                while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                                    echo'<option value="'.$row['out_number'].'">'.$row['out_number'].' '
                                                    .'</option>';       
                                                }
                                                ?>
                                                </select>
                                            </div>                          
                                            </td>
                                        </tr>
                                    </table>
                                    <center>
                                        <button type="submit" class="btn btn-success btn-icon-split">    
                                            <span class="icon text-white-50">
                                                <i class="fas fa-check"></i>
                                            </span>
                                            <span class="text">เพิ่มข้อมูล</span>
                                        </button>
                                        <a href="admin_locker_new_employee.php"class="btn btn-danger btn-icon-split">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-trash"></i>
                                            </span>
                                            <span class="text">ยกเลิก</span>
                                        </a>
                                    </center>
                                  </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3"></div>
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

    <div class="modal fade" id="EditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">โปรดระบุจำนวนที่ต้องการแก้ไข</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="../report/editstatus.php" method="post">
                    <div class="modal-body">
                    <?php
                        echo ('
                            <input class="w-100" type="number" name="stat" id="stat" value="'.($rowcount2['total']+$stat).'">
                            <input type="hidden" name="type" id="type" value="out" readonly>
                            <input type="hidden" name="number" id="number" value="'.$employeeout.'" readonly>
                            <input type="hidden" name="status" id="status" value="'.$stat.'" readonly>

                        ');
                    ?>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success" type="submit">ยืนยัน</button>
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">ยกเลิก</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="popup-container">
        <p>โปรดระบุจำนวน</p>
        <?php
            echo ('
            <form action="editstatus.php" method="post">
                <input type="number" name="stat" id="stat" value="'.($rowcount2['total']+$stat).'">
                <input type="hidden" name="type" id="type" value="out" readonly>
                <input type="hidden" name="number" id="number" value="'.$employeeout.'" readonly>
                <input type="hidden" name="status" id="status" value="'.$stat.'" readonly>

                <div class="row mt-3">
                <div class="col"><button type="submit" class="m-0 p-0 btn btn-outline-success rounded-5 w-100">ยืนยัน</button></div>
                <div class="col"><button type="button" onclick="hidePopup()" class="m-0 p-0 btn btn-outline-danger rounded-5 w-100">ยกเลิก</button></div>
                </div>
            </form>
            ');
        ?>
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

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

    <script>
        $('.select2, .select3, .select4').select2();

        $("#employee_buddy").change(function(){
            // รับค่าที่ถูกเลือกจาก select สำหรับตู้บัดดี้
            var selectedValue = $(this).val();
            // กำหนดค่าที่ถูกเลือกให้กับ select สำหรับตู้ภายนอก
            $("#employee_out").val(selectedValue).trigger('change.select2');
        });
        $("#employee_out").change(function(){
            // รับค่าที่ถูกเลือกจาก select สำหรับตู้บัดดี้
            var selectedValue = $(this).val();
            // กำหนดค่าที่ถูกเลือกให้กับ select สำหรับตู้ภายนอก
            $("#employee_buddy").val(selectedValue).trigger('change.select2');
        });
    </script>
</body>

</html>
