<?php
include '../database.php';

$space = $_POST['space'];
$build = $_POST['build'];
    $sql = "SELECT TOP 1 * FROM locker_out WHERE  build_id = ? ORDER BY out_number DESC";
    $params = array($build);
    $stmt = sqlsrv_query($conn, $sql, $params);
    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        if($space>0){
            $status = 'ว่าง';
        }
        elseif($space === 0){
            $status = 'เต็ม';
        }
        $lockernumber = $row['out_number'];
        preg_match('/^([A-Z]+)(\d+)$/', $lockernumber, $matches);
        $letter = $matches[1]; // เก็บตัวอักษร A ไว้
        $number = intval($matches[2]); // เก็บตัวเลข 1000 และแปลงเป็นตัวเลข
        $number += 1; // เพิ่ม 1 เข้าไปในตัวเลข
        $new_number = sprintf('%04d',$number);
        $result = $letter . $new_number;
        
        $sql = "INSERT INTO buddy_locker (buddy_number,status_buddy,UsStatus,build_id)VALUES (?,?,?,?)";
        $params = array($result,$space,$status,$build);
        $stmt = sqlsrv_query($conn, $sql, $params);

        $sql = "INSERT INTO locker_out (out_number,status_out,UsStatus,build_id)VALUES (?,?,?,?)";
        $params = array($result,$space,$status,$build);
        $stmt = sqlsrv_query($conn, $sql, $params);
        header('Location:lockerout.php');
?>
