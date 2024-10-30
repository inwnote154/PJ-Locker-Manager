<?php
session_start();
include '../database.php';

if ($conn) {
    $employeeId = $_POST['employee_id'];
    $employeeshirt = $_POST['employee_buddy'];
    $admin = $_SESSION['admin'];
    $adminid = $_SESSION['admin_id'];
    $Startstatus = $_POST['Startstatus'];
    $status = 0;
    $statusL = '';

    $sqlcheck = "SELECT * FROM locker_employee WHERE idcard = '$employeeId' ";
    $stmt = sqlsrv_query($conn, $sqlcheck );
    $rowcheck = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    if($rowcheck){
    $sqlcheck = "SELECT * FROM Accesslog WHERE EmployeeID = ? AND StatusEm = 'active' AND TypeLocker = 'shirt'";
    $paramscheck = array($employeeId);
    $option = array("Scrollable"=>SQLSRV_CURSOR_KEYSET);
    $resultID = sqlsrv_query($conn, $sqlcheck, $paramscheck ,$option);
    $sqlcheck2 = "SELECT * FROM Accesslog WHERE EmployeeID = ? AND StatusEm = 'active' AND TypeLocker = 'shirt' AND LockerNumber = '$employeeshirt' ";
    $resultID2 = sqlsrv_query($conn, $sqlcheck2, $paramscheck ,$option);

    if(sqlsrv_num_rows($resultID)>1){
            header('Location:showshirt.php?message2=1&employee_shirt='.$employeeshirt.'&status='.$Startstatus);
            // echo "stop";
    }
    elseif(sqlsrv_num_rows($resultID2)>0){
        header('Location:showshirt.php?message2=1&employee_shirt='.$employeeshirt.'&status='.$Startstatus);
    }
    else{
    $sql = "SELECT * FROM locker_shirt WHERE shirt_number = ?";
    $params = array($employeeshirt);
    $stmt = sqlsrv_query($conn, $sql, $params );
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $status = $row['status_shirt']-1;
    }
    if ($status > 0) {
        $statusL = 'ว่าง';
        $sql2 = "UPDATE locker_shirt SET status_shirt = ?,UsStatus = ? WHERE shirt_number = ?";
        $params2 = array($status,$statusL, $employeeshirt);
         $stmt2 = sqlsrv_query($conn, $sql2, $params2 );
    
        $sql3 = "INSERT INTO AccessLog (EntryDate,EmployeeID,LockerNumber,TypeLocker,StatusEm,userin,userinid) VALUES (GETDATE(), ?,?,'shirt','active',?,?)";
        $params3 = array($employeeId,$employeeshirt,$admin,$adminid);
        $stmt3 = sqlsrv_query($conn, $sql3, $params3 );

        
    }
    elseif ($status === 0) {
        $statusL = 'เต็ม';
        $sql2 = "UPDATE locker_shirt SET status_shirt = ?,UsStatus = ? WHERE shirt_number = ?";
        $params2 = array($status,$statusL, $employeeshirt);
         $stmt2 = sqlsrv_query($conn, $sql2, $params2 );
    
        $sql3 = "INSERT INTO AccessLog (EntryDate,EmployeeID,LockerNumber,TypeLocker,StatusEm,userin,userinid) VALUES (GETDATE(), ?,?,'shirt','active',?,?)";
        $params3 = array($employeeId,$employeeshirt,$admin,$adminid);
        $stmt3 = sqlsrv_query($conn, $sql3, $params3); 
    }
    


    
    if ($stmt !== false ) {
        if (isset($_POST['AllEdit'])){
            header('Location:../Emp/admin_locker_new_employee.php');
        }else{
            header('Location:showshirt.php?message1=1&employee_shirt='.$employeeshirt.'&status='.$status);
        }
        //     echo "เพิ่มพนักงานเรียบร้อยแล้ว";
        // echo("asd".$status);
    } else {
            header('Location:showshirt.php?message2=1&employee_shirt='.$employeeshirt.'&status='.$Startstatus);
    }
    }}else{
        header('Location:showshirt.php');
    }

    sqlsrv_close($conn);
} else {
    echo "ไม่สามารถเชื่อมต่อกับฐานข้อมูลได้";
}
// exit();
?>