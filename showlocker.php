<?php
include 'database.php';
//$selection = $_POST['selection']
//$selectionID = $_POST['selectionID']
//$employeeID = $_POST["employeeID"]

if( $conn ) {
    function rowcount($sql,$stmt,$type){
        $rowcount =0;
        if($type === 'buddy'){
            $type = 'status_buddy';
        }
        elseif($type === 'shirt'){
            $type = 'status_shirt';
        }
        elseif($type === 'out'){
            $type = 'status_out';
        }
        
        while ($row = sqlsrv_fetch_array($stmt,SQLSRV_FETCH_ASSOC)) {
         $rowcount+=$row[$type];
        }
        return $rowcount;
    }
    $sql = "SELECT * FROM buddy_locker WHERE build_id = 1
        ";
    $stmt = sqlsrv_query($conn, $sql);
    $buddy = rowcount($sql,$stmt,'buddy');
  

    $sql = "SELECT * FROM buddy_locker WHERE UsStatus = 'ว่าง' AND build_id = 1
    ";
        $stmt = sqlsrv_query($conn, $sql);
        $buddy_a = rowcount($sql,$stmt,'buddy');

    $sql = "SELECT * FROM buddy_locker WHERE build_id = 2
        ";
    $stmt = sqlsrv_query($conn, $sql);
    $buddy2 = rowcount($sql,$stmt,'buddy');
  
    $sql = "SELECT * FROM buddy_locker WHERE UsStatus = 'ว่าง' AND build_id = 2
    ";
        $stmt = sqlsrv_query($conn, $sql);
        $buddy_b=rowcount($sql,$stmt,'buddy');
        $sql = "SELECT * FROM buddy_locker WHERE UsStatus = 'ชำรุด' 
        "; 
        $stmt = sqlsrv_query($conn, $sql);
        $buddy_break = rowcount($sql,$stmt,'buddy');

    $p_buddy_a = 100-round($buddy_a/($buddy)*100);
    $p_buddy_b = 100-round($buddy_b/($buddy2)*100);


    $sql = "SELECT * FROM locker_out WHERE build_id = 1
        ";
        $stmt = sqlsrv_query($conn, $sql);
        $out = rowcount($sql,$stmt,'out');

    $sql = "SELECT * FROM locker_out WHERE UsStatus = 'ว่าง' AND build_id = 1
    ";
        $stmt = sqlsrv_query($conn, $sql);
        $out_a=rowcount($sql,$stmt,'out');
    
        $sql = "SELECT * FROM locker_out WHERE build_id = 2
        ";
        $stmt = sqlsrv_query($conn, $sql);
        $out2 = rowcount($sql,$stmt,'out');
    $sql = "SELECT * FROM locker_out WHERE UsStatus = 'ว่าง' AND build_id = 2
    ";
        $stmt = sqlsrv_query($conn, $sql);
        $out_b =rowcount($sql,$stmt,'out');
        $sql = "SELECT * FROM locker_out WHERE UsStatus = 'ชำรุด' 
        ";
            $stmt = sqlsrv_query($conn, $sql);
            $out_break =rowcount($sql,$stmt,'out'); 
    $p_out_a = 100-round($out_a/($out)*100);
    $p_out_b = 100-round($out_b/($out2)*100);
    $sql = "SELECT * FROM locker_shirt WHERE build_id = 1
        ";
        $stmt = sqlsrv_query($conn, $sql);
        $locker=rowcount($sql,$stmt,'shirt');

    $sql = "SELECT * FROM locker_shirt WHERE UsStatus = 'ว่าง' AND build_id = 1
    ";
        $stmt = sqlsrv_query($conn, $sql);
        $locker_a=rowcount($sql,$stmt,'shirt');
        $sql = "SELECT * FROM locker_shirt WHERE build_id = 2
        ";
        $stmt = sqlsrv_query($conn, $sql);
        $locker2=rowcount($sql,$stmt,'shirt');
    $sql = "SELECT * FROM locker_shirt WHERE UsStatus = 'ว่าง' AND build_id = 2
    ";
        $stmt = sqlsrv_query($conn, $sql);
        $locker_b=rowcount($sql,$stmt,'shirt');

        $sql = "SELECT * FROM locker_shirt WHERE build_id = 4
        ";
        $stmt = sqlsrv_query($conn, $sql);
        $locker4=rowcount($sql,$stmt,'shirt');
    $sql = "SELECT * FROM locker_shirt WHERE UsStatus = 'ว่าง' AND build_id = 4
    ";
        $stmt = sqlsrv_query($conn, $sql);

        $locker_d=rowcount($sql,$stmt,'shirt');
        $sql = "SELECT * FROM locker_shirt WHERE build_id = 5
        ";
        $stmt = sqlsrv_query($conn, $sql);
        $locker5=rowcount($sql,$stmt,'shirt');
    $sql = "SELECT * FROM locker_shirt WHERE UsStatus = 'ว่าง' AND build_id = 5
        ";
        $stmt = sqlsrv_query($conn, $sql);
     
        $locker_e=rowcount($sql,$stmt,'shirt');
        $sql = "SELECT * FROM locker_shirt WHERE build_id = 6
        ";
        $stmt = sqlsrv_query($conn, $sql);
        $locker6=rowcount($sql,$stmt,'shirt');
    $sql = "SELECT * FROM locker_shirt WHERE UsStatus = 'ว่าง' AND build_id = 6
    ";
        $stmt = sqlsrv_query($conn, $sql);
        $locker_f=rowcount($sql,$stmt,'shirt');
        $sql = "SELECT * FROM locker_shirt WHERE UsStatus = 'ชำรุด'
        ";
            $stmt = sqlsrv_query($conn, $sql);
            $locker_break=rowcount($sql,$stmt,'shirt');
 

    $p_locker_a = 100-round($locker_a/($locker)*100);
    $p_locker_b = 100-round($locker_b/($locker2)*100);
    $p_locker_d = 100-round($locker_d/($locker4)*100);
    $p_locker_e = 100-round($locker_e/($locker5)*100);
    $p_locker_f = 100-round($locker_f/($locker6)*100);

    // ปิดการเชื่อมต่อ
    sqlsrv_close($conn);
} else {
    echo "การเชื่อมต่อไม่สำเร็จ";
}
?></body>
</html>