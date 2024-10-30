<?php
include '../database.php';

if(isset($_POST['option1'])){
    $type =$_POST['option1'];
}
if(isset($_POST['option2'])){
    $build = $_POST['option2'];
}
if(isset($_POST['option3'])){
    $sex = $_POST['option3'];
}

$sql = "SELECT * FROM Data_locker WHERE LockerNumber IS NOT NULL ";
if(!empty($_POST['option1'])){
    $sql.= "AND TypeLocker = '$type'";
}
if(!empty($_POST['option2'])){
    $sql .= "AND LockerNumber LIKE '$build%'";
}
if(!empty($_POST['option3'])){
    $sql .= "AND InitialT LIKE '$sex%'";
}

$sql .= " ORDER BY LockerNumber ASC";

$stmt = sqlsrv_query($conn, $sql);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}
echo '
<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
';
echo "<thead><tr>
    <th>รหัสตู้</th>
    <th>รหัสพนักงาน</th>
    <th>คำนำหน้า</th>
    <th>ชื่อ</th>
    <th>นามสกุล</th>
    <th>แผนก</th>
    <th>ไลน์ผลิต</th>
</tr></thead>
<tbody>";

// วนลูปแสดงผลลัพธ์
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {


    echo "<tr>";
    echo "<td>{$row['LockerNumber']}</td>";
    echo "<td>{$row['idcard']}</td>";
    echo "<td>{$row['InitialT']}</td>";
    echo "<td>{$row['namethai']}</td>";
    echo "<td>{$row['surnamethai']}</td>";
    echo "<td>{$row['departmentname']}</td>";
    echo "<td>{$row['linename']}</td>";

       
    
    echo "</tr>";
}

// ปิดตาราง HTML
echo "</tbody></table>";

// ปิดการเชื่อมต่อ
sqlsrv_close($conn);

?>
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
    
</script>