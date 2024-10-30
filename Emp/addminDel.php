<?php
session_start();
include '../database.php';
$admin = $_SESSION['admin'];

if ($conn) {
    // $id = $_POST["username"]; // ลบข้อมูลพนักงานที่มี ID = 1
    $id = $_GET['id'];
    $sql = "UPDATE locker_employee SET enddate = GETDATE(),stemployee = 'no' WHERE idcard = ?";
    $params = array($id);
    $stmt = sqlsrv_query($conn, $sql, $params);
    
    $sql2 = "SELECT * FROM Accesslog WHERE EmployeeID = ? AND StatusEm = 'active'";
    $params2 = array($id);
    $stmt2 = sqlsrv_query($conn, $sql2, $params2 );
    while ($row = sqlsrv_fetch_array($stmt2, SQLSRV_FETCH_ASSOC)) {
        $sql = "SELECT * FROM buddy_locker WHERE buddy_number = ?";
        $params = array($row['LockerNumber']);
        $stmt = sqlsrv_query($conn, $sql, $params );
        while ($rows = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $status = $rows['status_buddy']+1;
        }
        if ($status > 0) {
            $statusL = 'ว่าง';
            
        }
        elseif ($status === 0) {
            $statusL = 'เต็ม';
        }

        $sql2 = "UPDATE buddy_locker SET status_buddy = ?,UsStatus = ? WHERE buddy_number = ?";
        $params2 = array($status,$statusL, $row['LockerNumber']);
        $stmt2 = sqlsrv_query($conn, $sql2, $params2 );
        
        $sql3 = "UPDATE AccessLog SET ExitDate = GETDATE(),StatusEm = 'inactive',userout = ? WHERE EmployeeID = ? AND LockerNumber = ? AND TypeLocker = 'buddy'";
        $params3 = array($admin,$Id,$row['LockerNumber']);
        $stmt3 = sqlsrv_query($conn, $sql3, $params3 );

        $sql2 = "UPDATE locker_out SET status_out = ?,UsStatus = ? WHERE out_number = ?";
        $params2 = array($status,$statusL, $row['LockerNumber']);
        $stmt2 = sqlsrv_query($conn, $sql2, $params2 );
        
        $sql3 = "UPDATE AccessLog SET ExitDate = GETDATE(),StatusEm = 'inactive',userout = ? WHERE EmployeeID = ? AND LockerNumber = ? AND TypeLocker = 'out'";
        $params3 = array($admin,$Id,$row['LockerNumber']);
        $stmt3 = sqlsrv_query($conn, $sql3, $params3 );
        
        $sql = "SELECT * FROM locker_shirt WHERE shirt_number = ?";
        $params = array($row['LockerNumber']);
        $stmt = sqlsrv_query($conn, $sql, $params );

        while ($rows = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $status = $rows['status_shirt']+1;
        }
        if ($status > 0) {
            $statusL = 'ว่าง';
            
        }
        elseif ($status === 0) {
            $statusL = 'เต็ม';
        }

        $sql2 = "UPDATE locker_shirt SET status_shirt = ?,UsStatus = ? WHERE shirt_number = ?";
        $params2 = array($status,$statusL, $row['LockerNumber']);
        $stmt2 = sqlsrv_query($conn, $sql2, $params2 );
        
        $sql3 = "UPDATE AccessLog SET ExitDate = GETDATE(),StatusEm = 'inactive',userout = ? WHERE EmployeeID = ? AND LockerNumber = ? AND TypeLocker = 'shirt'";
        $params3 = array($admin,$Id,$row['LockerNumber']);
        $stmt3 = sqlsrv_query($conn, $sql3, $params3 );
    }
    


    if ($stmt !== false) {
        echo "ลบข้อมูลพนักงานเรียบร้อยแล้ว";
        $message = "success";

        // Encode the message for URL
        $encodedMessage = urlencode($message);

        // Redirect to file2.php with the encoded message
        header("Location: showEmployee.php?message=$encodedMessage");
    } else {
        echo "ไม่สามารถลบข้อมูลพนักงานได้: " . print_r(sqlsrv_errors(), true);
    }

    sqlsrv_close($conn);
} else {
    echo "ไม่สามารถเชื่อมต่อกับฐานข้อมูลได้";
}
?>
