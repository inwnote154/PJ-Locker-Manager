<?php
$serverName = "192.168.16.16"; // ชื่อเซิร์ฟเวอร์ของคุณ
$connectionOptions = array(
    "Database" => "officecenter", // ชื่อฐานข้อมูล
    "Uid" => "sa", // ชื่อผู้ใช้ฐานข้อมูล
    "PWD" => "Eur@Admin", // รหัสผ่านฐานข้อมูล
    "CharacterSet" => "UTF-8"
);

// เชื่อมต่อกับฐานข้อมูล MSSQL
$conn = sqlsrv_connect($serverName, $connectionOptions);
if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}
?>