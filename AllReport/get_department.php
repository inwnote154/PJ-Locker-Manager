<?php
// Connect to your MSSQL database
include '../database.php';

// Check connection
if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Fetch cities based on selected employee
$employee_id = $_POST['department_id'];
$sql = "SELECT * FROM employee WHERE departmentno = ?";
$params = array($employee_id);
$stmt = sqlsrv_query($conn, $sql, $params);

// Populate dropdown with cities
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}
echo "<option value='' disabled>เลือกพนักงงาน</option>";
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    echo "<option value='".$row['idcard']."'>".$row['idcard']."</option>";
}

// Close connection
sqlsrv_close($conn);
?>
