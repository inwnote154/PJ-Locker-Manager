<?php
include '../database.php';
if( $conn ) {
    $sql = "SELECT * FROM employee
    WHERE stemployee = 'ok' AND idcard NOT IN (SELECT idcard FROM Data_locker WHERE TypeLocker = '$locker' )
    ORDER BY idcard ASC;
        ";
    $stmt = sqlsrv_query($conn, $sql);
    
    if ($stmt !== false){
        echo "<thead><tr><th>idcard</th>
        <th>InitialT</th>
        <th>namethai</th>
        <th>surnamethai</th>
        <th>departmentname</th>
        <th>-</th></tr></thead>";
        echo'<tbody>';
        while ($row = sqlsrv_fetch_array($stmt,SQLSRV_FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td class='align-middle'>" . $row['idcard'] . "</td>";
            echo "<td class='align-middle'>" . $row['InitialT'] . "</td>";
            echo "<td class='align-middle'>" . $row['namethai'] . "</td>";
            echo "<td class='align-middle'>" . $row['surnamethai'] . "</td>";
            echo "<td class='align-middle'>" . $row['departmentname'] . "</td>";
            if ($locker=='buddy') {
                echo '<td>
                <a href="../Buddy/adduserbuddy.php?idcard='.$row['idcard'].'&name='.$row['namethai'].' '.$row['surnamethai'].'" class="btn btn-primary btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-plus"></i>
                    </span>
                    <span class="text">เพิ่มพนักงานเข้าตู้ล็อคเกอร์รองเท้าบัดดี้</span>
                </a>
                </td>';
            } else if ($locker=='out') {
                echo '<td>
                <a href="../Out/adduserout.php?idcard='.$row['idcard'].'&name='.$row['namethai'].' '.$row['surnamethai'].'" class="btn btn-primary btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-plus"></i>
                    </span>
                    <span class="text">เพิ่มพนักงานเข้าตู้ล็อคเกอร์รองเท้าภายนอก</span>
                </a>
                </td>';
            } else if ($locker=='shirt') {
                echo '<td>
                <a href="../Shirt/addusershirt.php?idcard='.$row['idcard'].'&name='.$row['namethai'].' '.$row['surnamethai'].'" class="btn btn-primary btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-plus"></i>
                    </span>
                    <span class="text">เพิ่มพนักงานเข้าตู้ล็อคเกอร์ห้องแต่งตัวพนักงาน</span>
                </a>
                </td>';
            }
            echo "</tr>";
        
        }
        echo'</tbody>';
   } else {
        echo "ไม่สามารถดึงข้อมูลได้: " . print_r(sqlsrv_errors(), true);
    }

    // ปิดการเชื่อมต่อ
    sqlsrv_close($conn);
} else {
    echo "การเชื่อมต่อไม่สำเร็จ";
}
?>