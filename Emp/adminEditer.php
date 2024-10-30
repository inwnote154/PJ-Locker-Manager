<?php
include '../database.php';
if ($conn) {
    $employeeId = $_POST['employee_id'];
    $employeeIn = $_POST['employee_in'];
    $employeeName = $_POST['employee_name'];
    $employeeSurName = $_POST['employee_sur'];
    $employeePosition = $_POST['employee_depart'];
    $employeeLineID = $_POST['employee_line'];
    $departname = $_POST['departname'];

    $sql = "UPDATE locker_employee SET InitialT = ?
    ,namethai= ?
    ,surnamethai= ?
    ,departmentid = ?
    ,lineid = ?  WHERE idcard = ?";
    $params = array($employeeIn ,  $employeeName ,$employeeSurName, $employeePosition,$employeeLineID,$employeeId);
    $stmt = sqlsrv_query($conn, $sql, $params);


    if ($stmt !== false) {
        echo "แก้ไขข้อมูลพนักงานเรียบร้อยแล้ว";
        $message = "success";

        // Encode the message for URL
        $encodedMessage = urlencode($message);

        // Redirect to file2.php with the encoded message

        header("Location: detailemployeeAdmin.php?id=$employeeId&message=$encodedMessage&in=$employeeIn&sur=$employeeSurName&name=$employeeName&departid=$employeePosition&line=$employeeLineID&departname=$departname ");
    } else {
        echo "ไม่สามารถแก้ไขข้อมูลพนักงานได้: ".print_r(sqlsrv_errors(), true);
    }

    sqlsrv_close($conn);
} else {
    echo "ไม่สามารถเชื่อมต่อกับฐานข้อมูลได้";
}
?>