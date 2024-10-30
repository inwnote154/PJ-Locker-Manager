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
    <div id="wrapper">
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-3"></div>
                        <div class="col-lg-6">

                            <!-- Default Card Example -->
                            <div class="card mb-6 text-dark shadow h-25">
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
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </form>
                                    </center>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3"></div>
                    </div>
                
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
            $("#AddModal").modal('show');
            <?php
        } elseif (isset($_GET['message1'])) {
            ?>
            $("#AddfailedModal").modal('show');
            <?php
        }
        ?>
        $('.select2, .select3').select2();
    </script>
    
</body>

</html>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="main.css">
</head>
<body class="p-5">
    <div id="popup-container-1">
        <!-- Content of the popup -->
        <p>ไม่มีข้อมูลพนักงานนี้ในระบบ</p>
        <center><button onclick="hidePopup_1()" type="button" class="m-0 p-0 btn btn-outline-success set1 rounded-5">ยืนยัน</button></center>
    </div>
    <script>
        <?php
        if (isset($_GET['message1'])) {
            $showPopup = "1";
        }
        if (isset($showPopup)) {
            echo "showPopup('$showPopup');";
        }
        ?>
        function showPopup(type) {
        console.log(type);

            // ตรวจสอบ type แล้วแสดง Popup ตามที่ต้องการ
            if (type === '1') {
                showPopup_1();
            } 
        }
        
        function showPopup_1() {
            // Display the popup
            document.getElementById("popup-container-1").style.display = "block";
        }

        function hidePopup_1() {
            // Hide the popup
            document.getElementById("popup-container-1").style.display = "none";
        }
    </script>
    <div class="box1 border p-5 rounded-5">
        <center>
            <form action="detailemployee.php" method="post">
                <div class="mb-3">
                    <label for="" class="form-label">กรอกรหัสพนักงานที่ต้องการจะค้นหา</label>
                    <input type="text"class="form-control rounded-3 border" name="employee_id" id="employee_id" 
                    aria-describedby="helpId" placeholder="XXXXXXX" style="width: 250px;" required>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </center>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>