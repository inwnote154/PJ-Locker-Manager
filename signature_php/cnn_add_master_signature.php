<?php
session_start();
$userid =  $_SESSION['admin_id'];
$folderPath = "../signature/";
$newname = date("YmdHis");
$newdate = date('Y/m/d H:i:s');
$image_parts = explode(";base64,", $_POST['signed']);
$image_type_aux = explode("../signature/", $image_parts[0]);
$image_base64 = base64_decode($image_parts[1]);
$file = $folderPath . $newname . '.png';
$success = file_put_contents($file, $image_base64);
if ($success === false) {
    echo "<script>alert('FAILED TO ADD SIGNATURE');</script>";
    echo "<script>location.href='sign_master.php'</script>";
} else {
    $newname2 =  $newname . '.png';
    include "../database.php";
    $sql = "UPDATE locker_userlogin SET signature = '$newname2' WHERE userid = $userid";
    $result = sqlsrv_query($conn, $sql);
    if ($result === false) {
        echo "<script>alert('FAILED TO QUERY UPDATE TO DATABASE');</script>";
        echo "<script>location.href='sign_master.php'</script>";
    } else {
        $_SESSION['admin_signature'] = $newname2;
        echo "<script>alert('เพิ่มลายเซ็นสำเร็จ');</script>";
        if ($_SESSION['admin_type'] == 0) {
            echo "<script>location.href='../Manager/dashboard.php'</script>";
        }
        if ($_SESSION['admin_type'] == 1) {
            echo "<script>location.href='../dashboard.php'</script>";
        }
        // if ($_SESSION['cb_type'] == 3) {
        //     echo "<script>location.href='maincalibration.php?p=super_dashboard'</script>";
        // }
        // if ($_SESSION['cb_type'] == 4) {
        //     echo "<script>location.href='maincalibration.php?p=manager_dashboard'</script>";
        // }
        // if ($_SESSION['cb_type'] == 5) {
        //     echo "<script>location.href='maincalibration.php?p=super_dashboard'</script>";
        // }
    }
}
