<?php
include '../database.php';

if ($conn) {
    $stat = $_POST['stat'];
    $status = $_POST['status'];
    $type = $_POST['type'];
    $number = $_POST['number'];
    $admin = $_SESSION['admin'];
    $sql2 = "SELECT COUNT(*)AS total FROM Accesslog WHERE LockerNumber = '$number'AND TypeLocker = '$type' AND StatusEm = 'active'";
    $stmt2 = sqlsrv_query($conn,$sql2);
    $rowcount2 = sqlsrv_fetch_array($stmt2,SQLSRV_FETCH_ASSOC);
    $check = $stat;
    $stat-= $rowcount2['total'];
    if($stat < 0){
                $stat = $status+0;
            }    
        if($type==='buddy'){
            
            if ($stat > 0) {
                $statusL = 'ว่าง';   
            }
            elseif ($stat === 0) {
                $statusL = 'เต็ม';
            }
            
            $sql = "UPDATE buddy_locker SET status_buddy = ?,UsStatus = ? WHERE buddy_number = ?";
            $params = array($stat,$statusL, $number);
            $stmt = sqlsrv_query($conn, $sql, $params );
            
            $sql2 = "UPDATE locker_out SET status_out = ?,UsStatus = ? WHERE out_number = ?";
            $params2 = array($stat,$statusL, $number);
            $stmt = sqlsrv_query($conn, $sql2, $params2 );
            if ($stmt !== false ) {
                header("Location:../Buddy/showbuddy.php?employee_buddy=$number&status=$stat");
            } else {
                echo "ไม่สามารถเพิ่มพนักงานได้: " . print_r(sqlsrv_errors(), true);
            }
        }
        elseif($type==='shirt'){
            if ($stat > 0) {
                $statusL = 'ว่าง';   
            }
            elseif ($stat === 0) {
                $statusL = 'เต็ม';
            }
            
            $sql = "UPDATE locker_shirt SET status_shirt= ?,UsStatus = ? WHERE shirt_number = ?";
            $params = array($stat,$statusL, $number);
            $stmt = sqlsrv_query($conn, $sql, $params );
            if ($stmt !== false ) {
                header("Location:../Shirt/showshirt.php?employee_shirt=$number&status=$stat");
            } else {
                echo "ไม่สามารถเพิ่มพนักงานได้: " . print_r(sqlsrv_errors(), true);

            }
        }
        elseif($type==='out'){
            if ($stat > 0) {
                $statusL = 'ว่าง';   
            }
            elseif ($stat === 0) {
                $statusL = 'เต็ม';
            }
            
            $sql = "UPDATE buddy_locker SET status_buddy = ?,UsStatus = ? WHERE buddy_number = ?";
            $params = array($stat,$statusL, $number);
            $stmt = sqlsrv_query($conn, $sql, $params );
            
            $sql2 = "UPDATE locker_out SET status_out = ?,UsStatus = ? WHERE out_number = ?";
            $params2 = array($stat,$statusL, $number);
            $stmt = sqlsrv_query($conn, $sql2, $params2 );
            if ($stmt !== false ) {
                header("Location:../Out/showoutlocker.php?employee_out=$number&status=$stat");
            } else {
                echo "ไม่สามารถเพิ่มพนักงานได้: " . print_r(sqlsrv_errors(), true);
            }
            
        

    }
    sqlsrv_close($conn);

} else {
    echo "ไม่สามารถเชื่อมต่อกับฐานข้อมูลได้";
}
// exit();
?>