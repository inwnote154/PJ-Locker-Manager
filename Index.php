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
                    <div class="row">
                        <div class="col-lg-3"></div>
                        <div class="col-lg-6">

                            <!-- Default Card Example -->
                            <div class="card mb-6 text-dark shadow">
                                <div class="card-header">
                                    ค้นหาข้อมูลพนักงาน
                                </div>
                                <div class="card-body">
                                    <center>
                                        <form action="detailemployee.php" method="post">
                                            <div class="mb-3">
                                                <label for="" class="form-label">กรอกรหัสพนักงานที่ต้องการจะค้นหา</label>
                                                <input type="text"class="form-control rounded-3 border" name="employee_id" id="employee_id" 
                                                aria-describedby="helpId" placeholder="XXXXXXX" style="width: 250px;" required>
                                            </div>
                                            <button type="submit" class="btn btn-info btn-icon-split">    
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-search"></i>
                                                </span>
                                                <span class="text">ค้นหาข้อมูล</span>
                                            </button>
                                        </form>
                                    </center>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3"></div>
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