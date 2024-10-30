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
                    if (isset($_GET['id_selection'])){
                        $id_selection = $_GET['id_selection'];
                        $_SESSION['id_selection'] = $id_selection;
                    
                ?>
                    <!-- Page Heading -->
                    <div class="row h3 mb-3">
                        <?php
                        echo'
                        <div class="col ps-3 pe-3"><form action="auditfinish.php" method="post">
                        <input type="hidden" name="selection" id="id_selection" value='.$id_selection.'>

                        <button type="submit" class="btn btn-success btn-icon-split w-100">
                            <span class="icon text-white-50 w-25">
                                <i class="fas fa-check"></i>
                            </span>
                            <span class="text w-75">ยืนยันการตรวจสอบ</span>
                        </button>
                        </form></div>';
                        echo'<div class="col ps-3 pe-3"><form action="auditcheck.php" method="post">
                        <input type="hidden" name="id_selection"   id="id_selection"    value='.$id_selection.'>
                    
                        <button type="submit" class="btn btn-warning btn-icon-split w-100">
                            <span class="icon text-white-50 w-25">
                                <i class="fas fa-search"></i>
                            </span>
                            <span class="text w-75">ตรวจสอบ</span>
                        </button>
                        </form></div>';
                        echo'<div class="col ps-3 pe-3"><a href="javascript:history.back()"class="btn btn-info btn-icon-split w-100">
                                <span class="icon text-white-50 w-25">
                                    <i class="fas fa-arrow-right"></i>
                                </span>
                                <span class="text w-75">ย้อนกลับ</span>
                            </a>
                        </div>
                        ';
                        if( $conn ) {
                                $sql ="SELECT * FROM AuditData1 WHERE format_id = '$id_selection' ORDER BY idcard ASC";
                                $stmt = sqlsrv_query($conn, $sql );
                              
                              if ($stmt !== false) {
                        ?>
                        </div>
                    <!-- <h1 class="h3 mb-2 text-gray-800">รายชื่อพนักงานทั้งหมด</h1> -->

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="row">
                                <?php
                                echo'<div class="col"><form action="../PrintPDF/PrintPDF.php" method="get" target="_blank">
                                    <input type="hidden" name="id_selection" id="id_selection" value='.$id_selection.'>
                                    <input type="hidden" name="lo" id="lo" value="auditresult">
                                
                                    <button type="submit" class="btn btn-primary btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-download"></i>
                                        </span>
                                        <span class="text">    ปริ้น    </span>
                                    </button>
                                </a>
                                </form></div>';
                                ?>
                                <div class="col-auto">
                                    <a href="#" class="btn btn-info btn-icon-split" data-toggle="modal" data-target="#NoteModal">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-download"></i>
                                        </span>
                                        <span class="text">    ระบุหมายเหตุ    </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>รหัสพนักงาน</th>
                                            <th>รหัสตู้</th>
                                            <th>คำนำหน้า</th>
                                            <th>ชื่อ</th>
                                            <th>นามสกุล</th>
                                            <th>รหัสแผนก</th>
                                            <th>แผนก</th>
                                            <th>ไลน์ผลิต</th>
                                            <th colspan="3"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                        echo "<tr>";
                                        echo "<td class='align-middle'>" . $row['idcard'] ."</td>";
                                        echo "<td class='align-middle'>" . $row['lockernumber'] . "</td>";
                                        echo "<td class='align-middle'>" . $row['InitialT'] . "</td>";
                                        echo "<td class='align-middle'>" . $row['namethai'] . "</td>";
                                        echo "<td class='align-middle'>" . $row['surnamethai'] . "</td>";
                                        echo "<td class='align-middle'>" . $row['departmentno'] . "</td>";
                                        echo "<td class='align-middle'>" . $row['departmentname'] . "</td>";
                                        echo "<td class='align-middle'>" . $row['linename'] . "</td>";
                                        $sql2 ="SELECT COUNT(*)AS total FROM AuditData1 WHERE  ID = ? AND enddate IS NOT NULL ";
                                        $params2 = array($row['ID']);
                                        $stmt2 = sqlsrv_query($conn,$sql2,$params2 );
                                        $rows = sqlsrv_fetch_array($stmt2, SQLSRV_FETCH_ASSOC);  
                                        if($rows['total']<1){
                                            ?>
                                            <form method="post" action="auditdata.php " enctype="multipart/form-data">

                                            <td class='align-middle'><div class="form-check">
                                                <input class="form-check-input" type="radio" name="check" id="check" value="all">
                                                <label class="form-check-label" for="option1">
                                                    ปฏิบัติถูกต้องทั้งหมด
                                                </label>
                                            </div></td>
                    
                                            <td class='align-middle'><div class="form-check">
                                                <input class="form-check-input" type="radio" name="check" id="check" value="none" onclick="showPopup()">
                                                <label class="form-check-label" for="option2">
                                                    ปฏิบัติผิด
                                                </label>
                                            </div></td>
                                            <?php
                                            echo'
                                            <input type="hidden" name="idcard"      id="idcard"       value='.$row['idcard'].'>
                                            <input type="hidden" name="Lockernumber"id="Lockernumber" value='.$row['lockernumber'].'>
                                            <input type="hidden" name="ID"   id="ID"    value='.$row['ID'].'>
                    
                                            ';
                                            
                                            ?>
                                            <td>
                                            <button type="submit" value="Upload File" name="submit"class="btn btn-success btn-icon-split">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-check"></i>
                                                </span>
                                                <span class="text">ตกลง</span>
                                            </button>
                                            </td>
                                            <div id="popup-container">
                                            <!-- Content of the popup -->
                                            <!-- <form method="post" action="AuditData1.php"> -->
                                                <div>เลือกข้อที่ปฏิบัติผิด</div>
                                                <div class="form-check">
                                                    <input
                                                        class="form-check-input"
                                                        type="checkbox"
                                                        value="0"
                                                        name="check1"
                                                        id="check1"
                                                    />
                                                    <label class="form-check-label" for="">1. ไม่มีสัตว์พาหะอยู่ในล็อคเกอร์</label>
                                                </div>
                                                <div class="form-check">
                                                    <input
                                                        class="form-check-input"
                                                        type="checkbox"
                                                        value="0"
                                                        name="check2"
                                                        id="check2"
                                                    />
                                                    <label class="form-check-label" for="">2. ห้ามติดสติกเกอร์ใดๆ ที่ตู้ล็อคเกอร์</label>
                                                </div>
                                                <div class="form-check">
                                                    <input
                                                        class="form-check-input"
                                                        type="checkbox"
                                                        value="0"
                                                        name="check3"
                                                        id="check3"
                                                    />
                                                    <label class="form-check-label" for="">3. ห้ามนำจาน-ชามของบริษัทฯมาเก็บในตู้ล็อคเกอร์</label>
                                                </div>
                                                <div class="form-check">
                                                    <input
                                                        class="form-check-input"
                                                        type="checkbox"
                                                        value="0"
                                                        name="check4"
                                                        id="check4"
                                                    />
                                                    <label class="form-check-label" for="">4. ห้ามนำสิ่งของทุกชนิดมาเก็บไว้ในตู้ล็อคเกอร์ว่าง หรือตู้ล็อคเกอร์ของผู้อื่นโดยไม่ได้รับอนุญาต</label>
                                                </div>
                                                <div class="form-check">
                                                    <input
                                                        class="form-check-input"
                                                        type="checkbox"
                                                        value="0"
                                                        name="check5"
                                                        id="check5"
                                                    />
                                                    <label class="form-check-label" for="">5. ห้ามนำอาหารและเครื่องดื่มเข้ามาเก็บในตู้ล็อคเกอร์</label>
                                                </div>
                                                <div class="form-check">
                                                    <input
                                                        class="form-check-input"
                                                        type="checkbox"
                                                        value="0"
                                                        name="check6"
                                                        id="check6"
                                                    />
                                                    <label class="form-check-label" for="">6. ห้ามรับประทานอาหารและเครื่องดื่มภายในห้องแต่งตัว</label>
                                                </div>
                                                <div class="form-check">
                                                    <input
                                                        class="form-check-input"
                                                        type="checkbox"
                                                        value="0"
                                                        name="check7"
                                                        id="check7"
                                                    />
                                                    <label class="form-check-label" for="">7. ห้ามนำสินค้าทุกชนิดมาจำหน่ายในห้องแต่งตัว</label>
                                                </div>
                                                <div class="form-check">
                                                    <input
                                                        class="form-check-input"
                                                        type="checkbox"
                                                        value="0"
                                                        name="check8"
                                                        id="check8"
                                                    />
                                                    <label class="form-check-label" for="">8. ห้ามงัดและเคลื่อนย้ายตู้ล็อคเกอร์</label>
                                                </div>
                                                <div class="form-check">
                                                    <input
                                                        class="form-check-input"
                                                        type="checkbox"
                                                        value="0"
                                                        name="check9"
                                                        id="check9"
                                                    />
                                                    <label class="form-check-label" for="">9. สภาพตู้ล็อคเกอร์ไม่ชำรุด</label>
                                                </div>
                                                <div class="form-check">
                                                    <input
                                                        class="form-check-input"
                                                        type="checkbox"
                                                        value="0"
                                                        name="check10"
                                                        id="check10"
                                                    />
                                                    <label class="form-check-label" for="">อื่นๆ</label>
                                                    <!-- <input
                                                        class="form-check-input"
                                                        type="checkbox"
                                                        value="0"
                                                        name="check10"
                                                        id="check10"
                                                    /> -->
                                                    <!-- <input class="form-control form-control-sm" type="text" name="check10" placeholder="อื่นๆ ระบุ" class="w-75"> -->
                                                    <!-- <input type="file" name="fileToUpload" class="form-control form-control-sm border-0" id="fileToUpload"> -->
                                                    <div class="input-group mb-3">
                                                        <input type="file" name="fileToUpload" class="form-control form-control-sm border-0" id="fileToUpload">
                                                    </div>
                                                    <!-- <label class="form-check-label" for="">---</label> -->
                                                </div>
                                                    
                                                <!-- <p>ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง</p> -->
                                                <center>
                                                <button onclick="hidePopup()" type="button"class="btn btn-success btn-icon-split">
                                                    <span class="icon text-white-50">
                                                        <i class="fas fa-check"></i>
                                                    </span>
                                                    <span class="text">ยืนยัน</span>
                                                </button>
                                                </center>
                                                
                                            </div>
                                            </form>
                                        
                                        <?php
                                    }else{
                                        ?>
                                        <td class='align-middle' colspan="2">เช็คแล้ว</td>
                                        <td>
                                            <button type="button" onclick="showEdit()"class="btn btn-success btn-icon-split">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-pen"></i>
                                                </span>
                                                <span class="text">แก้ไข</span>
                                            </button>
                                        </td>
                                        <form method="post" action="auditdata.php">
                                        <div id="popup-container-edit">
                                            <!-- Content of the popup -->
                                            <!-- <form method="post" action="AuditData1.php"> -->
                                                <div>เลือกข้อที่ปฏิบัติผิด</div>
                                                <div class="form-check">
                                                <?php
                                                if($row['check1']== 0){
                                                    echo  '<input class="form-check-input"
                                                    type="checkbox"
                                                    value="0"
                                                    name="check1"
                                                    id="check1" checked />';
                                                }
                                                else{
                                                echo '
                                                    <input
                                                        class="form-check-input"
                                                        type="checkbox"
                                                        value="0"
                                                        name="check1"
                                                        id="check1"
                                                    />';
                                                }
                                                 ?>   
                                                    <label class="form-check-label" for="">1. ไม่มีสัตว์พาหะอยู่ในล็อคเกอร์</label>
                                                </div>
                                                <div class="form-check">
                                                <?php
                                                if($row['check2']== 0){
                                                    echo  '<input class="form-check-input"
                                                    type="checkbox"
                                                    value="0"
                                                    name="check2"
                                                    id="check2" checked />';
                                                }
                                                else{
                                                echo '
                                                    <input
                                                        class="form-check-input"
                                                        type="checkbox"
                                                        value="0"
                                                        name="check2"
                                                        id="check2"
                                                    />';
                                                }
                                                 ?>   
                                                    <label class="form-check-label" for="">2. ห้ามติดสติกเกอร์ใดๆ ที่ตู้ล็อคเกอร์</label>
                                                </div>
                                                <div class="form-check">
                                                <?php
                                                if($row['check3']== 0){
                                                    echo  '<input class="form-check-input"
                                                    type="checkbox"
                                                    value="0"
                                                    name="check3"
                                                    id="check3" checked />';
                                                }
                                                else{
                                                echo '
                                                    <input
                                                        class="form-check-input"
                                                        type="checkbox"
                                                        value="0"
                                                        name="check3"
                                                        id="check3"
                                                    />';
                                                }
                                                 ?>   
                                                    <label class="form-check-label" for="">3. ห้ามนำจาน-ชามของบริษัทฯมาเก็บในตู้ล็อคเกอร์</label>
                                                </div>
                                                <div class="form-check">
                                                <?php
                                                if($row['check4']== 0){
                                                    echo  '<input class="form-check-input"
                                                    type="checkbox"
                                                    value="0"
                                                    name="check4"
                                                    id="check4" checked />';
                                                }
                                                else{
                                                echo '
                                                    <input
                                                        class="form-check-input"
                                                        type="checkbox"
                                                        value="0"
                                                        name="check4"
                                                        id="check4"
                                                    />';
                                                }
                                                 ?>   
                                                    <label class="form-check-label" for="">4. ห้ามนำสิ่งของทุกชนิดมาเก็บไว้ในตู้ล็อคเกอร์ว่าง หรือตู้ล็อคเกอร์ของผู้อื่นโดยไม่ได้รับอนุญาต</label>
                                                </div>
                                                <div class="form-check">
                                                <?php
                                                if($row['check5']== 0){
                                                    echo  '<input class="form-check-input"
                                                    type="checkbox"
                                                    value="0"
                                                    name="check5"
                                                    id="check5" checked />';
                                                }
                                                else{
                                                echo '
                                                    <input
                                                        class="form-check-input"
                                                        type="checkbox"
                                                        value="0"
                                                        name="check5"
                                                        id="check5"
                                                    />';
                                                }
                                                 ?>   
                                                    <label class="form-check-label" for="">5. ห้ามนำอาหารและเครื่องดื่มเข้ามาเก็บในตู้ล็อคเกอร์</label>
                                                </div>
                                                <div class="form-check">
                                                <?php
                                                if($row['check6']== 0){
                                                    echo  '<input class="form-check-input"
                                                    type="checkbox"
                                                    value="0"
                                                    name="check6"
                                                    id="check6" checked />';
                                                }
                                                else{
                                                echo '
                                                    <input
                                                        class="form-check-input"
                                                        type="checkbox"
                                                        value="0"
                                                        name="check6"
                                                        id="check6"
                                                    />';
                                                }
                                                 ?>   
                                                    <label class="form-check-label" for="">6. ห้ามรับประทานอาหารและเครื่องดื่มภายในห้องแต่งตัว</label>
                                                </div>
                                                <div class="form-check">
                                                <?php
                                                if($row['check7']== 0){
                                                    echo  '<input class="form-check-input"
                                                    type="checkbox"
                                                    value="0"
                                                    name="check7"
                                                    id="check1" checked />';
                                                }
                                                else{
                                                echo '
                                                    <input
                                                        class="form-check-input"
                                                        type="checkbox"
                                                        value="0"
                                                        name="check7"
                                                        id="check7"
                                                    />';
                                                }
                                                 ?>   
                                                    <label class="form-check-label" for="">7. ห้ามนำสินค้าทุกชนิดมาจำหน่ายในห้องแต่งตัว</label>
                                                </div>
                                                <div class="form-check">
                                                <?php
                                                if($row['check8']== 0){
                                                    echo  '<input class="form-check-input"
                                                    type="checkbox"
                                                    value="0"
                                                    name="check8"
                                                    id="check8" checked />';
                                                }
                                                else{
                                                echo '
                                                    <input
                                                        class="form-check-input"
                                                        type="checkbox"
                                                        value="0"
                                                        name="check8"
                                                        id="check8"
                                                    />';
                                                }
                                                 ?>   
                                                    <label class="form-check-label" for="">8. ห้ามงัดและเคลื่อนย้ายตู้ล็อคเกอร์</label>
                                                </div>
                                                <div class="form-check">
                                                <?php
                                                if($row['check9']== 0){
                                                    echo  '<input class="form-check-input"
                                                    type="checkbox"
                                                    value="0"
                                                    name="check9"
                                                    id="check9" checked />';
                                                }
                                                else{
                                                echo '
                                                    <input
                                                        class="form-check-input"
                                                        type="checkbox"
                                                        value="0"
                                                        name="check9"
                                                        id="check9"
                                                    />';
                                                }
                                                ?>
                                                    <label class="form-check-label" for="">9. สภาพตู้ล็อคเกอร์ไม่ชำรุด</label>
                                                </div>
                                                <div class="form-check">
                                                    <input
                                                        class="form-check-input"
                                                        type="checkbox"
                                                        value="0"
                                                        name="check10"
                                                        id="check10"
                                                    />
                                                    <label class="form-check-label" for="">อื่นๆ</label>
                                                    <!-- <input
                                                        class="form-check-input"
                                                        type="checkbox"
                                                        value="0"
                                                        name="check10"
                                                        id="check10"
                                                    /> -->
                                                    <!-- <input class="form-control form-control-sm" type="text" name="check10" placeholder="อื่นๆ ระบุ" class="w-75"> -->
                                                    <!-- <input type="file" name="fileToUpload" class="form-control form-control-sm border-0" id="fileToUpload"> -->
                                                    <div class="input-group mb-3">
                                                        <input type="file" name="fileToUpload" class="form-control form-control-sm border-0" id="fileToUpload">
                                                    </div>
                                                    <!-- <label class="form-check-label" for="">---</label> -->
                                                </div>
                                            <!-- <p>ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง</p> -->
                                            
                                            <?php
                                            echo'
                                            <input type="hidden" name="idcard"      id="idcard"       value='.$row['idcard'].'>
                                            <input type="hidden" name="Lockernumber"id="Lockernumber" value='.$row['lockernumber'].'>
                                            <input type="hidden" name="ID"          id="ID"    value='.$row['ID'].'>
                                            ';
                                            ?>
                                            <center>
                                            <button type="submit" class="btn btn-success btn-icon-split">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-check"></i>
                                                </span>
                                                <span class="text">ยืนยัน</span>
                                            </button>
                                            </center>
                                        </div>
                                        </form>
                                        <?php
                                    }
                                }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <?php
                        } else {
                            echo "ไม่สามารถดึงข้อมูลได้: " . print_r(sqlsrv_errors(), true);
                        }
                
                          // ปิดการเชื่อมต่อ
                          sqlsrv_close($conn);
                      } else {
                          echo "การเชื่อมต่อไม่สำเร็จ";
                      }
                    }
                    else{
                        ?>
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col ps-3 pe-3">
                                    <a href="audittable.php">
                                    <button type="button" class=" w-100 mb-3 m-0 p-0 pe-2 ps-2 btn btn-outline-primary rounded-5">ยกเลิก</button>
                                    </a>
                                </div>
                                <div class="col ps-3 pe-3">
                                </div>
                            </div>
                            <div class="row">
                            <?php
                            $sql = "SELECT DISTINCT CONVERT(date, startdate) AS UniqueDates,typeaudit,build,intitail,selection FROM AuditData1
                            WHERE staudit = 'no' GROUP BY CONVERT(date,startdate),typeaudit,build,intitail,selection ";
                            $result = sqlsrv_query($conn, $sql);
                            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                                echo'<div class="col-2 border text-center">';
                                if($row['intitail']==='นาย'){
                                $intitail = 'ชาย';
                                }
                                elseif($row['intitail']==='นาง'){
                                    $intitail = 'หญิง';
                                }
                                if($row['build'] === '1'){
                                $buildname = 'A';
                                }
                                elseif($row['build'] === '2'){
                                $buildname = 'B';
                                }
                                elseif($row['build'] === '3'){
                                $buildname = 'C';
                                }
                                elseif($row['build'] === '4'){
                                $buildname = 'D';
                                }
                                elseif($row['build'] === '5'){
                                $buildname = 'E';
                                }
                                elseif($row['build'] === '6'){
                                $buildname = 'F';
                                }
                                if($row['typeaudit']==='buddy'){
                                $type = 'รองเท้าบัดดี้';
                                }
                                elseif($row['typeaudit']==='out'){
                                $type = 'รองเท้าใส่นอกอาคาร';
                                }
                                elseif($row['typeaudit']==='shirt'){
                                $type = 'ล็อคเกอร์เก็บของ';
                                }
                                echo "วันที่ : ".$row['UniqueDates']->format('Y-m-d')."<br>ตู้".$type."<br>อาคาร : ".$buildname."<br>เพศ : ".$intitail;
                                echo '<a href="auditShow.php?selectedDate='.$row['UniqueDates']->format('Y-m-d').'&build='.$row['build'].'&type='.$row['typeaudit'].'&selection='.$row['selection'].'&sex='.$row['intitail'].'">
                                <button type="button" class=" w-100 mb-3 m-0 p-0 pe-2 ps-2 btn btn-outline-primary rounded-5">ตรวจสอบ</button>
                                </a>';
                                echo'</div>';    
                            }
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

    <!-- Note Modal-->
    <div class="modal fade" id="NoteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ระบุหมายเหตุ</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="auditdata.php" method="post">
                    <div class="modal-body">
                        <?php
                        include '../database.php';
                        $sql = "SELECT format_comment FROM format_audit WHERE ID = '$id_selection'";
                        $stmt = sqlsrv_query($conn, $sql );
                        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
                        $text = $row['format_comment'];

                        ?>
                        <input type="hidden" name="ID" <?php echo 'value="'.$id_selection.'"' ?>>
                        <textarea class="form-control" aria-label="With textarea" class="form-control form-control-sm" 
                        type="text" name="comment" id="comment" maxlength="350"><?php echo $text ?></textarea>
                        <div class="row">
                            <div class="col"></div>
                            <div class="col-auto">สามารถใส่ข้อความได้มากสุด 350 คำ</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="submit">ยืนยัน</button>
                    </div>
                    <!-- data-dismiss="modal" -->
                </form>
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
    
    $cleanDate = date('Y', strtotime($selectedDate));
    if (!$conn) {
        die(print_r(sqlsrv_errors(), true));
    }

    // ทำการตรวจสอบว่ามีข้อมูลในเดือนนั้นหรือไม่{
    if($_SESSION['selection'] == 1){
        $sql = "SELECT COUNT(*) as count FROM AuditData1 WHERE MONTH(startdate) = ? AND build = ? AND selection = '1'AND YEAR(startdate) = ?";
    }
    else{
        $sql = "SELECT COUNT(*) as count FROM AuditData1 WHERE MONTH(startdate) = ? AND build = ? AND selection = '0.5' AND YEAR(startdate) = ?";

    }
    $params = array($month, $column,$cleanDate);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt) {
        $result = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        $count = $result['count'];
        sqlsrv_free_stmt($stmt);
        sqlsrv_close($conn);
        return $count > 0;
    } else {
        return false;
    }

}
function checkAllFinish($month, $column,$selectedDate) {
    // ทำการเชื่อมต่อกับฐานข้อมูล MSSQL
    include '../database.php';
    $cleanDate = date('Y', strtotime($selectedDate));
    if (!$conn) {
        die(print_r(sqlsrv_errors(), true));
    }

    // ทำการตรวจสอบว่ามีข้อมูลในเดือนนั้นหรือไม่{
    if($_SESSION['selection'] == 1){
        $sql = "SELECT COUNT(*) as count FROM AuditData1 WHERE MONTH(startdate) = ? AND build = ? AND selection = '1' AND staudit = 'no' AND YEAR(startdate) = ?";
    }
    else{
        $sql = "SELECT COUNT(*) as count FROM AuditData1 WHERE MONTH(startdate) = ? AND build = ? AND selection = '0.5' AND staudit = 'no' AND YEAR(startdate) = ?";

    }
    $params = array($month, $column,$cleanDate);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt) {
        $result = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        $count = $result['count'];
        sqlsrv_free_stmt($stmt);
        sqlsrv_close($conn);
        return $count > 0;
    } else {
        return false;
    }

}
?>

<script>
        function showEdit() {
            // Display the popup
            document.getElementById("popup-container-edit").style.display = "block";
        }

        function hideEdit() {
            // Hide the popup
            document.getElementById("popup-container-edit").style.display = "none";
        }
        function showPopup() {
            // Display the popup
            document.getElementById("popup-container").style.display = "block";
        }

        function hidePopup() {
            // Hide the popup
            document.getElementById("popup-container").style.display = "none";
        }

        <?php
        if (isset($_GET['message'])) {
            if ($_GET['message']=='unfinish') {
                ?>
                $("#UnfinishModal").modal('show');
                <?php
            }
        } 
        ?>
        
    </script>
