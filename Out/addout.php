<?php
session_start();
include '../database.php';

if ($conn) {
    $admin = $_SESSION['admin'];
    $adminid = $_SESSION['admin_id'];
    $employeeId = $_POST['employee_id'];
    $employeeBuddy = $_POST['employee_buddy'];
    $Startstatus = $_POST['Startstatus'];
    $status = 0;
    $statusO = 0;
    $statusL = '';

    $sqlcheck = "SELECT * FROM locker_employee WHERE idcard = '$employeeId' ";
    $stmt = sqlsrv_query($conn, $sqlcheck );
    $rowcheck = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    if($rowcheck){
        $sqlcheck = "SELECT * FROM Accesslog WHERE EmployeeID = ? AND StatusEm = 'active' AND TypeLocker = 'out'";
        $paramscheck = array($employeeId);
        $option = array("Scrollable"=>SQLSRV_CURSOR_KEYSET);
        $result = sqlsrv_query($conn, $sqlcheck, $paramscheck ,$option);  
        if(sqlsrv_num_rows($result)>0){
            header('Location:showoutlocker.php?message2=1&employee_out='.$employeeBuddy.'&status='.$Startstatus);
        }else{ 
            $sql = "SELECT * FROM buddy_locker WHERE buddy_number = ?";
            $params = array($employeeBuddy);
            $stmt = sqlsrv_query($conn, $sql, $params );

            $sql6 = "SELECT * FROM locker_out WHERE out_number = ?";
            $params6 = array($employeeBuddy);
            $stmt6 = sqlsrv_query($conn, $sql6, $params6 );
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                $status = $row['status_buddy']-1;
            }
            while ($row = sqlsrv_fetch_array($stmt6, SQLSRV_FETCH_ASSOC)) {
                $statusO = $row['status_out']-1;
            }

            if ($status > 0) {
                $statusL = 'ว่าง';
                $sql2 = "UPDATE buddy_locker SET status_buddy = ?,UsStatus = ? WHERE buddy_number = ?";
                $params2 = array($status,$statusL, $employeeBuddy);
                $stmt2 = sqlsrv_query($conn, $sql2, $params2 );
            
                $sql3 = "INSERT INTO AccessLog (EntryDate,EmployeeID,LockerNumber,TypeLocker,StatusEm,userin,userinid) VALUES (GETDATE(), ?,?,'buddy','active',?,?)";
                $params3 = array($employeeId,$employeeBuddy,$admin,$adminid);
                $stmt3 = sqlsrv_query($conn, $sql3, $params3 );

                $sql4 = "UPDATE locker_out SET status_out = ?,UsStatus = ? WHERE out_number = ?";
                $params4 = array($statusO,$statusL, $employeeBuddy);
                $stmt4= sqlsrv_query($conn, $sql4, $params4 );
            
                $sql5 = "INSERT INTO AccessLog (EntryDate,EmployeeID,LockerNumber,TypeLocker,StatusEm,userin,userinid) VALUES (GETDATE(), ?,?,'out','active',?,?)";
                $params5 = array($employeeId,$employeeBuddy,$admin,$adminid);
                $stmt5 = sqlsrv_query($conn, $sql5, $params5); 

                
            }
            elseif ($status === 0) {
                $statusL = 'เต็ม';
                $sql2 = "UPDATE buddy_locker SET status_buddy = ?,UsStatus = ? WHERE buddy_number = ?";
                $params2 = array($status,$statusL, $employeeBuddy);
                $stmt2 = sqlsrv_query($conn, $sql2, $params2 );
            
                $sql3 = "INSERT INTO AccessLog (EntryDate,EmployeeID,LockerNumber,TypeLocker,StatusEm,userin,userinid) VALUES (GETDATE(), ?,?,'buddy','active',?,?)";
                $params3 = array($employeeId,$employeeBuddy,$admin,$adminid);
                $stmt3 = sqlsrv_query($conn, $sql3, $params3);

                $sql4 = "UPDATE locker_out SET status_out = ?,UsStatus = ? WHERE out_number = ?";
                $params4 = array($statusO,$statusL, $employeeBuddy);
                $stmt4= sqlsrv_query($conn, $sql4, $params4 );
            
                $sql5 = "INSERT INTO AccessLog (EntryDate,EmployeeID,LockerNumber,TypeLocker,StatusEm,userin,userinid) VALUES (GETDATE(), ?,?,'out','active',?,?)";
                $params5 = array($employeeId,$employeeBuddy,$admin,$adminid);
                $stmt5 = sqlsrv_query($conn, $sql5, $params5); 
            }
            
            


            
            if ($stmt !== false ) {
                if (isset($_POST['AllEdit'])){
                    header('Location:../Emp/admin_locker_new_employee.php');
                }else{
                    header('Location:showoutlocker.php?message1=1&employee_out='.$employeeBuddy.'&status='.$status);
                }
                // echo "เพิ่มพนักงานเรียบร้อยแล้ว";
                // echo("asd".$status);
            } else {
                header('Location:showoutlocker.php?message2=1&employee_out='.$employeeBuddy.'&status='.$Startstatus);
                // echo "ไม่สามารถเพิ่มพนักงานได้: " . print_r(sqlsrv_errors(), true);
            }
        }
    }else{
        header('Location:showoutlocker.php');
    }

    sqlsrv_close($conn);
} else {
    echo "ไม่สามารถเชื่อมต่อกับฐานข้อมูลได้";
}
// exit();
?>