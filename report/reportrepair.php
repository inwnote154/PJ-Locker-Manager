<?php
include '../database.php';

if ($conn) {
    $type = $_GET['type'];
    $lockernumber = $_GET['lockernumber'];
    $status = 0;
    $statusL = '';

    if($type === 'buddy'){
        $sql = "SELECT * FROM buddy_locker WHERE buddy_number = ?";
        $params = array($lockernumber);
        $stmt = sqlsrv_query($conn, $sql, $params );
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $status = $row['status_buddy'];
        }
        if ($status > 0) {
            $statusL = 'ว่าง';
        }
        else{
            $statusL = 'เต็ม';
        }
        $sql2 = "UPDATE buddy_locker SET UsStatus = ? WHERE buddy_number = ?";
        $params2 = array($statusL,$lockernumber);
        $stmt = sqlsrv_query($conn, $sql2, $params2 );

        $sql = "UPDATE locker_out SET UsStatus = ? WHERE out_number = ?";
        $params = array($statusL,$lockernumber);
        $stmt = sqlsrv_query($conn, $sql, $params );
    }

    if($type === 'shirt'){
        $sql = "SELECT * FROM locker_shirt WHERE shirt_number = ?";
        $params = array($lockernumber);
        $stmt = sqlsrv_query($conn, $sql, $params );
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $status = $row['status_shirt'];
        }
        if ($status > 0) {
            $statusL = 'ว่าง';
        }
        else{
            $statusL = '่เต็ม';
        }
        $sql = "UPDATE locker_shirt SET UsStatus =? WHERE shirt_number = ?";
        $params = array($statusL,$lockernumber);
        $stmt = sqlsrv_query($conn, $sql, $params );
    }

    if($type === 'out'){
        $sql = "SELECT * FROM locker_out WHERE out_number = ?";
        $params = array($lockernumber);
        $stmt = sqlsrv_query($conn, $sql, $params );
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $status = $row['status_out'];
        }
        if ($status > 0) {
            $statusL = 'ว่าง';
        }
        else{
            $statusL = '่เต็ม';
        }
        $sql = "UPDATE locker_out SET UsStatus = ? WHERE out_number = ?";
        $params = array($statusL,$lockernumber);
        $stmt = sqlsrv_query($conn, $sql, $params );

        $sql2 = "UPDATE buddy_locker SET UsStatus = ? WHERE buddy_number = ?";
        $params2 = array($statusL,$lockernumber);
        $stmt = sqlsrv_query($conn, $sql2, $params2 );
    }
    $sql3 = "UPDATE locker_break SET repairdate = GETDATE() WHERE typelocker = ? AND lockernumber = ? AND repairdate IS NULL";
    $params3 = array($type,$lockernumber);
    $stmt = sqlsrv_query($conn, $sql3, $params3);

    if ($stmt !== false ) {
        
    } else {
        echo "ไม่สามารถเพิ่มพนักงานได้: " . print_r(sqlsrv_errors(), true);
    }
    if($type === 'buddy'){
        header('Location:../Buddy/lockerbuddy.php?message4=4');
    }
    if($type === 'out'){
        header('Location:../Out/lockerout.php?message4=4');
    }
    if($type === 'shirt'){
        header('Location:../Shirt/lockershirt.php?message4=4');
    }
    sqlsrv_close($conn);
    
    // header('Location:'.$_SERVER['HTTP_REFERER']);
} else {
    echo "ไม่สามารถเชื่อมต่อกับฐานข้อมูลได้";
}
// exit();
?>