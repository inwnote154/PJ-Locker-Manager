<?php
include 'database.php';
if (isset($_GET['year'])) {
    $year=$_GET['year'];
}else{
    $year = date('Y');
}
// $sql = "SELECT COUNT(*) AS employees FROM employee ";
// $stmt = sqlsrv_query($conn, $sql);
// $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
// // echo " พนักงาน".$row['employees'];

// $sql = "SELECT COUNT(*) AS have_locker FROM employee WHERE idcard IN (SELECT EmployeeID FROM AccessLog WHERE StatusEm = 'active')";
// $stmt = sqlsrv_query($conn, $sql);
// $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
// // echo "มี".$row['have_locker'];

// $sql = "SELECT COUNT(*) AS have_not_locker FROM employee WHERE idcard NOT IN (SELECT EmployeeID FROM AccessLog WHERE StatusEm = 'active')";
// $stmt = sqlsrv_query($conn, $sql);
// $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
// // echo "ไม่มี ".$row['have_not_locker'];



$sql = "SELECT COUNT(*) AS all_audit FROM format_audit WHERE YEAR(createdate) = '$year' ";
$stmt = sqlsrv_query($conn, $sql);
$row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
// echo "<br> การตรวจสอบทั้งหมด ".$row['all_audit'];

$sql = "SELECT COUNT(*) AS complete FROM format_audit WHERE staudit = 'complete' AND YEAR(createdate) = '$year'  ";
$stmt = sqlsrv_query($conn, $sql);
$row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
// echo " สำเร็จ : ".$row['complete'];
$success = $row['complete'];

$sql = "SELECT COUNT(*) AS audit_ok FROM format_audit WHERE staudit = 'ok' AND YEAR(createdate) = '$year'";
$stmt = sqlsrv_query($conn, $sql);
$row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
// echo "<br> แอดมินตรวจแล้ว: ".$row['audit_ok'];
$check = $row['audit_ok'];

$sql = "SELECT COUNT(*) AS process FROM format_audit WHERE staudit = 'process'AND YEAR(createdate) = '$year' ";
$stmt = sqlsrv_query($conn, $sql);
$row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
// echo " กำลังตรวจ: ".$row['process'];
$waiting = $row['process'];

$quarter_process = array();
$quarter_admin_pk = array();
$quarter_complete = array();

for($i = 0;$i<4;$i++){
    $sql = "SELECT COUNT(*) AS process FROM format_audit WHERE staudit = 'process' AND DATEPART(QUARTER,createdate)= '$i' AND YEAR(createdate) = '$year'";
    $stmt = sqlsrv_query($conn, $sql);
    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    $quarter_process1[] = $row['process'];

    $sql = "SELECT COUNT(*) AS admin_ok FROM format_audit WHERE staudit = 'ok' AND DATEPART(QUARTER,createdate)= '$i'AND YEAR(createdate) = '$year' ";
    $stmt = sqlsrv_query($conn, $sql);
    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    $quarter_process2[] = $row['admin_ok'];

    $sql = "SELECT COUNT(*) AS complete FROM format_audit WHERE staudit = 'complete'AND DATEPART(QUARTER,createdate)= '$i' AND YEAR(createdate) = '$year'";
    $stmt = sqlsrv_query($conn, $sql);
    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    $quarter_process3[] = $row['complete'];
}
$json_quarter_process1 = json_encode($quarter_process1);
$json_quarter_process2 = json_encode($quarter_process2);
$json_quarter_process3 = json_encode($quarter_process3);
?>