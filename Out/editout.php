<?php
include '../database.php';

if ($conn) {
    session_start();
    $employeeId = $_GET['employee_id'];
    $employeeout = $_GET['employee_out'];
    $admin = $_SESSION['admin'];
    $adminid = $_SESSION['admin_id'];
    $status = 0;
    $statusL = '';

    
    $sql = "SELECT * FROM locker_out WHERE out_number = ?";
    $params = array($employeeout);
    $stmt = sqlsrv_query($conn, $sql, $params );
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $status = $row['status_out']+1;
    }
    if ($status > 0) {
        $statusL = 'ว่าง';
        
    }
    elseif ($status === 0) {
        $statusL = 'เต็ม';
    }
    $sql2 = "UPDATE buddy_locker SET status_buddy = ?,UsStatus = ? WHERE buddy_number = ?";
    $params2 = array($status,$statusL, $employeeout);
    $stmt2 = sqlsrv_query($conn, $sql2, $params2 );
    
    $sql3 = "UPDATE AccessLog SET ExitDate = GETDATE(),StatusEm = 'inactive',userout = ?,useroutid = ? WHERE EmployeeID = ? AND LockerNumber = ? AND TypeLocker = 'buddy'";
    $params3 = array($admin,$adminid,$employeeId,$employeeout);
    $stmt3 = sqlsrv_query($conn, $sql3, $params3 );

    $sql2 = "UPDATE locker_out SET status_out = ?,UsStatus = ? WHERE out_number = ?";
    $params2 = array($status,$statusL, $employeeout);
    $stmt2 = sqlsrv_query($conn, $sql2, $params2 );
    
    $sql3 = "UPDATE AccessLog SET ExitDate = GETDATE(),StatusEm = 'inactive',userout = ?,useroutid = ? WHERE EmployeeID = ? AND LockerNumber = ? AND TypeLocker = 'out'";
    $params3 = array($admin,$adminid,$employeeId,$employeeout);
    $stmt3 = sqlsrv_query($conn, $sql3, $params3 );

    if ($stmt !== false ) {
        echo    $employeeId;
        echo $employeeout ;
        echo $admin;
        header('Location:showoutlocker.php?message3=1&employee_out='.$employeeout.'&status='.$status);

    } else {
        echo "ไม่สามารถลบพนักงานได้: " . print_r(sqlsrv_errors(), true);
    }

    sqlsrv_close($conn);
} else {
    echo "ไม่สามารถเชื่อมต่อกับฐานข้อมูลได้";
}
// exit();
?>