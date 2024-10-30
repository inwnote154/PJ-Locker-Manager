<?php
    include '../database.php';
    session_start();
    $admin = $_SESSION['admin'];
    if (isset($_POST['selection'])){
        $selection = $_POST['selection'];
        $build = $_POST['build'];
        $type = $_POST['type'];
        $sex = $_POST['sex'];
        $choose = $_POST['choose'];
    }
    if (isset($_GET['selection'])){
        $selection = $_GET['selection'];
        $build = $_GET['build'];
        $type = $_GET['type'];
        $sex = $_GET['sex'];
        $choose = $_GET['choose'];

    }
    if( $conn ) {
        $sqlCheck = "SELECT * FROM format_audit WHERE build = ? AND selection = ? AND typeaudit  =? AND sex = ? AND YEAR(createdate) = YEAR(GETDATE()) AND MONTH(createdate) = MONTH(GETDATE())";
        $params = array($build,$selection,$type ,$sex);
        $stmtCheck = sqlsrv_query($conn, $sqlCheck, $params);

        if ($stmtCheck === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        if (sqlsrv_has_rows($stmtCheck)) {
            // Data already exists, do not insert 
                header("Location:auditresult.php?message=havedata");
                echo "Data already exists, not inserted.";
        } else {
                if($selection == 1){
                $sql ="SELECT * FROM auditmain WHERE StatusEm = 'active' AND stemployee = 'ok'
                AND build_id = '$build' AND InitialT LIKE '$sex%' AND TypeLocker = '$type' ";
                $stmt = sqlsrv_query($conn, $sql );}
                else{
                $sql ="SELECT COUNT(*) AS total FROM auditmain WHERE StatusEm = 'active'  and stemployee = 'ok'
                AND build_id = '$build' AND InitialT LIKE '$sex%' AND TypeLocker = '$type'    ";
                $stmt = sqlsrv_query($conn, $sql );
                $rowcount = sqlsrv_fetch_array($stmt,SQLSRV_FETCH_ASSOC);
                $rowcount2= ceil($rowcount['total']*0.5);
                $sql ="SELECT TOP $rowcount2 *  FROM auditmain WHERE StatusEm = 'active' AND stemployee = 'ok'
                AND build_id = '$build' AND InitialT LIKE '$sex%' AND TypeLocker = '$type' ORDER BY RAND() ";
                $stmt = sqlsrv_query($conn, $sql );
                }
                if (!(sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC))) {
                header("Location:auditresult.php?message=nonedata");
                echo "ไม่มีข้อมูล".$rowcount2;
                }else{
                    $sql2 = "INSERT INTO format_audit (createdate ,typeaudit ,sex,selection,build,staudit,auditchoose)
                    VALUES (GETDATE(),?,?,?,?,'process',?)";
                    $params2 = array($type,$sex,$selection,$build,$choose);
                    $stmt2 =sqlsrv_query($conn,$sql2,$params2);
                    $stmt = sqlsrv_query($conn, $sql );
                while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                    echo $row['LockerNumber'];

                    $sql2 = "SELECT TOP 1 ID AS max_id FROM format_audit ORDER BY ID DESC";
                    $stmt2 =sqlsrv_query($conn,$sql2);
                    $max = sqlsrv_fetch_array($stmt2, SQLSRV_FETCH_ASSOC);

                    $sql2 = "INSERT INTO AuditData (startdate ,lockernumber ,userid,auditname,format_id)
                    VALUES (GETDATE(),?,?,?,?)";
                    $params2 = array($row['LockerNumber'],$row['idcard'],$admin,$max['max_id']);
                    $stmt2 =sqlsrv_query($conn,$sql2,$params2);

                    $sql2 = "INSERT INTO check_audit (form_id)VALUES('1')";
                    $stmt2 =sqlsrv_query($conn,$sql2);
                }
                echo $rowcount2;
                header("Location:auditresult.php");
            }
             }
        }

?>