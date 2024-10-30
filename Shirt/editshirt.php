<?php
include '../database.php';

if ($conn) {
    session_start();
    $employeeId = $_GET['employee_id'];
    $employeeshirt = $_GET['employee_shirt'];
    $admin = $_SESSION['admin'];
    $adminid = $_SESSION['admin_id'];
    $status = 0;
    $statusL = '';
    
    $sql = "SELECT * FROM locker_shirt WHERE shirt_number = ?";
    $params = array($employeeshirt);
    $stmt = sqlsrv_query($conn, $sql, $params );
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $status = $row['status_shirt']+1;
    }
    if ($status > 0) {
        $statusL = 'ว่าง';
        
    }
    elseif ($status === 0) {
        $statusL = 'เต็ม';
    }

    $sql2 = "UPDATE locker_shirt SET status_shirt = ?,UsStatus = ? WHERE shirt_number = ?";
    $params2 = array($status,$statusL, $employeeshirt);
    $stmt2 = sqlsrv_query($conn, $sql2, $params2 );
    
    $sql3 = "UPDATE AccessLog SET ExitDate = GETDATE(),StatusEm = 'inactive',userout = ?,useroutid = ? WHERE EmployeeID = ? AND LockerNumber = ? AND TypeLocker = 'shirt'";
    $params3 = array($admin,$adminid ,$employeeId,$employeeshirt);
    $stmt3 = sqlsrv_query($conn, $sql3, $params3 );

    if ($stmt !== false ) {
        header('Location:showshirt.php?message3=1&employee_shirt='.$employeeshirt.'&status='.$status);
        // echo    $employeeId;
        // echo $employeeshirt ;
    } else {
        echo "ไม่สามารถเพิ่มพนักงานได้: " . print_r(sqlsrv_errors(), true);
    }

    sqlsrv_close($conn);
} else {
    echo "ไม่สามารถเชื่อมต่อกับฐานข้อมูลได้";
}
// exit();
?>