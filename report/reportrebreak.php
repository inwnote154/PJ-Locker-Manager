<?php
include '../database.php';
session_start();

if ($conn) {
    
    $admin = $_SESSION['admin'];
    $type = $_POST['type'];
    $lockernumber = $_POST['lockernumber'];
    echo $lockernumber;
    $detail = $_POST['detail'];
    $count = 0;
    $sql = "SELECT Accesslog.*,locker_employee.* FROM Accesslog 
    LEFT JOIN locker_employee ON Accesslog.EmployeeID = locker_employee.idcard
    WHERE LockerNumber = ? AND StatusEm = 'active'AND TypeLocker = ? ";
    $params = array($lockernumber,$type);
    $stmt = sqlsrv_query($conn, $sql, $params );
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $count++;
    }
    if($count===0){
        if($type === 'buddy' || $type === 'out'){
            $sql = "UPDATE buddy_locker SET UsStatus = 'ชำรุด' WHERE buddy_number = ?";
            $params = array($lockernumber);
            $stmt = sqlsrv_query($conn, $sql, $params);

            $sql = "UPDATE locker_out SET UsStatus = 'ชำรุด' WHERE out_number = ?";
            $params = array($lockernumber);
            $stmt = sqlsrv_query($conn, $sql, $params );
        }
        if($type === 'shirt'){
            $sql = "UPDATE locker_shirt SET UsStatus ='ชำรุด' WHERE shirt_number = ?";
            $params = array($lockernumber);
            $stmt = sqlsrv_query($conn,$sql, $params );
        }
    

            
    
        
        $sql2 = "INSERT INTO locker_break (breakdate,userreport,detail,lockernumber,typelocker) VALUES (GETDATE(),?,?,?,?)";
        $params2 = array($admin,$detail,$lockernumber,$type);
        $stmt2 = sqlsrv_query($conn, $sql2, $params2 );
        echo $lockernumber;
        if ($stmt !== false ) {
        
        } else {
            echo "ไม่สามารถเพิ่มพนักงานได้: " . print_r(sqlsrv_errors(), true);
        }

        sqlsrv_close($conn);
        if($type === 'buddy'){
            header('Location:../Buddy/lockerbuddy.php');
        }
        if($type === 'out'){
            header('Location:../Out/lockerout.php');
        }
        if($type === 'shirt'){
            header('Location:../Shirt/lockershirt.php');
        }
    }
    else{
        header('Location:'.$_SERVER['HTTP_REFERER']);
    }
} else {
    echo "ไม่สามารถเชื่อมต่อกับฐานข้อมูลได้";
}
// exit();
?>
