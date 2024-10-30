<?php
// Connect to your MSSQL database
include '../database.php';

// Check connection
if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Fetch data based on selected department and employee
$department_id = $_POST['department_id'];
if(isset($_POST['employee_id'])){
    $employee_id = $_POST['employee_id'];
}
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
t.InitialT,
stemployee
FROM (SELECT DISTINCT idcard, namethai, surnamethai, departmentno, departmentname, linename,InitialT,stemployee FROM ALL_employee_locker) AS t
WHERE stemployee = 'ok'AND departmentno = ? 
";
if(!empty($employee_id)){
    $sql.= "AND idcard IN ('" . implode("','", $employee_id) . "') ";
}

$sql.= "ORDER BY idcard ASC";
$params = array($department_id);
$stmt = sqlsrv_query($conn, $sql, $params);

// Display data in table format
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}
?>
<div class="table-responsive">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>รหัสพนักงาน</th>
                <th>คำนำหน้า</th>
                <th>ชื่อ</th>
                <th>นามสกุล</th>
                <th>รหัสแผนก</th>
                <th>แผนก</th>
                <th>ไลน์ผลิต</th>
                <th>กลับบ้าน</th>
                <th>บัดดี้</th>
                <th>ล็อคเกอร์</th>
            </tr>
        </thead>
        <tbody>

<?php
// วนลูปแสดงผลลัพธ์
$data = array();
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {


    echo "<tr>";
    echo "<td>{$row['idcard']}</td>";
    echo "<td>{$row['InitialT']}</td>";
    echo "<td>{$row['namethai']}</td>";
    echo "<td>{$row['surnamethai']}</td>";
    echo "<td>{$row['departmentno']}</td>";
    echo "<td>{$row['departmentname']}</td>";
    echo "<td>{$row['linename']}</td>";
    echo "<td>{$row['buddys']}</td>";
    echo "<td>{$row['outs']}</td>";
    echo "<td>{$row['shirts']}</td>";

       
    
    echo "</tr>";
}

?>
        </tbody>
    </table>
</div>
<?php
// Close connection
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