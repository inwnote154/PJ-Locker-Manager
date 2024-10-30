<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">
<?php 
    session_start();
    if(empty($_SESSION['admin'])){
        header("Location:../login.php");
    }
    $admin = $_SESSION['admin'];
    include 'database.php';
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

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Smart Locker</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="dashboard.php">
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
                        <a class="collapse-item" href="Emp/showEmployee.php">พนักงานทั้งหมด</a>
                        <a class="collapse-item" href="Emp/admin_locker_new_employee.php">จัดการพนักงาน</a>
                        <a class="collapse-item" href="Emp/adminAddhome.php">เพิ่มพนักงาน</a>
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
                        <a class="collapse-item" href="Out/lockerout.php">ที่เก็บรองเท้าภายนอก</a>
                        <a class="collapse-item" href="Buddy/lockerbuddy.php">ที่เก็บรองเท้าบัดดี้</a>
                        <a class="collapse-item" href="Shirt/lockershirt.php">ล็อคเกอร์เก็บของ</a>
                        <a class="collapse-item" href="Log/showlog.php">ประวัติการทำงาน</a>
                        <a class="collapse-item" href="Log/showbreaklog.php">ประวัติการแจ้งเสีย</a>
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
                        <a class="collapse-item" href="Audit/ChooseAudit.php?selection=0.5">ครึ่ง</a>
                        <a class="collapse-item" href="Audit/ChooseAudit.php?selection=1">เต็ม</a>
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
                        <a class="collapse-item" href="AllReport/MainReport.php">ตามแผนกพนักงาน</a>
                        <a class="collapse-item" href="AllReport/date_select.php">รายงานการตรวจสอบ</a>
                        <a class="collapse-item" href="AllReport/locker_filter.php">ตามล็อคเกอร์</a>
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
                                <a class="dropdown-item" href="signature_php/sign_master.php">
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
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                        <div class="dropdown no-arrow">
                            <a class="dropdown-toggle text-decoration-none text-gray-800" href="#" role="button" id="dropdownMenuLink"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                เลือกปีที่แสดง <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                aria-labelledby="dropdownMenuLink">
                                <div class="dropdown-header">Dropdown Header:</div>
                                <?php
                                $year = date('Y');
                                for($i=0;$i<5;$i++){
                                    echo'<a class="dropdown-item" href="?year='.$year.'"> ปี '.$year.'</a>';
                                    $year--;
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php
                        include 'dashboard_test.php';
                        include 'showlocker.php';
                        include 'count_wrong.php';
                        // $year = date('Y');
                    ?>
                    <!-- Content Row -->
                    <div class="row">

                        <!-- Bar Chart -->
                        <div class="col-xl-8 col-lg-5">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">การตรวจสอบรายไตรมาส ปี <?php echo$year ?></h6>
                                </div>
                                <div class="card-body">
                                    <div class="chart-bar">
                                        <canvas id="myBarChart1"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pie Chart -->
                        <div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">จำนวนการตรวจสอบทั้งหมดในปี <?php echo$year ?></h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-pie pt-4 pb-2">
                                        <canvas id="myPieChart1"></canvas>
                                    </div>
                                    <div class="mt-4 text-center small">
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-warning"></i> กำลังตรวจ
                                        </span>
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-success"></i> ตรวจแล้ว
                                        </span>
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-primary"></i> อนุมัติ
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                จำนวนการตรวจสอบทั้งหมด</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <?php echo $waiting+$success+$check; ?> รายการ
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                จำนวนรายการที่กำลังดำเนินการตรวจสอบ</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php echo $waiting; ?> รายการ
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                จำนวนรายการที่ทำการตรวจเสร็จแล้ว</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php echo $check; ?> รายการ
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                จำนวนรายการที่ผ่านการอนุมัติแล้ว</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php echo $success; ?> รายการ
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->

                    <div class="row">

                        <!-- Area Chart -->
                        <div class="col">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">จำนวนผู้ที่ปฏิบัติไม่ถูกต้อง รายเดือน ในปี <?php echo$year ?></h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-area">
                                        <canvas id="myAreaChart1"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Content Column -->
                        <div class="col">

                            <!-- Project Card Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">จำนวนตู้ล็อคเกอร์รองเท้าบัดดี้ที่มีการใช้งาน</h6>
                                </div>
                                <div class="card-body">
                                    <h4 class="small font-weight-bold">A<span
                                            class="float-right"><?php echo $buddy-$buddy_a.'/'.$buddy ?></span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar bg-danger" role="progressbar" <?php echo 'style="width: '.$p_buddy_a.'%"' ?> 
                                            <?php echo'aria-valuenow="'.$p_buddy_a.'"' ?> aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <h4 class="small font-weight-bold">B<span
                                            class="float-right"><?php echo $buddy2-$buddy_b.'/'.$buddy2 ?></span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar bg-warning" role="progressbar" <?php echo 'style="width: '.$p_buddy_b.'%"' ?> 
                                            <?php echo'aria-valuenow="'.$p_buddy_b.'"' ?> aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <h4 class="small font-weight-bold">ชำรุด<span
                                            class="float-right"><?php echo $buddy_break ?></span></h4>
                                </div>
                            </div>
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">จำนวนตู้ล็อคเกอร์รองเท้าภายนอกที่มีการใช้งาน</h6>
                                </div>
                                <div class="card-body">
                                    <h4 class="small font-weight-bold">A<span
                                            class="float-right"><?php echo $out-$out_a.'/'.$out ?></span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar bg-primary" role="progressbar" <?php echo 'style="width: '.$p_out_a.'%"' ?> 
                                            <?php echo'aria-valuenow="'.$p_out_a.'"' ?> aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <h4 class="small font-weight-bold">B<span
                                            class="float-right"><?php echo $out2-$out_b.'/'.$out2 ?></span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar bg-success" role="progressbar" <?php echo 'style="width: '.$p_out_b.'%"' ?> 
                                            <?php echo'aria-valuenow="'.$p_out_b.'"' ?> aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <h4 class="small font-weight-bold">ชำรุด<span
                                            class="float-right"><?php echo $out_break ?></span></h4>
                                </div>
                            </div>
                            <!-- <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">shirt</h6>
                                </div>
                                <div class="card-body">
                                    <h4 class="small font-weight-bold">A<span
                                            class="float-right"><?php echo $locker_a.'/'.$locker ?></span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar bg-primary" role="progressbar" <?php echo 'style="width: '.$p_locker_a.'%"' ?> 
                                            <?php echo'aria-valuenow="'.$p_locker_a.'"' ?> aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <h4 class="small font-weight-bold">B<span
                                            class="float-right"><?php echo $locker_b.'/'.$locker2 ?></span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar bg-success" role="progressbar" <?php echo 'style="width: '.$p_locker_b.'%"' ?> 
                                            <?php echo'aria-valuenow="'.$p_locker_b.'"' ?> aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <h4 class="small font-weight-bold">D<span
                                            class="float-right"><?php echo $locker_d.'/'.$locker4 ?></span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar bg-info" role="progressbar" <?php echo 'style="width: '.$p_locker_d.'%"' ?> 
                                            <?php echo'aria-valuenow="'.$p_locker_d.'"' ?> aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <h4 class="small font-weight-bold">E<span
                                            class="float-right"><?php echo $locker_e.'/'.$locker5 ?></span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar bg-warning" role="progressbar" <?php echo 'style="width: '.$p_locker_e.'%"' ?> 
                                            <?php echo'aria-valuenow="'.$p_locker_e.'"' ?> aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <h4 class="small font-weight-bold">F<span
                                            class="float-right"><?php echo $locker_f.'/'.$locker6 ?></span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar bg-danger" role="progressbar" <?php echo 'style="width: '.$p_locker_f.'%"' ?> 
                                            <?php echo'aria-valuenow="'.$p_locker_f.'"' ?> aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <h4 class="small font-weight-bold">ชำรุด<span
                                            class="float-right"><?php echo $locker_break ?></span></h4>
                                </div>
                            </div> -->

                        </div>
                        <div class="col">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">จำนวนตู้ล็อคเกอร์ห้องแต่งตัวพนักงานที่มีการใช้งาน</h6>
                                </div>
                                <div class="card-body">
                                    <h4 class="small font-weight-bold">A<span
                                            class="float-right"><?php echo $locker-$locker_a.'/'.$locker ?></span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar bg-primary" role="progressbar" <?php echo 'style="width: '.$p_locker_a.'%"' ?> 
                                            <?php echo'aria-valuenow="'.$p_locker_a.'"' ?> aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <h4 class="small font-weight-bold">B<span
                                            class="float-right"><?php echo $locker2-$locker_b.'/'.$locker2 ?></span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar bg-success" role="progressbar" <?php echo 'style="width: '.$p_locker_b.'%"' ?> 
                                            <?php echo'aria-valuenow="'.$p_locker_b.'"' ?> aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <h4 class="small font-weight-bold">D<span
                                            class="float-right"><?php echo $locker4-$locker_d.'/'.$locker4 ?></span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar bg-info" role="progressbar" <?php echo 'style="width: '.$p_locker_d.'%"' ?> 
                                            <?php echo'aria-valuenow="'.$p_locker_d.'"' ?> aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <h4 class="small font-weight-bold">E<span
                                            class="float-right"><?php echo $locker5-$locker_e.'/'.$locker5 ?></span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar bg-warning" role="progressbar" <?php echo 'style="width: '.$p_locker_e.'%"' ?> 
                                            <?php echo'aria-valuenow="'.$p_locker_e.'"' ?> aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <h4 class="small font-weight-bold">F<span
                                            class="float-right"><?php echo $locker6-$locker_f.'/'.$locker6 ?></span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar bg-danger" role="progressbar" <?php echo 'style="width: '.$p_locker_f.'%"' ?> 
                                            <?php echo'aria-valuenow="'.$p_locker_f.'"' ?> aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <h4 class="small font-weight-bold">ชำรุด<span
                                            class="float-right"><?php echo $locker_break ?></span></h4>
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
                        <span>Copyright &copy; Your Website 2021</span>
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
                    <a class="btn btn-primary" href="login.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>
    <script src="js/demo/chart-bar-demo.js"></script>

    <script>
        // Set new default font family and font color to mimic Bootstrap's default styling
        Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
        Chart.defaults.global.defaultFontColor = '#858796';

        // Pie Chart Example
        var ctx = document.getElementById("myPieChart1");
        var myPieChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ["กำลังตรวจ", "ตรวจแล้ว", "อนุมัติ"],
            datasets: [{
                <?php
                    
                    echo'data: ['.$waiting.', '.$check.', '.$success.'],';
                    
                ?>
            // data: [55, 30, 15],
            backgroundColor: ['#f6c23e', '#1cc88a', '#4e73df'],
            // hoverBackgroundColor: ['#2e59d9', '#2c9faf', '#17a673'],
            hoverBorderColor: "rgba(234, 236, 244, 1)",
            }],
        },
        options: {
            maintainAspectRatio: false,
            tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            caretPadding: 10,
            },
            legend: {
            display: false
            },
            cutoutPercentage: 70,
        },
        });

        // Set new default font family and font color to mimic Bootstrap's default styling
        Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
        Chart.defaults.global.defaultFontColor = '#858796';

        function number_format(number, decimals, dec_point, thousands_sep) {
        // *     example: number_format(1234.56, 2, ',', ' ');
        // *     return: '1 234,56'
        number = (number + '').replace(',', '').replace(' ', '');
        var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            s = '',
            toFixedFix = function(n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
            };
        // Fix for IE parseFloat(0.55).toFixed(0) = 0;
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || '').length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1).join('0');
        }
        return s.join(dec);
        }

        // Area Chart Example
        var ctx = document.getElementById("myAreaChart1");
        var myLineChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            datasets: [{
            label: "People",
            lineTension: 0.3,
            backgroundColor: "rgba(78, 115, 223, 0.05)",
            borderColor: "rgba(78, 115, 223, 1)",
            pointRadius: 3,
            pointBackgroundColor: "rgba(78, 115, 223, 1)",
            pointBorderColor: "rgba(78, 115, 223, 1)",
            pointHoverRadius: 3,
            pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
            pointHoverBorderColor: "rgba(78, 115, 223, 1)",
            pointHitRadius: 10,
            pointBorderWidth: 2,
            <?php
            echo 'data: ';
            echo ($json_data);
            echo',';
            ?>
            // data: [0, 10000, 5000, 15000, 10000, 20000, 15000, 25000, 20000, 30000, 25000, 40000],
            }],
        },
        options: {
            maintainAspectRatio: false,
            layout: {
            padding: {
                left: 10,
                right: 25,
                top: 25,
                bottom: 0
            }
            },
            scales: {
            xAxes: [{
                time: {
                unit: 'date'
                },
                gridLines: {
                display: false,
                drawBorder: false
                },
                ticks: {
                maxTicksLimit: 0
                }
            }],
            yAxes: [{
                ticks: {
                maxTicksLimit: 5,
                padding: 10,
                // Include a dollar sign in the ticks
                callback: function(value, index, values) {
                    return number_format(value);
                }
                },
                gridLines: {
                color: "rgb(234, 236, 244)",
                zeroLineColor: "rgb(234, 236, 244)",
                drawBorder: false,
                borderDash: [2],
                zeroLineBorderDash: [2]
                }
            }],
            },
            legend: {
            display: false
            },
            tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            titleMarginBottom: 10,
            titleFontColor: '#6e707e',
            titleFontSize: 14,
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            intersect: false,
            mode: 'index',
            caretPadding: 10,
            callbacks: {
                label: function(tooltipItem, chart) {
                var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                return datasetLabel + " " + number_format(tooltipItem.yLabel);
                }
            }
            }
        }
        });

        // Set new default font family and font color to mimic Bootstrap's default styling
        Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
        Chart.defaults.global.defaultFontColor = '#858796';

        function number_format1(number, decimals, dec_point, thousands_sep) {
        // *     example: number_format(1234.56, 2, ',', ' ');
        // *     return: '1 234,56'
        number = (number + '').replace(',', '').replace(' ', '');
        var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            s = '',
            toFixedFix = function(n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
            };
        // Fix for IE parseFloat(0.55).toFixed(0) = 0;
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || '').length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1).join('0');
        }
        return s.join(dec);
        }

        // Bar Chart Example
        var ctx = document.getElementById("myBarChart1");
        var myBarChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ["ไตรมาสที่ 1", "ไตรมาสที่ 2", "ไตรมาสที่ 3", "ไตรมาสที่ 4"],
            datasets: [{
            label: "กำลังตรวจ",
            backgroundColor: "#f6c23e",
            // hoverBackgroundColor: "#2e59d9",
            borderColor: "#4e73df",
            data:<?php echo ($json_quarter_process1); ?>,
            },{
            label: "ตรวจแล้ว",
            backgroundColor: "#1cc88a",
            // hoverBackgroundColor: "#2e59d9",
            borderColor: "#4e73df",
            data: <?php echo ($json_quarter_process2); ?>,
            },{
            label: "อนุมัติ",
            backgroundColor: "#4e73df",
            // hoverBackgroundColor: "#2e59d9",
            borderColor: "#4e73df",
            data: <?php echo ($json_quarter_process3); ?>,
            }],
        },
        options: {
            maintainAspectRatio: false,
            layout: {
            padding: {
                left: 10,
                right: 25,
                top: 25,
                bottom: 0
            }
            },
            scales: {
            xAxes: [{
                time: {
                unit: 'month'
                },
                gridLines: {
                display: false,
                drawBorder: false
                },
                ticks: {
                maxTicksLimit: 6
                },
                maxBarThickness: 75,
            }],
            yAxes: [{
                ticks: {
                min: 0,
                // max: 15000,
                maxTicksLimit: 5,
                padding: 10,
                // Include a dollar sign in the ticks
                callback: function(value, index, values) {
                    return number_format1(value);
                }
                },
                gridLines: {
                color: "rgb(234, 236, 244)",
                zeroLineColor: "rgb(234, 236, 244)",
                drawBorder: false,
                borderDash: [2],
                zeroLineBorderDash: [2]
                }
            }],
            },
            legend: {
            display: false
            },
            tooltips: {
            titleMarginBottom: 10,
            titleFontColor: '#6e707e',
            titleFontSize: 14,
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            caretPadding: 10,
            callbacks: {
                label: function(tooltipItem, chart) {
                var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                return datasetLabel + ': ' + number_format1(tooltipItem.yLabel);
                }
            }
            },
        }
        });

    </script>
</body>

</html>