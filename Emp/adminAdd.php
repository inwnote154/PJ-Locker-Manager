<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>test</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../main.css">
  </head>
  <body class="bg-light">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  
<?php
include '../database.php';

if ($conn) {
    $employeeId = $_POST['employee_id'];
    $employeeIn = $_POST['employee_in'];
    $employeeName = $_POST['employee_name'];
    $employeeSurName = $_POST['employee_sur'];
    $employeePosition = $_POST['employee_depart'];
    $employeeLineID = $_POST['employee_line'];
    
    $sqlcheck = "SELECT * FROM locker_employee WHERE idcard = ? AND stemployee = 'ok'";
    $paramscheck = array($employeeId);
    $option = array("Scrollable"=>SQLSRV_CURSOR_KEYSET);
    $result = sqlsrv_query($conn, $sqlcheck, $paramscheck ,$option);  

    if(sqlsrv_num_rows($result)>0){
        echo "ไม่สามารถเพิ่มพนักงานได้: " . print_r(sqlsrv_errors(), true);
        $message1 = "failed";
        $encodedMessage1 = urlencode($message1); // แก้ชื่อตัวแปร
        header("Location: adminAddhome.php?message1=$encodedMessage1");
    }
    else{
        $sql = "INSERT INTO locker_employee (idcard
        ,InitialT
        ,namethai
        ,surnamethai
        ,departmentid
        ,lineid
        ,stemployee) VALUES (?,?,?,?,?,?,'ok')";
        $params = array($employeeId ,$employeeIn ,$employeeName ,$employeeSurName, $employeePosition,$employeeLineID );
        $stmt = sqlsrv_query($conn, $sql, $params);

        // header("Location: addbuddy.php?employee_id=$employeeId&employee_buddy=$employeeBuddy");

        if ($stmt !== false ) {
            echo "เพิ่มพนักงานเรียบร้อยแล้ว";
            $message = "success";
            $encodedMessage = urlencode($message);
            header("Location: adminAddhome.php?message=$encodedMessage");
        } else {
            echo "ไม่สามารถเพิ่มพนักงานได้: " . print_r(sqlsrv_errors(), true);
            $message1 = "failed";
            $encodedMessage1 = urlencode($message1); // แก้ชื่อตัวแปร
            header("Location: adminAddhome.php?message1=$encodedMessage1");
        }
    }
    sqlsrv_close($conn);
} else {
    echo "ไม่สามารถเชื่อมต่อกับฐานข้อมูลได้";
}
?>
</body>
</html>