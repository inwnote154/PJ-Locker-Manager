<?php
include '../database.php';
$serverName = "192.168.16.16"; // ชื่อเซิร์ฟเวอร์ของคุณ
$connectionOptions = array(
    "Database" => "EuroTraining", // ชื่อฐานข้อมูล
    "Uid" => "sa", // ชื่อผู้ใช้ฐานข้อมูล
    "PWD" => "Eur@Admin", // รหัสผ่านฐานข้อมูล
    "CharacterSet" => "UTF-8"
);

// เชื่อมต่อกับฐานข้อมูล MSSQL
$conn2 = sqlsrv_connect($serverName, $connectionOptions);
if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}

if ($conn2 === false) {
    die(print_r(sqlsrv_errors(), true));
}
$sql = "SELECT le.idcard, le.stemployee, e.stemployee as employee_stemployee
        FROM officecenter.dbo.locker_employee le
        INNER JOIN EuroTraining.dbo.employee e ON le.idcard = e.idcard AND le.namethai = e.namethai
        WHERE le.stemployee = 'ok'";

$query = sqlsrv_query($conn, $sql);

if ($query === false) {
    die(print_r(sqlsrv_errors(), true));
}

while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
    if ($row['stemployee'] !== $row['employee_stemployee']) {
        echo "update" . $row['idcard'] . "<br>";
        echo $row['stemployee'] . "--> " . $row['employee_stemployee'] . "<br>";

        // อัปเดตข้อมูลในตาราง locker_employee
        $updateSql = "UPDATE officecenter.dbo.locker_employee SET stemployee = ? WHERE idcard = ?";
        $params = array($row['employee_stemployee'], $row['idcard']);
        $updateQuery = sqlsrv_query($conn, $updateSql, $params);

        // เพิ่มข้อมูลในตาราง quit_locker_employee
        $insertSql = "INSERT INTO officecenter.dbo.quit_locker_employee (idcard, stquit, date_update) VALUES (?, 'no', GETDATE())";
        $params = array($row['idcard']);
        $insertQuery = sqlsrv_query($conn, $insertSql, $params);
    }
}
$sql = "UPDATE officecenter.dbo.locker_employee
SET InitialT = e.InitialT,
    namethai = e.namethai,
    surnamethai = e.surnamethai,
    nameeng = e.nameeng,
    surnameeng = e.surnameeng,
    departmentid = e.departmentid,
    lineid = e.lineid,
    startdate = e.startdate,
    passdate = e.passdate,
    enddate = e.enddate,
    stemployee = e.stemployee,
    newemployee = e.newemployee
FROM officecenter.dbo.locker_employee le
INNER JOIN EuroTraining.dbo.employee e ON le.idcard = e.idcard";
$query5 = sqlsrv_query($conn, $sql);

$sql = "INSERT INTO officecenter.dbo.new_locker_employee (idcard, stnewem, date_update) SELECT idcard, 'no', GETDATE() FROM EuroTraining.dbo.employee 
        WHERE idcard NOT IN (SELECT idcard FROM officecenter.dbo.locker_employee) AND stemployee = 'ok'AND departmentid IN (SELECT departmentno FROM officecenter.dbo.department_filter)";
$query5 = sqlsrv_query($conn, $sql);
   
// สร้างคำสั่ง SQL สำหรับการเพิ่มข้อมูล
$insertSql = "INSERT INTO officecenter.dbo.locker_employee (idcard, InitialT, namethai, surnamethai, nameeng, surnameeng, departmentid,
        lineid, startdate, passdate, enddate, stemployee, newemployee) SELECT idcard, InitialT, namethai, surnamethai, nameeng, surnameeng, departmentid,
        lineid, startdate, passdate, enddate, stemployee, newemployee FROM EuroTraining.dbo.employee 
         WHERE idcard NOT IN (SELECT idcard FROM officecenter.dbo.locker_employee) AND stemployee = 'ok'AND departmentid IN (SELECT departmentno FROM officecenter.dbo.department_filter)";


$query5 = sqlsrv_query($conn, $insertSql);




$sql  = "UPDATE locker_employee SET date_update = GETDATE() ";
$query3 = sqlsrv_query($conn, $sql);   
          
sqlsrv_close($conn);
sqlsrv_close($conn2);
header("Location: admin_locker_new_employee.php");
?>
