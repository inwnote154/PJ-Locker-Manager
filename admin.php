<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'database.php';
    // include 't.php';
    $conn = sqlsrv_connect( $serverName, $connectionOptions);
    if ($conn) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $type = "";
        $sql = "SELECT * FROM locker_userlogin WHERE username = ? AND userpassword = ?";
        $params = array($username, $password);
        $stmt = sqlsrv_query($conn, $sql, $params);
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $_SESSION['admin_type'] = $row['type_login'];
                    $_SESSION['admin']= $row['firstname'];
                    $_SESSION['admin_id'] = $row['userid'];
                    $_SESSION['admin_signature'] = $row['signature'];
               
            }
        if ($stmt !== false) {
        $stmt = sqlsrv_query($conn, $sql, $params);
            
            $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
            if ($row) {
                if($_SESSION['admin_type']===1){
                    header("Location: dashboard.php");
                } 
                elseif($_SESSION['admin_type']===0){
                    header("Location: Manager/dashboard.php");
                }
                // ทำการเข้าสู่ระบบ
            } else {
                $message = "Login Failed";

                // Encode the message for URL
                $encodedMessage = urlencode($message);

                // Redirect to file2.php with the encoded message
                header("Location: login.php?message=$encodedMessage");
            }
        } else {
            echo "เกิดข้อผิดพลาดในการดึงข้อมูล: " . print_r(sqlsrv_errors(), true);
        }

        sqlsrv_close($conn);
    } else {
        echo "ไม่สามารถเชื่อมต่อกับฐานข้อมูลได้";
    }
}
?>
