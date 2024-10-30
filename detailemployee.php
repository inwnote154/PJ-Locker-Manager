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
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper bg-white">
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-primary topbar mb-4 static-top shadow">
                    
                    <a class="navbar-brand d-flex align-items-center justify-content-center text-white" href="Index.php">
                        <div class="sidebar-brand-icon rotate-n-15">
                            <i class="fas fa-laugh-wink"></i>
                        </div>
                        <div class="sidebar-brand-text mx-3">Smart Locker</sup></div>
                    </a>
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link" href="login.php" aria-haspopup="true" aria-expanded="false">
                                <div class="sidebar-brand-text mx-3 text-white">Login</sup></div>
                            </a>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <div class="container-fluid">
                <?php
                include 'database.php';

                $employeeId = $_POST['employee_id'];
                ?>
                    <div class="row">
                        <div class="col-lg-2"></div>
                        <div class="col-lg-8">

                            <!-- Default Card Example -->
                            <div class="card mb-6 text-dark shadow">
                                <div class="card-header">
                                    ข้อมูลพนักงานรหัส <?php echo $employeeId ?>
                                </div>
                                <div class="card-body">
                                    <?php
                                    if( $conn ) {
                                        $sql = "SELECT 
                                        t.idcard,
                                        STUFF((SELECT ', ' + LockerNumber FROM ALL_employee_locker WHERE TypeLocker = 'buddy' AND idcard = t.idcard FOR XML PATH('')), 1, 2, '') AS buddys,
                                        STUFF((SELECT ', ' + LockerNumber FROM ALL_employee_locker WHERE TypeLocker = 'out' AND idcard = t.idcard FOR XML PATH('')), 1, 2, '') AS outs,
                                        STUFF((SELECT ', ' + LockerNumber FROM ALL_employee_locker WHERE TypeLocker = 'shirt' AND idcard = t.idcard FOR XML PATH('')), 1, 2, '') AS shirts, 
                                        t.namethai,
                                        t.surnamethai,
                                        t.departmentno,
                                        t.departmentname,
                                        t.linename,
                                        InitialT,
                                        t.startdate,
                                        stemployee
                                        FROM (SELECT DISTINCT idcard, namethai, surnamethai, departmentno, departmentname, linename,InitialT,startdate,stemployee FROM ALL_employee_locker) AS t
                                        WHERE stemployee ='ok' AND idcard = ?";
                                        $params = array($employeeId);
                                        $stmt = sqlsrv_query($conn, $sql,$params);
                                        $stmt2 = sqlsrv_query($conn, $sql,$params);
                                        if($rows = sqlsrv_fetch_array($stmt2, SQLSRV_FETCH_ASSOC)){
                                            
                                        if ($stmt !== false) {
                                            echo "";
                                            echo '<table class="">';
                                            $headerPrinted = false;
                                            echo "<table class='container-fluid ps-4 pe-4'>";
                                            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                                echo "<tr>
                                                <th class='p-2 pb-4'>คำนำหน้า</th>
                                                <td class='p-2 pb-4'>" . $row['InitialT'] . "</td>";
                                                echo "
                                                <th class='p-2 pb-4'>ชื่อ</th>
                                                <td class='p-2 pb-4'>" . $row['namethai'] . "</td>";
                                                echo "
                                                <th class='p-2 pb-4'>นามสกุล</th>
                                                <td class='p-2 pb-4'>" . $row['surnamethai'] . "</td></tr>";
                                                echo "<tr>
                                                <th class='p-2 pb-4'>รหัสแผนก</th>
                                                <td class='p-2 pb-4'>" . $row['departmentno'] . "</td>";
                                                echo "
                                                <th class='p-2 pb-4'>แผนก</th>
                                                <td class='p-2 pb-4'>" . $row['departmentname'] . "</td>";
                                                echo "
                                                <th class='p-2 pb-4'>ไลน์ผลิต</th>
                                                <td class='p-2 pb-4'>" . $row['linename'] . "</td>";
                    
                                                echo "</tr><tr>";
                                                // $sql = "SELECT * FROM Accesslog
                                                // WHERE EmployeeID = ?  AND StatusEm = 'active' AND TypeLocker = 'buddy'";
                                                // $params = array($employeeId);
                                                // $stmt = sqlsrv_query($conn, $sql,$params);
                                                // $stmt2 = sqlsrv_query($conn, $sql,$params);   
                                                echo"<th class='p-2 pb-4'>รหัสที่เก็บรองเท้าบัดดี้</th>";
                                                if($rows['buddys']){
                    
                                                
                                                    echo "
                                                    <td class='p-2 pb-4'>".$row['buddys'] . "</td>";
                                                }
                                                else{
                                                    echo "<td class='p-2 pb-4'>-</td>";
                                                }
                    
                                                
                                                echo"<th class='p-2 pb-4'>รหัสที่เก็บรองเท้าภายนอก</th>";
                                                if($rows['outs']){
                                                    echo "
                                                    <td class='p-2 pb-4'>".$row['outs'] . "</td>";
                                            
                                                }
                                                else{
                                                    echo "<td class='p-2 pb-4'>-</td>";
                                                }
                    
                                            
                                                echo"<th class='p-2 pb-4'>รหัสตู้เก็บของ</th>";
                                                if($rows['shirts']){
                    
                                                
                                                    echo "
                                                    <td class='p-2 pb-4'>".$row['shirts'] . "</td>";
                                        
                                                }
                                                else{
                                                    echo "<td class='p-2 pb-4'>-</td>";
                                                }
                                            }
                                            
                                            echo "</tr></table>";
                                            echo '<center>
                                            <a href="Index.php"class="btn btn-danger btn-icon-split">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-arrow-right"></i>
                                                </span>
                                                <span class="text">ย้อนกลับ</span>
                                            </a>
                                            </center>';
                                        } else {
                                            // echo "ไม่สามารถดึงข้อมูลได้: " . print_r(sqlsrv_errors(), true);
                                            echo '<script>console.log("1");</script>';
                                        }
                                        }
                                        else{
                                            header('Location:Index.php?message=1');
                                        }
                                        // ปิดการเชื่อมต่อ
                                        sqlsrv_close($conn);
                                    } else {
                                        echo "การเชื่อมต่อไม่สำเร็จ";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2"></div>
                    </div>
                
                </div>
            </div>
            
            
            <!-- Footer -->
            <!-- <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2020</span>
                    </div>
                </div>
            </footer> -->
            <!-- End of Footer -->
        </div>
    </div>

    <!-- None Modal-->
    <div class="modal fade" id="NoneModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ไม่มีข้อมูลพนักงานนี้ในระบบ</h5>
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
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>


    <script>
        <?php
        if (isset($_GET['message'])) {
            ?>
            $("#NoneModal").modal('show');
            <?php
        }
        ?>
        $('.select2, .select3').select2();
    </script>

</body>
</html>
