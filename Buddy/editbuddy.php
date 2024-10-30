?message=<?php
include '../database.php';

if ($conn) {
    session_start();
    $employeeId = $_GET['employee_id'];
    $employeeBuddy = $_GET['employee_buddy'];
    $admin = $_SESSION['admin'];
    $adminid = $_SESSION['admin_id'];
    $status = 0;
    $statusL = '';

    
    $sql = "SELECT * FROM buddy_locker WHERE buddy_number = ?";
    $params = array($employeeBuddy);
    $stmt = sqlsrv_query($conn, $sql, $params );
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $status = $row['status_buddy']+1;
    }
    if ($status > 0) {
        $statusL = 'ว่าง';
        
    }
    elseif ($status === 0) {
        $statusL = 'เต็ม';
    }

    $sql2 = "UPDATE buddy_locker SET status_buddy = ?,UsStatus = ? WHERE buddy_number = ?";
    $params2 = array($status,$statusL, $employeeBuddy);
    $stmt2 = sqlsrv_query($conn, $sql2, $params2 );
    
    $sql3 = "UPDATE AccessLog SET ExitDate = GETDATE(),StatusEm = 'inactive',userout = ?,useroutid = ? WHERE EmployeeID = ? AND LockerNumber = ? AND TypeLocker = 'buddy'";
    $params3 = array($admin,$adminid,$employeeId,$employeeBuddy);
    $stmt3 = sqlsrv_query($conn, $sql3, $params3 );

    $sql2 = "UPDATE locker_out SET status_out = ?,UsStatus = ? WHERE out_number = ?";
    $params2 = array($status,$statusL, $employeeBuddy);
    $stmt2 = sqlsrv_query($conn, $sql2, $params2 );
    
    $sql3 = "UPDATE AccessLog SET ExitDate = GETDATE(),StatusEm = 'inactive',userout = ?,useroutid = ? WHERE EmployeeID = ? AND LockerNumber = ? AND TypeLocker = 'out'";
    $params3 = array($admin,$adminid,$employeeId,$employeeBuddy);
    $stmt3 = sqlsrv_query($conn, $sql3, $params3 );

    if ($stmt !== false ) {
        header('Location:showbuddy.php?message3=1&employee_buddy='.$employeeBuddy.'&status='.$status);
        // echo    $employeeId;
        // echo $employeeBuddy;
    } else {
        echo "ไม่สามารถเพิ่มพนักงานได้: " . print_r(sqlsrv_errors(), true);
    }

    sqlsrv_close($conn);
} else {
    echo "ไม่สามารถเชื่อมต่อกับฐานข้อมูลได้";
}
// exit();
?>