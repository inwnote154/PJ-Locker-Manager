<?php
include '../database.php';
$sql = "SELECT q.*,l.* FROM quit_locker_employee q 
JOIN employee AS l ON q.idcard = l.idcard ";
$stmt = sqlsrv_query($conn, $sql);
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $entryDate = $row['date_update'] !== null ? $row['date_update']->format('Y-m-d') : '';
        echo "<tr class='border-end border-start p-2'><td class='border-end border-start p-2'>" . $entryDate . "</td>";
        echo "<td class='border-end border-start p-2'>" . $row['idcard'] . "</td>";
        echo "<td class='border-end border-start p-2'>" . $row['namethai'] ." "  . $row['surnamethai'] ."</td>";
        echo "<td class='border-end border-start p-2'>" . $row['departmentname'] . "</td>";
        echo "<td class='border-end border-start p-2'>" . $row['linename'] . "</td>";
        echo "</td></tr><br>";
    }
?>