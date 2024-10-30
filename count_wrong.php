<?php
// ตั้งค่าการเชื่อมต่อฐานข้อมูล MSSQL
include 'database.php';
if (isset($_GET['year'])) {
    $year=$_GET['year'];
}else{
    $year = date('Y');
}

if ($conn === false) {
    echo "ไม่สามารถเชื่อมต่อกับฐานข้อมูลได้.<br />";
    die(print_r(sqlsrv_errors(), true));
}
$data = array();
for($i  = 0 ;$i<=12;$i++){
// สร้าง SQL query เพื่อนับข้อมูลที่มีค่าเป็น 0
$sql = "SELECT COUNT(*) AS count FROM AuditData1 WHERE (check1 = 0 OR check2 = 0 OR check3 = 0
OR check4 = 0 OR check5 = 0 OR check6 = 0 OR check7 = 0 OR check8 = 0 OR check9 = 0 OR other = '0') 
AND MONTH(createdate) = $i AND YEAR(createdate) = '$year'";

// ประมวลผล query
$stmt = sqlsrv_query($conn, $sql);

if ($stmt === false) {
    echo "ไม่สามารถดำเนินการ query.<br />";
    die(print_r(sqlsrv_errors(), true));
}

// ดึงผลลัพธ์
$row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

// แสดงผลลัพธ์
$data[] =  $row['count'];
}
$json_data = json_encode($data);
// echo $data[5];
// ปิดการเชื่อมต่อ
sqlsrv_close($conn);
?>