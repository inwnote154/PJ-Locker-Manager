<?php
include '../database.php';
session_start();
$id_selection = $_SESSION['id_selection'];

    $sql = "SELECT COUNT(*)AS total FROM AuditData1 WHERE format_id = '$id_selection'";
    $stmt = sqlsrv_query($conn,$sql);
    $rowcount = sqlsrv_fetch_array($stmt,SQLSRV_FETCH_ASSOC);
    $rowcount3 = $rowcount['total'];

    $sql2 = "SELECT COUNT(*)AS total FROM AuditData1 WHERE format_id = '$id_selection' AND enddate IS NOT NULL";
    $stmt2 = sqlsrv_query($conn,$sql2);
    $rowcount2 = sqlsrv_fetch_array($stmt2,SQLSRV_FETCH_ASSOC);
    
    $count = 1;
    
    if($rowcount2['total']==$rowcount3){
        $sql3 = "SELECT * FROM AuditData1 WHERE format_id = '$id_selection' "; 
        $stmt3 = sqlsrv_query($conn,$sql3);
        
        while ($row = sqlsrv_fetch_array($stmt3, SQLSRV_FETCH_ASSOC)) {
            $sql4 = "UPDATE format_audit SET staudit = 'ok',finishdate = GETDATE() WHERE ID = ?  ";
            $params = array($id_selection);
            $stmt4 = sqlsrv_query($conn,$sql4,$params);
        }
        header("Location:auditresult.php");
    }
    else{
        header("Location:auditShow.php?message=unfinish&id_selection=".$id_selection);
        // echo $rowcount2['total'].'ยังใส่ไม่ครบ'.$rowcount3;
        // header("Location:auditShow.php?id_selection=$id_selection");
    }



?>